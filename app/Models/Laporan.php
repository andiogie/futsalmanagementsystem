<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'tanggal',
        'deskripsi',
        'tipe',
        'metode',
        'jumlah',
        'bukti',
    ];
}
