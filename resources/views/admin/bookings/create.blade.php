@extends('admin.layout')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            {{-- Error Validasi --}}
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
                    <p class="font-semibold">❌ Terjadi Kesalahan!</p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4">
                    <p class="font-semibold">✅ Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <h2 class="text-2xl font-bold text-center text-green-600 mb-6">Form Booking Non-Member</h2>

            {{-- 🟢 Penting: arahkan ke route admin non_member.store --}}
            <form action="{{ route('bookings.non_member.store') }}" method="POST" class="space-y-4" id="formBooking">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block font-semibold mb-1">Nama Pemesan</label>
                    <input type="text" name="nama"
                           class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                           required>
                </div>

                <!-- Nomor WhatsApp -->
                <div>
                    <label class="block font-semibold mb-1">Nomor WhatsApp</label>
                    <input type="tel" name="whatsapp"
                           class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                           required>
                </div>

                <!-- Tanggal Booking -->
                <div>
                    <label class="block font-semibold mb-1">Tanggal Booking</label>
                    <input type="date" name="tanggal"
                           class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                           required min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                </div>

                <!-- Pilih Lapangan -->
                <div>
                    <label class="block font-semibold mb-1">Lapangan</label>
                    <select id="lapangan" name="lapangan_id"
                            class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                        <option value="">-- Pilih Lapangan --</option>
                        @foreach($lapangan as $l)
                            <option value="{{ $l->id }}" data-tarif="{{ $l->tarif }}">
                                {{ $l->nama_lapangan }} (Rp {{ number_format($l->tarif) }}/jam)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jam Mulai -->
                <div>
                    <label class="block font-semibold mb-1">Jam Mulai</label>
                    <select id="jam_mulai" name="jam_mulai"
                            class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                        <option value="">-- Pilih Jam Mulai --</option>
                        @for ($jam = 9; $jam <= 23; $jam++)
                            <option value="{{ sprintf('%02d:00', $jam) }}">{{ sprintf('%02d:00', $jam) }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Jam Selesai -->
                <div>
                    <label class="block font-semibold mb-1">Jam Selesai</label>
                    <select id="jam_selesai" name="jam_selesai"
                            class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400"
                            required>
                        <option value="">-- Pilih Jam Selesai --</option>
                    </select>
                </div>

                <!-- Durasi -->
                <div>
                    <label class="block font-semibold mb-1">Durasi (jam)</label>
                    <input type="text" id="durasi" name="durasi"
                           class="w-full border rounded-lg p-2 bg-gray-100" readonly>
                </div>

                <!-- Tarif Awal -->
                <div>
                    <label class="block font-semibold mb-1">Tarif Awal</label>
                    <input type="text" id="tarif_awal" name="tarif_awal"
                           class="w-full border rounded-lg p-2 bg-gray-100" readonly>
                </div>

                <!-- Kode Diskon -->
                <div class="mb-4">
                    <label for="kode_diskon" class="block text-sm font-medium">Kode Diskon</label>
                    <input type="text" id="kode_diskon" name="kode_diskon" class="w-full border rounded px-3 py-2">
                    <div id="couponNotif" class="hidden mt-2 text-sm"></div>
                </div>

                <!-- Tarif Akhir -->
                <div>
                    <label class="block font-semibold mb-1">Tarif Akhir</label>
                    <input type="text" id="tarif_akhir" name="tarif"
                           class="w-full border rounded-lg p-2 bg-gray-100" readonly>
                </div>

                <!-- Tombol -->
                <div class="text-center space-x-2">
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg mb-4">
                        <p class="font-semibold">⚠️ Perhatian!</p>
                        <p>Silakan isi data dengan benar dan lengkap.</p>
                    </div>

                    <button type="button" id="btnSubmit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full font-semibold shadow-lg transition">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Booking
                    </button>

                    <a href="{{ route('bookings.index') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-full font-semibold shadow-lg transition inline-flex items-center justify-center">
                        <i class="fa-solid fa-xmark"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Modal Konfirmasi Booking -->
<div id="confirmModal"
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div id="confirmBox"
         class="bg-white rounded-2xl shadow-2xl p-6 w-96 text-center transform scale-95 opacity-0 transition-all duration-300">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Booking</h2>
        <p class="mb-6 text-gray-600">Apakah data booking sudah benar?</p>
        <div class="flex justify-center space-x-4">
            <button type="button" id="btnCancelModal"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition">
                Batal
            </button>
            <button type="submit" id="btnConfirmModal"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                Ya, Kirim
            </button>
        </div>
    </div>
</div>

<script>
    const diskons = @json($diskons);
</script>
@endsection
