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

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }

    public function jadwalJaga()
    {
        return $this->hasMany(JadwalJaga::class, 'id_ruang');
    }
}
