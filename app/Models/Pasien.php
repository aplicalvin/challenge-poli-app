<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $fillable = [
        'id_user',
        'nama',
        'alamat',
        'no_ktp',
        'no_hp',
        'no_rm',
    ];
}
