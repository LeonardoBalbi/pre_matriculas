<?php

namespace Rhylton\Escolas;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! class_exists(Nova::class)) {
            return;
        }

        Nova::serving(function (ServingNova $event) {
            Nova::script('escolas', __DIR__.'/../dist/js/field.js');
            Nova::style('escolas', __DIR__.'/../dist/css/field.css');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
