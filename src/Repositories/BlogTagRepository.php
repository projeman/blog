<?php

namespace Sesuva\Blog\Repositories;

use Sesuva\Blog\Models\BlogTag;

class BlogTagRepository
{
    public function create(array $data): BlogTag
    {
        return BlogTag::create($data);
    }

    public function update(BlogTag $tag, array $data): BlogTag
    {
        $tag->update($data);
        return $tag->fresh();
    }

    public function delete(BlogTag $tag): bool
    {
        $tag->posts()->detach();
        return $tag->delete();
    }

    public function findById(int $id): ?BlogTag
    {
        return BlogTag::find($id);
    }

    public function findBySlug(string $slug): ?BlogTag
    {
        return BlogTag::where('slug', $slug)->first();
    }

    public function findOrCreate(string $name): BlogTag
    {
        $slug = \Illuminate\Support\Str::slug($name);
        return BlogTag::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name]
        );
    }

    public function getPopular(int $limit = 10)
    {
        return BlogTag::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit($limit)
            ->get();
    }

    public function getAllTags()
    {
        return BlogTag::orderBy('name')->get();
    }
}
