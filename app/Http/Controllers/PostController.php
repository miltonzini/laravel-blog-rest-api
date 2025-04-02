<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $post = Post::create($fields);

        return $post;
    }

    public function show(Post $post)
    {
        return $post;
    }


    public function update(Request $request, Post $post)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $post->update($fields);

        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return ['message' => 'The post was deleted'];
    }
}
