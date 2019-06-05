<?php

namespace wisdmlabs\todolist;

use Illuminate\Support\ServiceProvider;

class TodolistServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'todolist');
        //echo base_path('resources/views/wisdmlabs/todolist');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/wisdmlabs/todolist'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Wisdmlabs\Todolist\TaskController');
    }
}
