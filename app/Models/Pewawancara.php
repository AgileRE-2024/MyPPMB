<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pewawancara extends Model
{
    protected $table = 'pewawancara'; 

    protected $fillable = [
        'id_pewawancara',
        'pewawancara_name',
        'nip',
        'id_ruang',
    ];
    public $timestamps = false;

}