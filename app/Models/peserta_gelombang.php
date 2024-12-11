<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peserta_gelombang extends Model
{protected $table = 'peserta_gelombang'; 

    protected $fillable = [
        'no_peserta',
        'id_gelombang',
    ];

    public $timestamps = false;
}