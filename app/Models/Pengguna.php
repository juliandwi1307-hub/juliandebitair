<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Tagihan;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'pengguna_id');
    }
}
