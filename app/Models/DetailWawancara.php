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
        'id_gelombang',
        'status',
        'q1',
        'q2',
        'q3',
        'q4',
        'q5',
        'completion',
    ];

    protected $primaryKey = 'id_detail_wawancara'; // Specify the actual primary key
    public $timestamps = false;

}