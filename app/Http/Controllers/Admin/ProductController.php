<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Country;
use App\Helper\MediaHelper;
use App\Models\Media;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query();
        if(request()->has('country') && request()->country != ''){
            $products = $products->where('country_id', request()->country);
        }
        $products = $products->orderBy('id','desc')->paginate();
        return view('admin.products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $countries = Country::all();
        return view('admin.products.create', ['categories' => $categories, 'countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku',
            'discount' => 'nullable|numeric',
            'sorting' => 'nullable|integer|min:0',
            'description' => 'required',
            'vat' => 'nullable|numeric',
            'stock' => 'required|numeric',
            'referrer_discount' => 'nullable|numeric',
            'referal_discount' => 'nullable|numeric',
            'buyer_discount' => 'nullable|numeric',
            'whatsapp_contact' => 'nullable|string|max:20',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->sku = $request->sku;
        $product->category_id = $request->category_id;
        $product->country_id = $request->country_id;
        $product->description = $request->description;
        $product->discount = $request->discount;
        $product->sorting = $request->sorting ?? 0;
        $product->vat = $request->vat ?? 0;
        $product->stock = $request->stock;
        $product->referrer_discount = $request->referrer_discount ?? 0;
        $product->referal_discount = $request->referal_discount ?? 0;
        $product->buyer_discount = $request->buyer_discount ?? 0;
        $product->earn_points = $request->earn_points ?? 0;
        $product->featured = $request->featured;
        $product->is_active = $request->is_active;
        $product->manual_only = $request->has('manual_only') ? true : false;
        $product->whatsapp_contact = $request->whatsapp_contact;
        $product->image = "https://via.placeholder.com/640x480.png/000077?text=quas";
        $product->save();
        if($request->has('image')){
            $files = $request->file('image');
            $sortIndex = 1;
            foreach($files as $file){
                $media = MediaHelper::store($file, $product->id, Product::class);
                $media->sort = $sortIndex++;
                $media->save();
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = Category::all();
        $product = Product::with('activeOffers')->findOrFail($id);
        return view('admin.products.show', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $countries = Country::all();
        $product = Product::findOrFail($id);
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories, 'countries' => $countries]);
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
            'country_id' => 'required|exists:countries,id',
            'discount' => 'nullable|numeric',
            'sorting' => 'nullable|integer|min:0',
            'description' => 'required',
            'vat' => 'nullable|numeric',
            'stock' => 'required|numeric',
            'referrer_discount' => 'nullable|numeric',
            'referal_discount' => 'nullable|numeric',
            'buyer_discount' => 'nullable|numeric',
            'earn_points' => 'nullable|numeric',
            'whatsapp_contact' => 'nullable|string|max:20',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->country_id = $request->country_id;
        $product->discount = $request->discount ?? 0;
        $product->sorting = $request->sorting ?? 0;
        $product->description = $request->description;
        $product->vat = $request->vat ?? 0;
        $product->stock = $request->stock;
        $product->referrer_discount = $request->referrer_discount ?? 0;
        $product->referal_discount = $request->referal_discount ?? 0;
        $product->buyer_discount = $request->buyer_discount ?? 0;
        $product->earn_points = $request->earn_points ?? 0;
        $product->featured = $request->featured;
        $product->is_active = $request->is_active;
        $product->manual_only = $request->has('manual_only') ? true : false;
        $product->whatsapp_contact = $request->whatsapp_contact;
        $product->save();
        if($request->has('image')){
            $files = $request->file('image');
            $sortIndex = $product->media->count() + 1;
            foreach($files as $file){
                $media = MediaHelper::store($file, $product->id, Product::class);
                $media->sort = $sortIndex++;
                $media->save();
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        // Delete associated media
        foreach ($product->media as $media) {
            // Delete the media file from storage
            if (file_exists(public_path($media->file_path))) {
                unlink(public_path($media->file_path));
            }
            // Delete the media record from the database
            $media->delete();
        }
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function filter(Request $request)
    {
        $products = Product::query();
        if($request->has('country') && $request->country != ''){
            $products = $products->where('country_id', $request->country);
        }
        if($request->has('search') && $request->search != ''){
            $products = $products->where('name', 'like', '%' . $request->search . '%');
        }
        $products = $products->paginate();
        return view('admin.products.index', ['products' => $products]);
    }

    public function defaultimage(Request $request){
        $product = Product::find($request->product_id);
        $product->image = $request->image;
        $product->save();
        return redirect()->back()->with('success', 'Default image set successfully');
    }

    public function sortmedia(Request $request)
    {
        $productId = $request->productId;
        $mediaIds = $request->mediaIds;
        $pro = Product::find($productId);
        $sortNo = 1;
        foreach ($mediaIds as $media) {
            Media::find($media)->update(['sort' => $sortNo++]);
        }
        return response()->json($request->all());
    }
}
