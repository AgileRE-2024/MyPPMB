<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruang_pewawancara extends Model
{
    protected $table = 'ruang_pewawancara'; 

    protected $fillable = [
        'id_pewawancara',
        'id_gelombang',
        'status',
        'id_ruang',
    ];

    public $timestamps = false;

}