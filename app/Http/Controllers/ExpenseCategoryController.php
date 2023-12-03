<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Yajra\DataTables\DataTables;

class ExpenseCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Expense Category View')->only(['index']);
        $this->middleware('permission:Expense Category Create')->only(['create', 'store']);
        $this->middleware('permission:Expense Category Edit')->only(['edit', 'update']);
        $this->middleware('permission:Expense Category Delete')->only(['delete']);
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            return DataTables::of(ExpenseCategory::all())
                ->addColumn('action', function ($row) {
                    $html = '<div class="d-flex justify-content-center gap-1">';
                    if (auth()->user()->can("Expense Category Edit")) {
                        $html .= '<div><a class="btn btn-info btn-sm" href="'. url('/expense_category/edit') . '/'.$row->id.'"> Edit</a></div>';
                    }
                    if (auth()->user()->can("Expense Category Delete")) {
                    $html .= '
                     <form method="POST" action="'.url('/expense_category/delete').'/'.$row->id.'">
                     <input name="_method" type="hidden" value="GET">
                     <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                         data-toggle="tooltip" title="Delete">Delete</button>
                    </form>';
                    }
                    return $html.='</div>';
            })->make();
        }
        return view('expense.category.index');
    }



    public function create()
    {
        return view('expense.category.create');
    }




    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required'],
        ]);

        $expense_category = new ExpenseCategory;
        $expense_category->name = $request->name;
        $expense_category->details = $request->details;
        $expense_category->save();

        return to_route('expenseCategory')->with('success', 'Expense Category Added Successfully');
    }


    public function edit($id)
    {
        $expense_category= ExpenseCategory::find($id);
        return view('expense.category.edit', compact('expense_category'));
    }


    public function update(Request $request , $id)
    {
        $validate = $request->validate([
            'name' => ['required'],
        ]);

        $expense_category= ExpenseCategory::find($id);
        $expense_category->name = $request->name;
        $expense_category->details = $request->details;
        $expense_category->save();

        return to_route('expenseCategory')->with('success', 'Expense Category Updated Successfully');

    }

    public function delete($id)
    {
        $expense_category= ExpenseCategory::find($id);
        if(Expense::where('expense_category_id', $id)->exist()){
            return to_route('expenseCategory')->with('error', 'You can not Delete Expense Category');
        }
        $expense_category->delete();
        return to_route('expenseCategory')->with('success', 'Expense Category Deleted Successfully');
    }
}
