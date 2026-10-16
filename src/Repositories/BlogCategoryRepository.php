<?php

namespace Sesuva\Blog\Repositories;

use Sesuva\Blog\Models\BlogCategory;

class BlogCategoryRepository
{
    public function create(array $data): BlogCategory
    {
        return BlogCategory::create($data);
    }

    public function update(BlogCategory $category, array $data): BlogCategory
    {
        $category->update($data);
        return $category->fresh();
    }

    public function delete(BlogCategory $category): bool
    {
        $category->posts()->update(['category_id' => null]);
        return $category->delete();
    }

    public function findById(int $id): ?BlogCategory
    {
        return BlogCategory::find($id);
    }

    public function findBySlug(string $slug): ?BlogCategory
    {
        return BlogCategory::where('slug', $slug)->first();
    }

    public function getActive()
    {
        return BlogCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function getWithPostCount()
    {
        return BlogCategory::where('is_active', true)
            ->withCount('posts')
            ->orderBy('sort_order')
            ->get();
    }

    public function getRoots()
    {
        return BlogCategory::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }
}
