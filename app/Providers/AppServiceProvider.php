<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Chat;
use App\Observers\ChatObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Chat::observe(ChatObserver::class);
    }
}
