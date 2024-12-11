<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    protected $table = 'host'; 

    protected $fillable = [
        'id_host',
        'id_ruang',
        'nama_host',
        'username_zoom',
        'pass_zoom',
    ];

    
    public $timestamps = false;

}