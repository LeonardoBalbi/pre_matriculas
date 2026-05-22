<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Matricula;
use App\Observers\MatriculaObserver;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
     public function boot(): void
     {
         Schema::defaultStringLength(191);
         Matricula::observe(MatriculaObserver::class);
        Paginator::useBootstrap();

     }
}
