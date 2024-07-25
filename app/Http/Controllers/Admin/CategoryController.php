<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        $category = new Category;
        $category->name = $request->name;
        if($request->has('image')){
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName);
            $category->image = '/uploads/' . $filePath;
        }else{
            $category->image = "https://via.placeholder.com/640x480.png/000077?text=quas"; 
        }
        $category->save();
        return redirect('admin/categories');
    }

    public function show($id)
    {
        return view('admin.categories.show', ['category' => Category::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view('admin.categories.edit', ['category' => Category::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request...
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            // 'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        if($request->has('image')){
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName);
            $category->image = '/uploads/' . $filePath;
        }

        $category->save();
        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index');
    }
}
