<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $fillable = [
        'id_user',
        'id_poli',
        'nama',
        'alamat',
        'no_hp',
        'no_ktp',
    ];
}
