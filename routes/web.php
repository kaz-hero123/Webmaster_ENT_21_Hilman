<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Halaman Publik (User)
Route::get('/', [PublicController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [PublicController::class, 'show'])->name('posts.show');
Route::get('/kategori/{slug}', [PublicController::class, 'category'])->name('posts.category');

// Halaman Admin (Wajib Login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.posts.index');
    })->name('dashboard');

    Route::resource('admin/posts', PostController::class)->names([
        'index' => 'admin.posts.index',
        'create' => 'admin.posts.create',
        'store' => 'admin.posts.store',
        'edit' => 'admin.posts.edit',
        'update' => 'admin.posts.update',
        'destroy' => 'admin.posts.destroy',
    ]);

    Route::resource('admin/categories', App\Http\Controllers\CategoryController::class)->except(['create', 'show', 'edit'])->names([
        'index' => 'admin.categories.index',
        'store' => 'admin.categories.store',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
});



require __DIR__.'/auth.php';
