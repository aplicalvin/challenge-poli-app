<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $fillable = [
        'id_user',
        'nama',
        'alamat',
        'no_hp',
        'added_by',
        'edited_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
