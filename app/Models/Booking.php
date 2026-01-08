<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'nama',
        'invoice_no',
        'whatsapp',
        'tanggal',
        'lapangan_id',
        'jam_mulai',
        'jam_selesai',
        'durasi',
        'tarif',
        'lapangan_id',
        'payment_type',
        'payment_status',
        'payment_proof',
        'notes',
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id');
    }
}
