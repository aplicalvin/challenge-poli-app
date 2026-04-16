<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalJaga extends Model
{
    protected $table = 'jadwal_jaga';
    protected $fillable = [
        'id_shift',
        'id_dokter',
        'id_ruang',
    ];
}
