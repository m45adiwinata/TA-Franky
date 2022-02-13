<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
