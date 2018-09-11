<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    protected static $categories;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (!self::$categories) {
                self::$categories = Category::where('parent', null)
                    ->with('children')
                    ->get();
            }

            $view->with('categories', self::$categories);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
