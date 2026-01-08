@extends('member.layout')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="px-4">

        <!-- Welcome Banner -->
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6">
            <h1 class="text-xl font-semibold mb-2">Selamat Datang di Futsal XYZ!</h1>
            <p>Berikut panduan untuk melakukan pemesanan lapangan dan pembayaran.</p>
        </div>

        <!-- Cara Booking Lapangan -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Cara Booking Lapangan</h2>
            <ol class="list-decimal list-inside space-y-2 text-gray-700">
                <li>Pilih tanggal dan jam lapangan</li>
                <li>Pilih lapangan yang tersedia</li>
                <li>Jika selesai Submit, silahkan pilih pembayaran dan upload bukti bayar ke halaman Riwayat Booking</li>
            </ol>
        </div>

        <!-- Cara Pembayaran -->
        <div id="informasi" class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Cara Pembayaran</h2>

            <div class="space-y-3">
                <div class="p-4 bg-white border rounded shadow-sm">
                    <h3 class="font-semibold mb-1">1. Cash</h3>
                    <p>Silakan datang langsung ke alamat: <strong>Jl. Contoh No.123, Jakarta</strong></p>
                </div>

                <div class="p-4 bg-white border rounded shadow-sm">
                    <h3 class="font-semibold mb-1">2. QRIS</h3>
                    <p>Silakan informasikan pembayaran QRIS Anda ke admin melalui WhatsApp atau email yang tersedia.</p>
                </div>

                <div class="p-4 bg-white border rounded shadow-sm">
                    <h3 class="font-semibold mb-1">3. Transfer Bank / E-Wallet</h3>
                    <p>Silakan lampirkan bukti transfer di menu <strong>Riwayat Booking</strong> atau kirimkan ke admin.</p>

                    @forelse($rekenings as $rekening)
                        <div class="mt-4 p-3 border rounded bg-gray-50">
                            {{-- Logo bankName-nya diambil dari helper --}}
                            <img src="{{ bankLogoUrl($rekening->bank_name) }}" alt="{{ $rekening->bank_name }}" class="w-16 mb-2">
                            <p><strong>Bank / E-Wallet:</strong> {{ $rekening->bank_name }}</p>
                            <p><strong>Nomor:</strong> {{ $rekening->bank_account }}</p>
                            <p><strong>Atas Nama:</strong> {{ $rekening->account_name }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada data rekening.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Konfirmasi Pesanan -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Konfirmasi Pesanan</h2>
            <ol class="list-decimal list-inside space-y-2 text-gray-700">
                <li>Setelah melakukan pembayaran, unggah bukti transfer melalui menu <strong>Riwayat Booking</strong>.</li>
                <li>Tunggu hingga admin mengonfirmasi pembayaran dan status berubah menjadi <span class="font-semibold text-green-600">Paid</span>.</li>
                <li>Jika dalam waktu 1x24 jam status belum diperbarui menjadi Paid, silakan hubungi admin melalui 
                    <a href="https://wa.me/6281234567890" target="_blank" class="text-green-600 hover:underline font-semibold">
                        WhatsApp
                    </a>.
                </li>
            </ol>
        </div>

        <!-- Info Tambahan / Promo -->
        <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 rounded">
            <h2 class="text-lg font-semibold mb-2">Info Penting</h2>
            <p>Pastikan membawa bukti pembayaran jika membayar secara transfer atau QRIS. Untuk promo terbaru, cek halaman
                <strong>Booking</strong> sebelum memesan.</p>
        </div>

    </div>
@endsection