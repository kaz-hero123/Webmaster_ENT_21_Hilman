<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'category_id',
        'user_id',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title) . '-' . uniqid();
            }
            if (empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 150);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title) . '-' . uniqid();
            }
            if ($post->isDirty('content') && empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 150);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where('is_published', true);
    }

    public function readingTime()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);
        
        return max(1, $minutes);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
