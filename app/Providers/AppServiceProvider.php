<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;


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
        // Inject data notifikasi ke view dashboard & home
         View::composer('*', function ($view) {
            if (Auth::check()) {
                $notifications = auth()->user()->notifications()
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            } else {
                $notifications = collect(); // kasih collection kosong kalo belum login
            }

            $view->with('notifications', $notifications);
        });
    }
}
