<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MergedParticipant extends Model
{
    protected $fillable = ['no_peserta','peserta','prodi'];
}

