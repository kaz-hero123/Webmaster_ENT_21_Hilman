<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->paginate(10);
        $categories = \App\Models\Category::all();

        return view('admin.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $post = new Post();
        $post->title = $request->input('title');
        
        // Basic sanitization for the rich text content (you might want a robust HTML Purifier for production)
        $content = $request->input('content');
        // Remove potentially dangerous tags if needed, but TinyMCE usually handles basic sanitization on the client side.
        $post->content = $content;

        $post->excerpt = $request->input('excerpt') ?? Str::limit(strip_tags($content), 150);
        $post->category_id = $request->input('category_id');
        $post->user_id = auth()->id();
        
        $isPublished = $request->has('is_published') ? true : false;
        $post->is_published = $isPublished;
        
        if ($isPublished && !$post->published_at) {
            $post->published_at = \Carbon\Carbon::now();
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not used in admin, but keeping it for resource completeness or preview
        $post = Post::with('category')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {

        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->excerpt = $request->input('excerpt') ?? Str::limit(strip_tags($request->input('content')), 150);
        $post->category_id = $request->input('category_id');
        
        $isPublished = $request->has('is_published') ? true : false;
        $post->is_published = $isPublished;
        
        if ($isPublished && !$post->published_at) {
            $post->published_at = \Carbon\Carbon::now();
        } elseif (!$isPublished) {
             $post->published_at = null; // Optional: Reset published_at when draft
        }

        if ($request->hasFile('image')) {

            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus!');
    }
}
