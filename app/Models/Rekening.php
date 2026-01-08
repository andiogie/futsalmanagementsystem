<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'mst_rekening';

    protected $fillable = [
        'bank_account',
        'bank_name',
        'account_name',
    ];
}
