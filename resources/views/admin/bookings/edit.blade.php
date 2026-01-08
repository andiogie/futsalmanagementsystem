@extends('admin.layout')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Update Pembayaran</h1>

    <form action="{{ route('bookings.update', $booking->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-semibold">Invoice</label>
            <input type="text" value="{{ $booking->invoice_no }}" disabled
                   class="w-full border rounded p-2 bg-gray-100">
        </div>

        <div>
            <label class="block font-semibold">Nama</label>
            <input type="text" value="{{ $booking->nama }}" disabled
                   class="w-full border rounded p-2 bg-gray-100">
        </div>

        <div>
            <label class="block font-semibold">Lapangan</label>
            <input type="text" value="{{ $booking->lapangan?->nama_lapangan }}" disabled
                   class="w-full border rounded p-2 bg-gray-100">
        </div>

        <div>
            <label class="block font-semibold">Tarif</label>
            <input type="text" 
                value="Rp {{ number_format($booking->tarif, 0, ',', '.') }}" 
                disabled
                class="w-full border rounded p-2 bg-gray-100">
        </div>

        <div>
            <label class="block font-semibold">Payment Type</label>
            <select name="payment_type" class="w-full border rounded p-2">
                <option value="" {{ $booking->payment_type == null ? 'selected' : '' }}>- Belum dipilih -</option>
                <option value="Cash" {{ $booking->payment_type == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="QRIS" {{ $booking->payment_type == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                <option value="Transfer" {{ $booking->payment_type == 'Transfer' ? 'selected' : '' }}>Transfer</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Payment Status</label>
            <select name="payment_status" class="w-full border rounded p-2">
                <option value="Pending" {{ $booking->payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Paid" {{ $booking->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Cancel" {{ $booking->payment_status == 'Cancel' ? 'selected' : '' }}>Cancel</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Bukti Pembayaran</label>
            @if($booking->payment_proof)
                <div class="mb-2">
                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="text-blue-600 underline">
                        Lihat Bukti
                    </a>
                </div>
            @endif
            <input type="file" name="payment_proof" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Catatan / Alasan</label>
            <textarea name="notes" class="w-full border rounded p-2" rows="3">{{ old('notes', $booking->notes) }}</textarea>
        </div>

        <button type="submit" 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">Update</button>
        <a href="{{ route('bookings.index') }}" 
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">
            Batal
        </a>
    </form>
@endsection
