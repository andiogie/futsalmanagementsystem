@extends('admin.layout')

@section('content')
<h1 class="text-3xl font-bold mb-6">Selamat Datang di Dashboard</h1>

<!-- Statistik Ringkas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold">Total Member</h2>
        <p class="text-2xl font-bold text-green-600">{{ $totalMember }}</p>
    </div>
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold">Total Booking</h2>
        <p class="text-2xl font-bold text-blue-600">{{ $totalBooking }}</p>
    </div>
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold">Total Lapangan</h2>
        <p class="text-2xl font-bold text-purple-600">{{ $totalLapangan }}</p>
    </div>
</div>

<!-- Chart Status Booking -->
<div class="bg-white p-6 rounded shadow flex justify-center">
    <div class="w-full max-w-md"> {{-- batas lebar maksimal --}}
        <h2 class="text-lg font-semibold mb-4 text-center">Statistik Booking</h2>
        <canvas id="bookingChart"></canvas>
    </div>
</div>

<!-- CDN Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bookingChart').getContext('2d');
    const bookingChart = new Chart(ctx, {
        type: 'doughnut', // bisa juga 'bar' kalau mau
        data: {
            labels: ['Pending', 'Paid', 'Cancel'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $bookingStatus['Pending'] }},
                    {{ $bookingStatus['Paid'] }},
                    {{ $bookingStatus['Cancel'] }}
                ],
                backgroundColor: [
                    '#facc15', // kuning (pending)
                    '#22c55e', // hijau (paid)
                    '#ef4444'  // merah (cancel)
                ]
            }]
        }
    });
</script>
@endsection
