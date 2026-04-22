<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeriksaObat extends Model
{
    protected $table = 'detail_periksa_obat';
    protected $fillable = [
        'id_periksa',
        'id_obat',
        'jumlah',
        'harga_saat_ini',
    ];
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
