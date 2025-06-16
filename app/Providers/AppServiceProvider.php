<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Chat;
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
        View::composer(['layouts.home', 'layouts.dashboard', 'layouts.dashboardorg'], function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $view->with([
                    'notifications' => $user->notifications()
                        ->latest()
                        ->take(5)
                        ->get(),
                    'unreadCount' => $user->unreadNotifications()->count(),
                    'unreadChatCount' => Chat::where('receiver_id', $user->id)
                        ->whereNull('read_at')
                        ->count(),
                ]);
            }
        });
    }
}
