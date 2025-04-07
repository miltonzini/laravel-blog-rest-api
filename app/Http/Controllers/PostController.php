<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware() 
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public function index()
    {
        return Post::paginate(20);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $post = $request->user()->posts()->create($fields);

        return $post;
    }

    public function show(Post $post)
    {
        return $post;
    }


    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);

        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        $post->update($fields);

        return $post;
    }

    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);
        
        $post->delete();

        return ['message' => 'The post was deleted'];
    }
}
