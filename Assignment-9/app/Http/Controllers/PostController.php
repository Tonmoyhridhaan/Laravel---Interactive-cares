<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('search');

        // Fetch posts with a search filter if a search query is provided
        $posts = Post::with('user')
            ->when($query, function ($q) use ($query) {
                $q->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery->where('firstName', 'like', "%{$query}%")
                        ->orWhere('lastName', 'like', "%{$query}%")
                        ->orWhere('userName', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->get();

        // Get the current user from the session
        $currentUser = session('user');

        // Return the view with the posts and current user
        return view('index', compact('posts', 'currentUser'));
    }

    


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); 
        }
        
        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = session('user')->id;
        //echo $imagePath;
        $post->image = $imagePath;
        $post->save(); 

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
