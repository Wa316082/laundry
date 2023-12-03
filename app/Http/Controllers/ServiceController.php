<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $services = Service::leftJoin('service_categories', 'service_categories.id', '=', 'services.category_id')
            ->select('services.*', 'service_categories.name as category')->get();
            return DataTables::of($services)
                ->addColumn('action', function ($row) {
                return '<div class=" "><a class="btn btn-info btn-sm mb-xl-1 mb-1" href="'. url('/service/edit') . '/'.$row->id.'"> Edit</a>
                <form method="POST" action="'.url('/service/delete').'/'.$row->id.'">
                <input name="_method" type="hidden" value="GET">
                <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                    data-toggle="tooltip" title="Delete">Delete</button>
                </form></div>';
            })->make();
        }
        return view('service.index');
    }


    public function create()
    {
        $categories = ServiceCategory::get();
        return view('service.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'details' => ['required'],
            'price' => ['required'],
            'category_id' => ['required']
        ]);
        $save_url =null;
        if(request()->hasFile('image')){
            $image = $request['image'];
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('image/service/'. $name_gen);
            $save_url = 'image/service/' . $name_gen;
         }
        $service = new Service;
        $service->name = $request->name;
        $service->details = $request->details;
        $service->price = $request->price;
        $service->image =$save_url;
        $service-> category_id = $request-> category_id;
        $service->save();
        return to_route('service')->with('success', 'Service Created Successfully');
    }


    public function edit($id)
    {
        $service = Service::find($id);
        $categories = ServiceCategory::get();
        return view('service.edit', compact('categories', 'service'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'details' => ['required'],
            'price' => ['required'],
            'category_id' => ['required']
        ]);
        $service = Service::find($id);
        $save_url = $service->image;
        if(request()->hasFile('image')){
            if(File::exists($save_url)){
                unlink($save_url);
            }
            $image = $request['image'];
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('image/service/'. $name_gen);
            $save_url = 'image/service/' . $name_gen;
        }
        $service->name = $request->name;
        $service->details = $request->details;
        $service->price = $request->price;
        $service->image =$save_url;
        $service-> category_id = $request-> category_id;
        $service->save();
        return to_route('service')->with('success', 'Service Updated Successfully');
    }


    public function delete($id)
    {
        $service  = Service::find($id);
        $save_url = $service->image;
        if(File::exists($save_url)){
            unlink($save_url);
        }
        $service->delete();
        return to_route('service')->with('success', 'Service Deleted Successfully');
    }
}
