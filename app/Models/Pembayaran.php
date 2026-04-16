<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = [
        'id_periksa',
        'total_bayar',
        'bukti_pembayaran',
        'status_pembayaran',
        'tgl_bayar',
        'verified_by',
    ];
}
