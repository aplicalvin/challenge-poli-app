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

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'id_shift');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'id_ruang');
    }
}
