<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukUmkm extends Model
{
    use HasFactory;

    protected $table = 'produk_umkms';
    protected $fillable = [
        'umkm_id',
        'nama_produk',
        'harga_produk',
        'created_by',
        'updated_by',
    ];
}
