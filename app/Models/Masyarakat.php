<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $table = 'masyarakats';
    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'created_by',
        'updated_by',
    ];
}
