<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Laporan;
use Carbon\Carbon;

class GenerateMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan laporan:bulanan {month?} {year?}
     */
    protected $signature = 'laporan:bulanan {month?} {year?}';

    /**
     * The console command description.
     */
    protected $description = 'Generate laporan keuangan bulanan (pemasukan, pengeluaran, laba bersih)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil argumen atau default bulan & tahun sekarang
        $month = $this->argument('month') ?? Carbon::now()->month;
        $year  = $this->argument('year') ?? Carbon::now()->year;

        $this->info("📊 Laporan Keuangan Bulan $month/$year");

        // Hitung pemasukan (Booking Paid)
        $pemasukan = Booking::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->where('payment_status', 'Paid')
            ->sum('tarif');

        // Hitung pengeluaran (Laporans)
        $pengeluaran = Laporan::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->sum('jumlah');

        $laba = $pemasukan - $pengeluaran;

        // Tampilkan ringkasan di terminal
        $this->table(
            ['Total Pemasukan', 'Total Pengeluaran', 'Laba Bersih'],
            [[
                "Rp " . number_format($pemasukan, 0, ',', '.'),
                "Rp " . number_format($pengeluaran, 0, ',', '.'),
                "Rp " . number_format($laba, 0, ',', '.'),
            ]]
        );

        // Detail transaksi (pemasukan + pengeluaran)
        $transaksi_pemasukan = Booking::select(
            'tanggal',
            'invoice_no as deskripsi',
            'payment_type as metode',
            'tarif as jumlah'
        )
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->where('payment_status', 'Paid')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Pemasukan';
                return $item;
            });

        $transaksi_pengeluaran = Laporan::select(
            'tanggal',
            'deskripsi',
            'metode',
            'jumlah'
        )
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Pengeluaran';
                return $item;
            });

        $transaksi = $transaksi_pemasukan
            ->merge($transaksi_pengeluaran)
            ->sortByDesc('tanggal');

        // Output detail transaksi
        $this->table(
            ['Tanggal', 'Deskripsi', 'Tipe', 'Metode', 'Jumlah'],
            $transaksi->map(function ($t) {
                return [
                    $t->tanggal,
                    $t->deskripsi,
                    $t->tipe,
                    $t->metode ?? '-',
                    "Rp " . number_format($t->jumlah, 0, ',', '.'),
                ];
            })->toArray()
        );

        $this->info("✅ Laporan selesai ditampilkan.");
    }
}
