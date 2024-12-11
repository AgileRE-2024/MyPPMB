<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{   
    protected $primaryKey = 'id_gelombang'; // Set the primary key
    protected $table = 'gelombang'; 
    protected $fillable = ['gelombang_name', 'date', 'gelombang', 'semester', 'status'];
    public function pesertas()
    {
    return $this->belongsToMany(Peserta::class, 'peserta_gelombang', 'id_gelombang', 'no_peserta');
    }
}