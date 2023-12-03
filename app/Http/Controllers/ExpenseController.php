<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ExpenseController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Expense View')->only(['index']);
        $this->middleware('permission:Expense Create')->only(['create', 'store']);
        $this->middleware('permission:Expense Edit')->only(['edit', 'update']);
        $this->middleware('permission:Expense Delete')->only(['delete']);
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $expenses = Transaction::where('transaction_type', 'expense')
            ->leftJoin('expenses', 'transactions.id', '=', 'expenses.transaction_id')
            ->leftJoin('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->orderBy('id', 'DESC')
            ->select('transactions.*', 'expenses.expense_title', 'expenses.expense_details', 'expense_categories.name as expense_category_name')->get();

            return DataTables::of($expenses)
                ->addColumn('action', function ($row) {
                    $html = '<div class="d-flex justify-content-center gap-1">';
                    if (auth()->user()->can("Expense Edit")) {
                        $html .= '<div><a class="btn btn-info btn-sm" href="'. url('/expense/edit') . '/'.$row->id.'"> Edit</a></div>';
                    }
                    if (auth()->user()->can("Expense Delete")) {
                    $html .= '
                     <form method="POST" action="'.url('/expense/delete').'/'.$row->id.'">
                     <input name="_method" type="hidden" value="GET">
                     <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                         data-toggle="tooltip" title="Delete">Delete</button>
                    </form>';
                    }
                    return $html.='</div>';
            })
            ->addColumn('payment_info', function($row){
                return'<div class="">Total Payable: '. $row->total_payable .'</div>
                <div>Total Paid: '. $row->amount .'</div>
                ';

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
            ->rawColumns(['expense_title', 'transaction_date', 'paying_status', 'expense_category_name', 'payment_info', 'action'])
            ->make();
        }
        return view('expense.index');
    }



    public function create()
    {
        $expense_categories = ExpenseCategory::all();
        return view('expense.create', compact('expense_categories'));
    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            'expense_title' => ['required'],
            'expense_category' => ['required'],
            'total_payable' => ['required'],
            'paying_amount' => ['required'],
            'transaction_date' => ['required']
        ]);

        $transaction = new Transaction;
        $transaction->total_payable = $request->total_payable;
        $transaction->ref_no = date('Y-m-d H:i:s');
        if($request->paying_amount != null || $request->paying_amount != 0 ){
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
        $transaction->transaction_type = 'expense';
        $transaction->payment_type = 'debit';
        $transaction->business_id = Auth::user()->business_id;
        $transaction->created_by = Auth::user()->id;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->save();


        $expense = new Expense;
        $expense->expense_title=$request->expense_title;
        $expense->transaction_id=$transaction->id;
        $expense->expense_details=$request->expense_details;
        $expense->expense_category_id=$request->expense_category;
        $expense->save();

        return to_route('expense')->with('success', 'Expense Added Successfully');
    }


    public function edit($id)
    {
        $expense_categories = ExpenseCategory::all();
        $transaction = Transaction::leftJoin('expenses', 'transactions.id', '=', 'expenses.transaction_id')->where('transactions.id', $id)
        ->select('transactions.*', 'expenses.expense_title', 'expenses.expense_category_id', 'expenses.expense_details')
        ->first();
        return view('expense.edit', compact('transaction', 'expense_categories'));
    }


    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'expense_title' => ['required'],
            'expense_category' => ['required'],
            'total_payable' => ['required'],
            'paying_amount' => ['required'],
            'transaction_date' => ['required']
        ]);

        $transaction = Transaction::find($id);
        $transaction->total_payable = $request->total_payable;
        $transaction->ref_no = date('Y-m-d H:i:s');
        if($request->paying_amount != null || $request->paying_amount != 0 ){
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
        $transaction->transaction_type = 'expense';
        $transaction->payment_type = 'debit';
        $transaction->created_by = Auth::user()->id;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->save();

        $id = $transaction->id;
        $expense = Expense::where('transaction_id', $id)->first();
        $expense->expense_title = $request->expense_title;
        $expense->transaction_id = $transaction->id;
        $expense->expense_details = $request->expense_details;
        $expense->expense_category_id = $request->expense_category;
        $expense->save();

        return to_route('expense')->with('success', 'Expense Updated Successfully');
    }


    public function delete($id)
    {
        $transaction = Transaction::find($id);
        $expense =  Expense::where('transaction_id',$transaction->id)->first();
        $expense->delete();
        $transaction->delete();

        return to_route('expense')->with('success', 'Expense Deleted Successfully');
    }
}
