<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Customer View')->only(['index']);
        $this->middleware('permission:Customer Create')->only(['create', 'store']);
        $this->middleware('permission:Customer Edit')->only(['edit', 'update']);
        $this->middleware('permission:Customer Delete')->only(['delete']);
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            return DataTables::of(Customer::all())
            ->addColumn('action', function ($row) {
            $html = '<div class="d-flex justify-content-center gap-1">';
            if (auth()->user()->can("Customer Edit")) {
                $html .= '<div><a class="btn btn-info btn-sm" href="'. url('/customer/edit') . '/'.$row->id.'"> Edit</a></div>';
            }
            if (auth()->user()->can("Customer Delete")) {
            $html .= '
             <form method="POST" action="'.url('/customer/delete').'/'.$row->id.'">
             <input name="_method" type="hidden" value="GET">
             <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                 data-toggle="tooltip" title="Delete">Delete</button>
            </form>';
            }
            return $html.='</div>';
         })->make();
        }
        return view('customer.index');
    }



    public function create()
    {
        return view('customer.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->contact = $request->contact;
        $customer->address = $request->address;
        $customer->save();

        if($request->ajax()){
            return response()->json([
                'success' => true,
                'message' => 'Customer Added'
            ]);
        }
        return to_route('customer')->with('success', 'Customer Created Successfully !');
    }


    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $customer =  Customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->contact = $request->contact;
        $customer->address = $request->address;
        $customer->save();
        return to_route('customer')->with('success', 'Customer Updated Successfully !');
    }


    public function delete($id)
    {
        $customer =  Customer::find($id);
        $customer->delete();
        return to_route('customer')->with('success', 'Customer Deleled Successfully !');
    }
}
