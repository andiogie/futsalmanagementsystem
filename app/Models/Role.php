<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles'; // tabel yang dipakai
    protected $fillable = ['name', 'guard_name'];
}
