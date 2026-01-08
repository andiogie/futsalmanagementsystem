<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 0; font-size: 12px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }

        .section-title { margin-top: 20px; font-weight: bold; font-size: 14px; }
        .footer { margin-top: 30px; font-size: 11px; text-align: right; }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <h1>FutsalGo</h1>
        <p>Jl. Merdeka No.123, Jakarta</p>
        <p>Telp: (021) 1234567 | Email: info@futsalgo.com</p>
    </div>

    <h2>Laporan Keuangan Periode {{ $month }}/{{ $year }}</h2>

    <!-- PEMASUKAN -->
    <p class="section-title">Pemasukan</p>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Metode</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->where('tipe', 'Pemasukan') as $t)
            <tr>
                <td>{{ $t->tanggal }}</td>
                <td>{{ $t->deskripsi }}</td>
                <td>{{ $t->metode ?? '-' }}</td>
                <td>Rp {{ number_format($t->jumlah,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align:right;">Total Pemasukan</th>
                <th>Rp {{ number_format($total_pemasukan_detail ?? $total_pemasukan,0,',','.') }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- PENGELUARAN -->
    <p class="section-title">Pengeluaran</p>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Metode</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->where('tipe', 'Pengeluaran') as $t)
            <tr>
                <td>{{ $t->tanggal }}</td>
                <td>{{ $t->deskripsi }}</td>
                <td>{{ $t->metode ?? '-' }}</td>
                <td>Rp {{ number_format($t->jumlah,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align:right;">Total Pengeluaran</th>
                <th>Rp {{ number_format($total_pengeluaran_detail ?? $pengeluaran,0,',','.') }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- LABA BERSIH -->
    <p class="section-title">Laba Bersih</p>
    <table>
        <tr>
            <th>Total Pemasukan</th>
            <td>Rp {{ number_format($total_pemasukan,0,',','.') }}</td>
        </tr>
        <tr>
            <th>Total Pengeluaran</th>
            <td>Rp {{ number_format($pengeluaran,0,',','.') }}</td>
        </tr>
        <tr>
            <th>Jumlah Akhir</th>
            <td><strong>Rp {{ number_format($laba,0,',','.') }}</strong></td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Dicetak oleh: {{ $printed_by ?? 'Administrator' }}</p>
        <p>Tanggal Cetak: {{ ($printed_at ?? now())->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
