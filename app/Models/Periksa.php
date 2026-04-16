<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    protected $table = 'periksa';
    protected $fillable = [
        'id_pasien',
        'id_jadwal_jaga',
        'keluhan',
        'no_antrian',
        'nama_penyakit',
        'catatan',
        'tgl_periksa',
        'biaya_periksa',
        'status_periksa',
    ];
}
