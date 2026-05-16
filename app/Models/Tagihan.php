<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihans';

    protected $fillable = [
        'pengguna_id',
        'nama',
        'bulan',
        'tahun',
        'awal',
        'akhir',
        'jumlah',
        'tarif',
        'tagihan',
        'status'
    ];
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id', 'id'); // 'pengguna_id' adalah foreign key
    }
}
