<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkms';
    protected $fillable = [
        'masyarakat_id',
        'nama_usaha',
        'alamat_usaha',
        'jenis_usaha',
        'created_by',
        'updated_by',
    ];
}
