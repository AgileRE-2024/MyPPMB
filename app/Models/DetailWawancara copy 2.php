<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailWawancara extends Model
{
    protected $table = 'detail_wawancara'; 

    protected $fillable = [
        'no_peserta',
        'id_pewawancara',
    ];

    public $timestamps = false;

}