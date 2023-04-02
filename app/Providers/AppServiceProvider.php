<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        Model::preventLazyLoading(!app()->isProduction());

        View::composer('client.layouts.app', function ($view) {
            $categories = Category::with('parent')
            ->orderBy('sort_order')
            ->orderBy('name_tm')
            ->get(['parent_id', 'name_tm', 'slug', 'sort_order']);

            $locales = config()->get('app.locales');

            $view->with([
                'categories' => $categories,
                'locales' => $locales,
            ]);
        });
    }
}
