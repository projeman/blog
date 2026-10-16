<?php

namespace Sesuva\Blog;

use Illuminate\Support\ServiceProvider;
use Sesuva\Blog\Repositories\BlogPostRepository;
use Sesuva\Blog\Repositories\BlogCategoryRepository;
use Sesuva\Blog\Repositories\BlogTagRepository;

class BlogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRepositories();
    }

    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'sesuva-blog-migrations');

        $this->publishesFiles([
            __DIR__.'/../config/blog.php' => config_path('sesuva-blog.php'),
        ], 'sesuva-blog-config');
    }

    private function registerRepositories(): void
    {
        $this->app->singleton(BlogPostRepository::class, function () {
            return new BlogPostRepository();
        });

        $this->app->singleton(BlogCategoryRepository::class, function () {
            return new BlogCategoryRepository();
        });

        $this->app->singleton(BlogTagRepository::class, function () {
            return new BlogTagRepository();
        });
    }
}
