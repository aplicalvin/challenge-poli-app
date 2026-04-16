<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shift';
    protected $fillable = [
        'nama',
        'jam_masuk',
        'jam_keluar',
        'hari',
    ];
}
