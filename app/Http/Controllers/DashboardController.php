<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMember   = User::count();
        $totalBooking  = Booking::count();
        $totalLapangan = Lapangan::count();

        // Hitung status booking (1 query saja)
        $bookingStatus = Booking::select('payment_status', DB::raw('count(*) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status')
            ->toArray();

        return view('admin.index', compact(
            'totalMember',
            'totalBooking',
            'totalLapangan',
            'bookingStatus'
        ));
    }
}
