<?php

namespace Sesuva\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogTag extends Model
{
    protected $table = 'blog_tags';

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted(): void
    {
        static::creating(function (BlogTag $tag) {
            if (empty($tag->slug) && ! empty($tag->name)) {
                $tag->slug = \Illuminate\Support\Str::slug($tag->name);
            }
        });
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogPost::class,
            'blog_post_tag',
            'tag_id',
            'post_id'
        )->withTimestamps();
    }
}
