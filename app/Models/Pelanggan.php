<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'urutan','kode','nama',
        'intensitas','frekuensi','porsi','loyalitas',
        'lama','rekomendasi'
    ];

    // kalau mau tampil tanpa simpan "kode", bisa pakai ini
    public function getKodeLabelAttribute(): string
    {
        return 'A'.$this->urutan;
    }
}
