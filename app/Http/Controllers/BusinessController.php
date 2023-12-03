<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\BusinessSettings;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Business View')->only(['index']);
        $this->middleware('permission:Business Create')->only(['create', 'store']);
        $this->middleware('permission:Business Edit')->only(['edit', 'update']);
        $this->middleware('permission:Business Delete')->only(['delete']);
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            return DataTables::of(BusinessSettings::all())
            ->addColumn('action', function ($row) {
            $html = '<div class="d-flex justify-content-around gap-1">';
            if (auth()->user()->can("Business Edit")) {
                $html .= '<div><a class="btn btn-info btn-sm" href="'. url('/business/edit') . '/'.$row->id.'"> Edit</a></div>';
            }
            if (auth()->user()->can("Business Delete")) {
            $html .= '
             <form method="POST" action="'.url('/business/delete').'/'.$row->id.'">
             <input name="_method" type="hidden" value="GET">
             <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                 data-toggle="tooltip" title="Delete">Delete</button>
            </form>';
            }
            return $html.='</div>';

        })->make();
        }
        return view('business.index');
    }


    public function create()
    {
        return view('business.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'business_email' => ['required', 'string', 'email', 'max:255', 'unique:business_settings,business_email'],
            'business_contact' => ['required', 'string', 'max:255'],
        ]);

        $business = new BusinessSettings;

        if(request()->hasFile('business_logo')){
            $image = $request['business_logo'];
            $name_gen = hexdec(uniqid()) . '.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(120, 60)->save('image/business_logo/'. $name_gen);
            $save_url = 'image/business_logo/' . $name_gen;
            $business->business_logo = $save_url;
        }
        $business->business_name = $request->business_name;
        $business->business_email = $request->business_email;
        $business->business_contact = $request->business_contact;
        $business->business_address = $request->business_address;
        $business->business_detail1 = $request->business_detail1;
        $business->business_detail2 = $request->business_detail2;
        $business->business_detail3 = $request->business_detail3;
        $business->business_extra1 = $request->business_extra1;
        $business->business_extra2 = $request->business_extra2;
        $business->save();

        return to_route('business')->with('success', 'Business Details Added');
    }



    public function edit($id)
    {
        $business = BusinessSettings::find($id);
        return view('business.edit', compact('business'));
    }



    public function update(Request $request, $id)
    {
        $business = BusinessSettings::find($id);
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'business_email' => ['required', 'string', 'email', 'max:255', Rule::unique('business_settings')->ignore($business->id)],
            'business_contact' => ['required', 'string', 'max:255'],
        ]);


        if(request()->hasFile('business_logo')){
            $image = $request['business_logo'];
            $name_gen = hexdec(uniqid()) . '.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1000, 400)->save('image/business_logo/'. $name_gen);
            if( ($business->business_logo) && File::exists($business->business_logo)){
                unlink($business->business_logo);
            }
            $save_url = 'image/business_logo/'. $name_gen;
            $business->business_logo = $save_url;
        }
        $business->business_name = $request->business_name;
        $business->business_email = $request->business_email;
        $business->business_contact = $request->business_contact;
        $business->business_address = $request->business_address;
        $business->business_detail1 = $request->business_detail1;
        $business->business_detail2 = $request->business_detail2;
        $business->business_detail3 = $request->business_detail3;
        $business->business_extra1 = $request->business_extra1;
        $business->business_extra2 = $request->business_extra2;
        $business->save();
        return to_route('business')->with('success', 'Business Details Updated');
    }


    public function delete($id)
    {
        $business = BusinessSettings::find($id);
        $business->delete();
        return to_route('business')->with('success', 'Business Details Deleted');
    }
}
