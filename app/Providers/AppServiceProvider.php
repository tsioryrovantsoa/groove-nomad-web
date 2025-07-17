<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Request;
use App\Observers\UserObserver;
use App\Observers\RequestObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;

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
        App::setLocale(config('app.locale'));
        Paginator::useBootstrapFour();
        
        // Enregistrer l'observateur User
        User::observe(UserObserver::class);
        
        // Enregistrer l'observateur Request
        Request::observe(RequestObserver::class);
    }
}
