<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    public function stok()
    {
        return $this->hasMany(Stok::class, 'kode_barang', 'kode');
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($barang) {
             $barang->stok()->delete();
        });
    }
}
