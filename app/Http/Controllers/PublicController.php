<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category')->published();
        
        // Get featured post (the latest one) if we are on the homepage without search/filter
        $featuredPost = null;
        if (!$request->has('search') && !$request->has('category_id') && (!$request->has('sort') || $request->sort == 'newest')) {
             $featuredPost = (clone $query)->latest()->first();
             if ($featuredPost) {
                 // Exclude featured post from the main grid
                 $query->where('id', '!=', $featuredPost->id);
             }
        }

        if ($request->sort == 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->paginate(9); // More posts for grid
        $categories = Category::all();

        // Get popular categories or sidebar data
        $sidebarCategories = Category::withCount('posts')->orderByDesc('posts_count')->take(5)->get();
        $popularPosts = Post::published()->orderByDesc('views')->latest()->take(5)->get();

        return view('posts.index', compact('posts', 'categories', 'featuredPost', 'sidebarCategories', 'popularPosts'));
    }

    public function show(string $slug)
    {
        $post = Post::with(['category', 'author'])->published()->where('slug', $slug)->firstOrFail();
        
        // Increment views
        $post->incrementViews();
        
        // Fetch related posts
        $relatedPosts = collect();
        if ($post->category_id) {
            $relatedPosts = Post::published()
                                ->where('category_id', $post->category_id)
                                ->where('id', '!=', $post->id)
                                ->latest()
                                ->take(3)
                                ->get();
        }
        
        return view('posts.show', compact('post', 'relatedPosts'));
    }
    
    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = Post::with('category')->published()->where('category_id', $category->id)->latest()->paginate(9);
        
        $categories = Category::all();
        $sidebarCategories = Category::withCount('posts')->orderByDesc('posts_count')->take(5)->get();
        $popularPosts = Post::published()->orderByDesc('views')->latest()->take(5)->get();
        
        return view('posts.index', compact('posts', 'categories', 'category', 'sidebarCategories', 'popularPosts'));
    }
}
