<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Support\Facades\URL;

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

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('admin.index', function ($view) {
            $view->with([
                'totalMember'   => User::count(),
                'totalBooking'  => Booking::count(),
                'totalLapangan' => Lapangan::count(),
                'bookingStatus' => [
                    'Paid'    => Booking::where('payment_status', 'Paid')->count(),
                    'Pending' => Booking::where('payment_status', 'Pending')->count(),
                    'Cancel'  => Booking::where('payment_status', 'Cancel')->count(),
                ]
            ]);
        });
    }
}
