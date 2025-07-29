<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $media = \App\Models\Media::findOrFail($id);
        if ($media) {
            // Delete the media file from storage
            if (file_exists(public_path($media->file_path))) {
                unlink(public_path($media->file_path));
            }
            // Delete the media record from the database
            $media->delete();
            return redirect()->back()->with('success', 'Media deleted successfully.');
        }
        return redirect()->back()->with('error', 'Media not found.');
    }
}
