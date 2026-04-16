<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $table = 'ruang';
    protected $fillable = [
        'nama',
        'id_poli',
        'created_by',
    ];
}
