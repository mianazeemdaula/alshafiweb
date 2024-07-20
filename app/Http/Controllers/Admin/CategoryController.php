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
            'description' => 'required',
        ]);

        $category = new Category;

        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();
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
            'description' => 'required',
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
