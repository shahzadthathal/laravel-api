<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\IAuth;
use App\Repositories\AuthRepository;

use App\Interfaces\ICategory;
use App\Repositories\CategoryRepository;

use App\Interfaces\IPost;
use App\Repositories\PostRepository;

use App\Interfaces\IProduct;
use App\Repositories\ProductRepository;

use App\Interfaces\IComment;
use App\Repositories\CommentRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IAuth::class,AuthRepository::class);
        $this->app->bind(ICategory::class,CategoryRepository::class);
        $this->app->bind(IPost::class,PostRepository::class);
        $this->app->bind(IProduct::class,ProductRepository::class);
        $this->app->bind(IComment::class,CommentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
