<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pimpinan extends Model
{
    protected $table = 'pimpinan'; 

    protected $fillable = [
        'id_pimpinan',
        'password',
        'nama_pimpinan',
    ];

    public $timestamps = false;

}