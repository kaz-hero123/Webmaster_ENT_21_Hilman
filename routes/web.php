<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Halaman Publik (User)
Route::get('/', [PublicController::class, 'index'])->name('posts.index');
Route::get('/berita/{id}', [PublicController::class, 'show'])->name('posts.show');

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
});



require __DIR__.'/auth.php';
