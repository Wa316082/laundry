<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Yajra\DataTables\DataTables;

class ServiceCategoryController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            return DataTables::of(ServiceCategory::all())
                ->addColumn('action', function ($row) {
                return '<div class=" "><a class="btn btn-info btn-sm mb-xl-1 mb-1" href="'. url('/service_category/edit') . '/'.$row->id.'"> Edit</a>
                <form method="POST" action="'.url('/service_category/delete').'/'.$row->id.'">
                <input name="_method" type="hidden" value="GET">
                <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                    data-toggle="tooltip" title="Delete">Delete</button>
                </form></div>';
            })->make();
        }
        return view('service_category.index');
    }



    public function create()
    {
        return view('service_category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $service_category = new ServiceCategory;
        $service_category->name = $request->name;
        $service_category->details = $request->details;
        $service_category->save();

        return to_route('service_category')->with('success', 'Service Categorry Added Successfully !');

    }


    public function edit($id)
    {
        $service_category= ServiceCategory::find($id);
       return view('service_category.edit', compact('service_category'));
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $service_category = ServiceCategory::find($id);
        $service_category->name = $request->name;
        $service_category->details = $request->details;
        $service_category->save();

        return to_route('service_category')->with('success', 'Service Categorry Updated Successfully !');
    }


    public function delete($id)
    {
        $service_category = ServiceCategory::find($id);
        $service_category->delete();
        return to_route('service_category')->with('success', 'Service Categorry Deleted Successfully !');
    }


    

}
