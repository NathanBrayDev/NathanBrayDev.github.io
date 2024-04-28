<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // View::composer('components.filament-fabricator.page-blocks.default', function ($view) {

        //     $view->with(['test' => 'hahah']);
        // });
    }
}
