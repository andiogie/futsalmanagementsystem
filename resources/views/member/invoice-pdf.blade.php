<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $booking->invoice_no }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 25px; }
        .section { max-width: 650px; margin: 0 auto; }
        .row { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .label { font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; }
        hr { border: none; border-top: 1px solid #ccc; margin: 15px 0; }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h2 style="margin:0;">FutsalGo Management</h2>
        <p style="margin:0;">Jl. Merdeka No.123, Jakarta</p>
        <p style="margin:0;">Telp: 0812-3456-7890</p>
        <hr>
        <p>No Invoice: <strong>{{ $booking->invoice_no }}</strong></p>
    </div>

    {{-- Detail Booking --}}
    <div class="section">
        <div class="row">
            <div class="label">Nama</div>
            <div>{{ $booking->nama }}</div>
        </div>
        <div class="row">
            <div class="label">Tanggal Booking</div>
            <div>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}</div>
        </div>
        <div class="row">
            <div class="label">Lapangan</div>
            <div>{{ $booking->lapangan->nama_lapangan ?? '-' }}</div>
        </div>
        <div class="row">
            <div class="label">Jam</div>
            <div>
                {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - 
                {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
            </div>
        </div>
        <div class="row">
            <div class="label">Durasi</div>
            <div>{{ $booking->durasi }} jam</div>
        </div>

        {{-- Hitung harga --}}
        @php
            $hargaLapangan = $booking->tarif;
            $durasi = $booking->durasi;
            $subtotal = $hargaLapangan * $durasi;
            $diskon = $booking->diskon ?? 0; // bisa null
            $total = $subtotal - $diskon;
        @endphp

        <div class="row">
            <div class="label">Harga Lapangan</div>
            <div>Rp {{ number_format($hargaLapangan,0,',','.') }}</div>
        </div>
        <div class="row">
            <div class="label">Subtotal (Harga x Durasi)</div>
            <div>Rp {{ number_format($subtotal,0,',','.') }}</div>
        </div>

        @if($diskon > 0)
            <div class="row">
                <div class="label">Diskon</div>
                <div>- Rp {{ number_format($diskon,0,',','.') }}</div>
            </div>
            <div class="row" style="font-weight:bold;">
                <div class="label">Total Payment</div>
                <div>Rp {{ number_format($total,0,',','.') }}</div>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name ?? 'System' }}</p>
        <p>Tanggal cetak: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
