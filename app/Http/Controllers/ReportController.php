<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function order_report(Request $request)
    {

        if($request->ajax()){
            $dateString = $request->date;
            $dates = explode(" - ", $dateString);;
            $status = $request->status;
            $orders = Transaction::where('transaction_type', 'order')
            ->leftJoin('customers', 'transactions.customer_id', '=', 'customers.id')
            ->orderBy('id', 'DESC')
            ->when($dateString != null, function ($query) use ($dates) {
                return $query->whereBetween('transactions.transaction_date', $dates);
            })
            ->when($status !== null, function ($query) use ($status) {
                return $query->where('transactions.order_status', $status);
            })
            ->select('transactions.*', 'customers.name as customer_name', 'customers.contact as customer_contact', 'customers.address as customer_address')
            ->get();

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
                    $html ='';
                    if($row->order_status == 'Order Initialized'){
                         $html ='<div  class="bg-danger text-center text-white py-2 rounded shadow">'. $row->order_status .'</div>';
                    }
                    else if($row->order_status == 'Order Prepairing'){
                         $html = '<div  class="text-center text-white py-2 rounded shadow bg-warning">'. $row->order_status .'</div>';
                    }
                    else if($row->order_status == 'Ready to Deliver'){
                         $html = '<div  class="text-center text-white py-2 rounded shadow bg-primary">'. $row->order_status .'</div>';
                    }
                    else if($row->order_status == 'Delivered'){
                        $html = '<div  class="text-center text-white py-2 rounded shadow bg-success mr-1">'. $row->order_status .'</div>';
                    }
                    return $html;
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
        return view('reports.order_report');
    }



    public function profitLoss_report(Request $request)
    {
        if($request->ajax()){
            $dateString = $request->date;
            $dates = explode(" - ", $dateString);;
            $totalSaleSum = (float)Transaction::where('transaction_type', 'order')
            ->when($dateString != null, function ($query) use ($dates) {
                return $query->whereBetween('transactions.transaction_date', $dates);
            })
            ->sum('total_payable');

            $totalExpenseSum = (float)Transaction::where('transaction_type', 'expense')
            ->when($dateString != null, function ($query) use ($dates) {
                return $query->whereBetween('transactions.transaction_date', $dates);
            })
            ->sum('total_payable');

            return response()->json([
                'totalSaleSum'=>$totalSaleSum,
                'totalExpenseSum' => $totalExpenseSum
            ]);

        }

        return view('reports.profit_loss_report');
    }
}
