<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('tag_name')->get();
        return response()->json($tags);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tag_name' => 'required|string|unique:tags,tag_name',
        ]);

        $tag = Tag::create($data);

        return response()->json($tag, 201);
    }
}
