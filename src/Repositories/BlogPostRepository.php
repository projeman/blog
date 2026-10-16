<?php

namespace Sesuva\Blog\Repositories;

use Sesuva\Blog\Models\BlogPost;
use Sesuva\Blog\Models\BlogCategory;

class BlogPostRepository
{
    public function create(array $data): BlogPost
    {
        return BlogPost::create($data);
    }

    public function update(BlogPost $post, array $data): BlogPost
    {
        $post->update($data);
        return $post->fresh();
    }

    public function delete(BlogPost $post): bool
    {
        $post->tags()->detach();
        return $post->delete();
    }

    public function findById(int $id): ?BlogPost
    {
        return BlogPost::find($id);
    }

    public function findBySlug(string $slug): ?BlogPost
    {
        return BlogPost::where('slug', $slug)->first();
    }

    public function getPublished(int $perPage = 15)
    {
        return BlogPost::published()
            ->with('category', 'tags')
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function getByCategory(BlogCategory $category, int $perPage = 15)
    {
        return $category->posts()
            ->published()
            ->with('tags')
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function search(string $query, int $perPage = 15)
    {
        return BlogPost::published()
            ->search($query)
            ->with('category', 'tags')
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function attachTags(BlogPost $post, array $tagIds): void
    {
        $post->tags()->sync($tagIds);
    }

    public function getRelated(BlogPost $post, int $limit = 5)
    {
        return BlogPost::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->with('tags')
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }
}
