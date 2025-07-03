<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Helper\MediaHelper;
use Illuminate\Support\Facades\File;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::paginate();
        return view('admin.blogposts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();
        $countries = Country::all();
        return view('admin.blogposts.create', compact('categories', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'country_id' => 'required',
        ]);
        $post = new BlogPost();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->content = $request->content;
        $post->blog_category_id = $request->category_id;
        $post->country_id = $request->country_id;
        $post->user_id = auth()->user()->id;
        $post->status = 'published';
        $post->meta_title = $request->title;
        $post->meta_description = $request->title;
        $post->meta_keywords = "blog, alshaafi, health";
        if($request->hasFile('image')) {
            $post->image = MediaHelper::upload($request->file('image'));
        }
        $post->save();
        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = BlogCategory::all();
        $countries = Country::all();
        $post = BlogPost::find($id);
        return view('admin.blogposts.edit', ['post' => $post, 'categories' => $categories, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'country_id' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        $post = BlogPost::find($id);
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->content = $request->content;
        $post->blog_category_id = $request->category_id;
        $post->country_id = $request->country_id;
        $post->status = 'published';
        $post->meta_title = $request->title;
        $post->meta_description = $request->title;
        $post->meta_keywords = "blog, alshaafi, health";
        if($request->hasFile('image')) {
            if(File::exists(public_path('uploads/' . $post->image))) {
                File::delete(public_path('uploads/' . $post->image));
            }
            $post->image = MediaHelper::upload($request->file('image'));
        }
        $post->save();
        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function filter(Request $request)
    {
        $posts = BlogPost::where('title', 'like', '%' . $request->search . '%')
        ->where('content', 'like', '%' . $request->search . '%')->paginate();
        return view('admin.blogposts.index', ['posts' => $posts]);
    }
}
