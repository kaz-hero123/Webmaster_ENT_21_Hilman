<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category')->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->get();
        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show(string $id)
    {
        $post = Post::with('category')->findOrFail($id);
        return view('posts.show', compact('post'));
    }
}
