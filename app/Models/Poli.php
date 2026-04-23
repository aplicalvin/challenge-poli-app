<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table = 'poli';
    protected $fillable = [
        'nama_poli',
        'keterangan',
        'added_by',
        'edited_by',
    ];

    public function adder()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }

    public function ruangs()
    {
        return $this->hasMany(Ruang::class, 'id_poli');
    }
}
