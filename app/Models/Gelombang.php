<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    protected $table = 'gelombang'; 
    protected $primaryKey = 'id_gelombang'; // Adjust this if necessary
    protected $fillable = [
        'gelombang_name',
        'date',
        'gelombang',
        'semester',
    ];
}