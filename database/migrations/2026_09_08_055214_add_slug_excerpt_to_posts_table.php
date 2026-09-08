<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->text('excerpt')->nullable()->after('content');
            $table->boolean('is_published')->default(true)->after('image');
            $table->timestamp('published_at')->nullable()->after('is_published');
        });

        // Generate slugs for existing posts
        $posts = \App\Models\Post::all();
        foreach ($posts as $post) {
            $post->slug = Str::slug($post->title) . '-' . $post->id;
            $post->published_at = $post->created_at;
            $post->saveQuietly();
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['slug', 'excerpt', 'is_published', 'published_at']);
        });
    }
};
