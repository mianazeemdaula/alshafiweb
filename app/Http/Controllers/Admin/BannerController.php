<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Country;
use App\Helper\MediaHelper;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::query();
        if(request()->has('country') && request()->country != ''){
            $banners = $banners->where('country_id', request()->country);
        }
        $banners = $banners->paginate();
        return view('admin.banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.banners.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'url' => 'required|url',
            'is_active' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required',
        ]);

        $banner = new Banner;
        $banner->country_id = $request->country_id;
        $banner->title = $request->title;
        $banner->url = $request->url;
        $banner->position = Banner::max('position') + 1;
        $banner->is_active = $request->is_active;
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;
        $banner->description = $request->description;
        if($request->hasFile('image')){
            $banner->image = MediaHelper::upload($request->file('image'));
        }
        $banner->save();
        return redirect()->route('admin.banners.index')->with('success','Banner created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.show',compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        $countries = Country::all();
        return view('admin.banners.edit',compact('banner','countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'title' => 'required|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'url' => 'required|url',
            'is_active' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required',
        ]);

        $banner = Banner::findOrFail($id);
        $banner->country_id = $request->country_id;
        $banner->title = $request->title;
        $banner->url = $request->url;
        $banner->is_active = $request->is_active;
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;
        $banner->description = $request->description;
        if($request->hasFile('image')){
            $banner->image = MediaHelper::upload($request->file('image'));
            
            if(File::exists(public_path('uploads/'.$banner->image))){
                File::delete(public_path('uploads/'.$banner->image));
            }
        }
        $banner->save();
        return redirect()->route('admin.banners.index')->with('success','Banner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
