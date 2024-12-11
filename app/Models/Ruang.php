<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{   
    protected $table = 'ruang'; 
    protected $fillable = [
        'id_gelombang',
        'id_ruang',
        'link_ruang',
    ];    
    public $timestamps = false;
}