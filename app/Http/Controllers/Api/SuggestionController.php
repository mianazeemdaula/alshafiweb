<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $suggestion = new Suggestion();
        $suggestion->user_id = auth()->user()->id;
        $suggestion->content = $request->content;
        $suggestion->save();

        return response()->json($suggestion);
    }
}
