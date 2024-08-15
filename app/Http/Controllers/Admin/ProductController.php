<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate();
        // dd($products);
        return view('admin.products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'required|numeric',
            'description' => 'required',
            'vat' => 'required|numeric',
            'stock' => 'required|numeric',
            'referr_discount' => 'required|numeric',
            'referal_discount' => 'required|numeric',
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        if($request->has('image')){
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName);
            $product->image = '/uploads/' . $filePath;
        }else{
            $product->image = "https://via.placeholder.com/640x480.png/000077?text=quas"; 
        }
        $product->save();
        return redirect('admin/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('admin.products.show', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request...
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'required|numeric',
            'description' => 'required',
            'vat' => 'required|numeric',
            'stock' => 'required|numeric',
            'referr_discount' => 'required|numeric',
            'referal_discount' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->discount = $request->discount;
        $product->description = $request->description;
        $product->vat = $request->vat;
        $product->stock = $request->stock;
        $product->referr_discount = $request->referr_discount;
        $product->referal_discount = $request->referal_discount;
        if($request->has('image')){
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName);
            $product->image = '/uploads/' . $filePath;
        }else if($request->has('remove_image')){
            $product->image = "https://via.placeholder.com/640x480.png/000077?text=quas"; 
        }
        $product->save();
        return redirect('admin/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
