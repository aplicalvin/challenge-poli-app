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
        'added_by',
        'edited_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }
}
