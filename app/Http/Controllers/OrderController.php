<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\BusinessSettings;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Order View')->only(['index']);
        $this->middleware('permission:Order Create')->only(['create', 'store']);
        $this->middleware('permission:Order Edit')->only(['edit', 'update']);
        $this->middleware('permission:Order Delete')->only(['delete']);
    }


    public function index(Request $request)
    {
        if($request->ajax())
        {
            $orders = Transaction::where('transaction_type', 'order')
            ->leftJoin('customers', 'transactions.customer_id', '=', 'customers.id')
            ->orderBy('id', 'DESC')
            ->select('transactions.*', 'customers.name as customer_name', 'customers.contact as customer_contact', 'customers.address as customer_address')->get();
            return DataTables::of($orders)
                ->addColumn('order_info', function($row){
                    return '<div class=""> Invoice: '. $row->invoice_number .'</div>
                        <div>Order Date: '. date("d-M-Y ", strtotime($row->transaction_date)).'</div>
                        <div>Delivery Date: '. date("d-M-Y ", strtotime($row->estimate_delivery_date)).'</div>
                        ';
                })
                ->addColumn('customer_info', function($row){

                    return'<div class="">Customer Name: '. $row->customer_name .'</div>
                    <div>Phone: '. $row->customer_contact .'</div>
                    <div>Address: '. $row->customer_address .'</div>
                    ';

                })

                ->addColumn('payment_info', function($row){

                    return'<div class="">Total Payable: '. $row->total_payable .'</div>
                    <div>Total Paid: '. $row->amount .'</div>
                    ';

                })
                ->editColumn('order_status', function($row){
                    $html ='<div class="d-flex justify-content-around gap-1">';
                    if($row->order_status == 'Order Initialized'){
                         $html .='<button data-data ="'. $row->id.'" class="btn btn-sm btn-danger status_change">'. $row->order_status .'</button>';
                    }
                    else if($row->order_status == 'Order Prepairing'){
                         $html .= '<button data-data ="'. $row->id.'" class="btn btn-sm btn-warning status_change">'. $row->order_status .'</button>';
                    }
                    else if($row->order_status == 'Ready to Deliver'){
                         $html .= '<button data-data ="'. $row->id.'" class="btn btn-sm btn-primary status_change">'. $row->order_status .'</button>';
                         $html .= '<button data-data ="'. $row->id.'" class="btn btn-sm btn-secondary print_pack_slip">Print</button>';
                    }
                    else if($row->order_status == 'Delivered'){
                        $html = '<button data-data ="'. $row->id.'" class="btn btn-sm btn-success status_change mr-1">'. $row->order_status .'</button>';
                    }
                    return $html.= '</div>';
                })

                ->editColumn('paying_status', function($row){
                    if($row->transaction_status == 'due'){
                        return $html = '<button data-data ="'. $row->id.'" class="btn btn-sm btn-warning pay_term">'. $row->transaction_status .'</button>';
                    }
                    else if($row->transaction_status == 'partial'){
                        return $html = '<button data-data ="'. $row->id.'" class="btn btn-sm btn-info pay_term">'. $row->transaction_status .'</button>';
                    }
                    else if($row->transaction_status == 'paid'){
                        return $html = '<button data-data ="'. $row->id.'" class="btn btn-sm btn-success">'. $row->transaction_status .'</button>';
                    }

                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="d-flex justify-content-center gap-1">';
                    $html .= '<div><a class="btn btn-primary btn-sm" href="'. url('/order/edit') . '/'.$row->id.'">Print Invoice</a></div>';
                    if (auth()->user()->can("Order Edit")) {
                        $html .= '<div><a class="btn btn-info btn-sm" href="'. url('/order/edit') . '/'.$row->id.'"> Edit</a></div>';
                    }
                    if (auth()->user()->can("Order Delete")) {
                    $html .= '
                     <form method="POST" action="'.url('/order/delete').'/'.$row->id.'">
                     <input name="_method" type="hidden" value="GET">
                     <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                         data-toggle="tooltip" title="Delete">Delete</button>
                    </form>';
                    }
                    return $html.='</div>';
            })
            ->rawColumns(['order_info', 'customer_info', 'payment_info', 'order_status', 'paying_status', 'action'])
            ->make();
        }

        return view('orders.index');
    }



    public function create(Request $request)
    {
        $customers = Customer::get();
        $categories = ServiceCategory::all();
        if($request->ajax())
        {
            $term = $request->term;
            $category =$request->category;
            $services = Service::
            when($term !== null, function ($query) use ($term) {
                return $query->where('name','LIKE', "%$term%");
            })
            ->when($category !== null, function ($query) use ($category) {
                return $query->where('category_id', $category);
            })->with('category')->paginate(20);

            return view('orders.partials.services',compact('services'));
        }
        return view('orders.partials.add_order', compact('categories', 'customers'));
    }


    public function add_to_cart(Request $request, $id)
    {
        $service = Service::with('category')->where('id', $id)->first();
        $service->row_count = $request->row_count + 1 ;
        $service->qty= 1;
        return view('orders.partials.cart_row', compact('service'))->render();
    }




    public function store(Request $request)
    {
        $validate = $request->validate([
            'customer_id' => ['required'],
            'total_payable' => ['required'],
            'service' => ['required'],
            'order_date' => ['required'],
            'delivery_date' => ['required'],
            'ref_no' => ['nullable', 'unique:transactions,ref_no']
        ],
        [
            'service.required' => 'There Is no Service  Added To cart !',
        ]);


        $transaction = new Transaction;
        if($request->paying_amount == null || $request->paying_amount == 0 ){
            $transaction->amount = $request->total_payable;
        }
        $config = [
            'table' => 'transactions',
            'field' => 'invoice_number',
            'length' => 13,
            'reset_on_prefix_change' => true,
            'prefix' => 'LB'
        ];
        // now use it
        $invoice_number = IdGenerator::generate($config);
        $transaction->total_payable = $request->total_payable;
        $transaction->invoice_number = $invoice_number;
        if($request->ref_no != null){
            $transaction->ref_no = $request->ref_no;
        }else{
            $transaction->ref_no = date('Y-m-d H:i:s');
        }
        if(($request->paying_amount != null ) && ($request->remaining_due != null)){
            $transaction->amount = $request->paying_amount;
            if($request->paying_amount != 0.00){
                $transaction->transaction_status = 'partial';
            }else if($request->paying_amount == $request->total_payable){
                $transaction->transaction_status = 'paid';
            }else{
                $transaction->transaction_status = 'due';
            }

        }else{
            $transaction->transaction_status = 'paid';
        }
        $transaction->transaction_type = 'order';
        $transaction->order_status = 'Order Initialized';
        $transaction->payment_type = 'credit';
        $transaction->customer_id = $request->customer_id;
        $transaction->business_id = Auth::user()->business_id;
        $transaction->created_by = Auth::user()->id;
        $transaction->transaction_date = $request->order_date;
        $transaction->estimate_delivery_date = $request->delivery_date;;
        $transaction->save();

        $order_lines = $request->service;
        foreach($order_lines as $line){
           $order = new Order;
           $order->transaction_id = $transaction->id;
           $order->service_id = $line['service_id'];
           $order->service_quantity = $line['qty'];
           $order->unit_price = $line['price'];
           $order->save();
        }

        $invoice = $this->printInvoice($transaction);
        session()->flash('success', 'Order Created Successfully');

        return \response()->json([
            'success'=> true,
            'invoice' =>$invoice ,
            'message'=>'Order Created Successfully'
        ]);
    }




    public function change_status(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        return view('orders.status_change', compact('transaction'))->render();
    }



    public function update_status(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        $transaction->order_status = $request->status;
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Status Updated Successfully'
        ], 200);
    }



    public function edit(Request $request, $id)
    {
        $transaction = Transaction::with('orders')->with('orders.service')->where('id',$id )->first();
        $row_count = $transaction->orders->count();
        $customers = Customer::get();
        $categories = ServiceCategory::all();
        if($request->ajax())
        {
            $term = $request->term;
            $category =$request->category;
            $services = Service::
            when($term !== null, function ($query) use ($term) {
                return $query->where('name','LIKE', "%$term%");
            })
            ->when($category !== null, function ($query) use ($category) {
                return $query->where('category_id', $category);
            })->paginate(10);

            return view('orders.partials.services',compact('services'));
        }
        return view('orders.partials.edit_order', compact('categories', 'customers', 'transaction', 'row_count'));
    }



    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'customer_id' => ['required'],
            'total_payable' => ['required'],
            'service' => ['required'],
            'order_date' => ['required'],
            'delivery_date' => ['required'],
            'ref_no' => ['nullable', 'unique:transactions,ref_no']
        ],
        [
            'service.required' => 'There Is no Service  Added To cart !',
        ]);

        $transaction = Transaction::find($id);
        if($request->paying_amount == null || $request->paying_amount == 0 ){
            $transaction->amount = $request->total_payable;
        }

        $transaction->total_payable = $request->total_payable;
        if($request->ref_no != null){
            $transaction->ref_no = $request->ref_no;
        }else{
            $transaction->ref_no = date('Y-m-d H:i:s');
        }
        if(($request->paying_amount != null ) && ($request->remaining_due != null)){
            $transaction->amount = $request->paying_amount;
            if($request->paying_amount != 0.00){
                $transaction->transaction_status = 'partial';
            }else if($request->paying_amount == $request->total_payable){
                $transaction->transaction_status = 'paid';
            }else{
                $transaction->transaction_status = 'due';
            }
        }else{
            $transaction->transaction_status = 'paid';
        }
        $transaction->transaction_type = 'order';
        $transaction->order_status = 'Order Initialized';
        $transaction->payment_type = 'credit';
        $transaction->customer_id = $request->customer_id;
        $transaction->created_by = Auth::user()->id;
        $transaction->transaction_date = $request->order_date;
        $transaction->estimate_delivery_date = $request->delivery_date;;
        $transaction->save();
        $order_lines = $request->service;
        $updated_order_ids = [];
        foreach($order_lines as $line){
            if(!empty($line['order_id'])){
                $order = Order::find($line['order_id']);
            }else{
                $order = new Order;
            }
           $order->transaction_id = $transaction->id;
           $order->service_id = $line['service_id'];
           $order->service_quantity = $line['qty'];
           $order->unit_price = $line['price'];
           $order->save();
           array_push($updated_order_ids, $order->id);
        }

        $previous_order_ids = Order::where('transaction_id', $transaction->id)->whereNotIn('id', $updated_order_ids)->get();
        foreach($previous_order_ids as $previous_order_id){
            $previous_order_id->delete();
        }

        $invoice = $this->printInvoice($transaction);
        session()->flash('success', 'Order Updated Successfully');

        return \response()->json([
            'success'=> true,
            'invoice' =>$invoice ,
            'message'=>'Order Created Successfully'
        ]);
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id);
        $previous_order_ids = Order::where('transaction_id', $transaction->id)->get();
        foreach($previous_order_ids as $previous_order_id){
            $previous_order_id->delete();
        }
        $transaction->delete();
        session()->flash('success', 'Order Deleted Successfully');
        return to_route('order');
    }

    public function printInvoice($transaction)
    {
        $transaction = Transaction::where('id',$transaction->id)->with('customer')->with('user')->with('user.business')->first();
        $order_lines = Order::where('transaction_id',$transaction->id)->with('service')->with('service.category')->get();
        return $invoice = view('orders.invoice.classic', compact('order_lines', 'transaction'))->render();
    }



    public function payment($id)
    {
        $transaction = Transaction::find($id);
        return view('orders.payment', compact('transaction'))->render();
    }

    public function update_payment(Request $request, $id)
    {
        $validate = $request->validate([
            'total_Paying' => ['required'],
        ]);
        $transaction = Transaction::find($id);
        $payable = $transaction->total_payable - $transaction->amount;
        if(($request->total_Paying <=  $payable) && ($request->total_Paying != 0.00)){
            if($request->total_Paying <  $payable){
                $transaction->transaction_status = 'partial';
                $transaction->amount += $request->total_Paying;
            }else{
                $transaction->transaction_status = 'paid';
                $transaction->amount += $request->total_Paying;
            }
            $transaction->save();
        }else{
            return response()->json([
                'success'=> false,
                'error' => 'Invalid Payment'
            ],422);
        }

        return response()->json([
            'success'=> true,
            'message' => 'Pyment Successfuully'
        ]);
    }

    

    public function print_pack_slip($id)
    {
        $transaction = Transaction::where('id',$id)->with('customer')->with('user')->with('user.business')->first();
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($transaction->invoice_number, $generator::TYPE_CODE_128);
        $barcodeUrl = 'data:image/png;base64,' . base64_encode($barcode);
       return response()->json([
            'transaction' => $transaction,
            'barcodeUrl'=> $barcodeUrl
       ]);
    }

}
