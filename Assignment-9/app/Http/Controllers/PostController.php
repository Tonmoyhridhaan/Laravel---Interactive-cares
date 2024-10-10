<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        
        $posts = Post::with('user')->latest()->get();
        $currentUser = session('user'); 
        //echo $currentUser->id ;
        
        return view('index', compact('posts', 'currentUser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        dd($request);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); 
        }

        Post::create([
            'content' => $request->content,
            'user_id' => session('user')->id, 
            'image' => $imagePath, 
        ]);
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('edit', compact('post'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (session('user')->id != $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);

        $post = Post::findOrFail($id);

        if (session('user')->id != $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized action.');
        }

        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

}
