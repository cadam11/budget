<?php

namespace Budget\Providers;

use View;
use Budget\Services\CategoryService;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(CategoryService $categories)
    {
        View::share('categories', $categories->getAll()->keys());
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
