<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruang_host extends Model
{
    protected $table = 'ruang_host'; 

    protected $fillable = [
        'id_host',
        'id_gelombang',
        'status',
        'id_ruang',
    ];
    public $timestamps = false;
}
