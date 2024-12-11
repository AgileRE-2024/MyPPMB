<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Peserta extends Model
{
    protected $table = 'peserta'; 
    protected $primaryKey = 'no_peserta'; 
    protected $keyType = 'string'; 
    protected $fillable = [
        'no_peserta',
        'id_ruang',
        'peserta',
        'prodi',
    ];

    public $timestamps = false;
    
    public function gelombangs()
    {
        return $this->belongsToMany(Gelombang::class, 'peserta_gelombang', 'no_peserta', 'id_gelombang');
    }

    
    
}