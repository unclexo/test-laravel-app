<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts;

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->validated());

        return redirect($post->path());
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post); // Check Gate authorization api

        $post->update($request->validated());

        return redirect($post->path());
    }

    public function destroy(Post $post)
    {
        $this->authorize('update', $post);

        $post->delete();

        return redirect()->route('posts.index');
    }
}
