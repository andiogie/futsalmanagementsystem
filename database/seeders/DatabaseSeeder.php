<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\Diskon;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================
        // USERS
        // ============================
        $member = User::create([
            'name'     => 'Owner Futsal',
            'email'    => 'owner@futsal.com',
            'nowa'     => '081122334455',
            'password' => Hash::make('owner123'),
            'roles'    => 'owner',
            'is_verified' => 1,
        ]);

        $member = User::create([
            'name'     => 'Admin Futsal',
            'email'    => 'admin@futsal.com',
            'nowa'     => '081122334456',
            'password' => Hash::make('admin123'),
            'roles'    => 'admin',
            'is_verified' => 1,
        ]);

        $member = User::create([
            'name'     => 'Member Futsal',
            'email'    => 'member@futsal.com',
            'nowa'     => '081122334457',
            'password' => Hash::make('member123'),
            'roles'    => 'member',
            'is_verified' => 1,
        ]);

        // ============================
        // LAPANGAN
        // ============================
        $lapanganA = Lapangan::create([
            'nama_lapangan' => 'Lapangan A',
            'tarif'         => 100000,
        ]);

        $lapanganB = Lapangan::create([
            'nama_lapangan' => 'Lapangan B',
            'tarif'         => 120000,
        ]);

        $lapanganC = Lapangan::create([
            'nama_lapangan' => 'Lapangan C',
            'tarif'         => 150000,
        ]);

        // ============================
        // BOOKINGS (contoh data)
        // ============================
        Booking::create([
            'nama'        => $member->name,
            'invoice_no'  => 'INV-20250823-0001',
            'whatsapp'    => $member->nowa,
            'tanggal'     => Carbon::today()->addDay()->format('Y-m-d'),
            'jam_mulai'   => '10:00',
            'jam_selesai' => '12:00',
            'durasi'      => 2,
            'tarif'       => 200000,
            'lapangan_id' => $lapanganA->id,
            'payment_status' => 'Pending',
        ]);

        Booking::create([
            'nama'        => $member->name,
            'invoice_no'  => 'INV-20250823-0002',
            'whatsapp'    => $member->nowa,
            'tanggal'     => Carbon::today()->addDays(2)->format('Y-m-d'),
            'jam_mulai'   => '15:00',
            'jam_selesai' => '17:00',
            'durasi'      => 2,
            'tarif'       => 240000,
            'lapangan_id' => $lapanganB->id,
            'payment_status' => 'Pending',
        ]);

        Diskon::create([
            'nama_diskon' => 'Diskon Member Baru',
            'kode' => 'NEW10',
            'tipe' => 'persentase',
            'nilai' => 10,
            'mulai' => now(),
            'berakhir' => now()->addMonths(1),
        ]);

        Diskon::create([
            'nama_diskon' => 'Diskon Pelajar',
            'kode' => 'PELAJAR20',
            'tipe' => 'nominal',
            'nilai' => 20000,
            'mulai' => null,
            'berakhir' => null,
        ]);
    }
}
