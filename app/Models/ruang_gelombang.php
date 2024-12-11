<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruang_gelombang extends Model
{
    protected $table = 'ruang_gelombang'; 

    protected $fillable = [
        'id_ruang',
        'id_gelombang',
    ];

    public $timestamps = false;

}