<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lapangan extends Model
{
    use HasFactory;

    protected $table = 'mst_lapangan';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_lapangan', 'foto_lapangan', 'tarif'];
}
