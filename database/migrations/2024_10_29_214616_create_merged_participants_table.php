<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id('id_peserta')->primary();
            $table->string('no_peserta');
            $table->string('peserta');
            $table->string('prodi');
            $table->timestamps();
        });   
  
        Schema::create('gelombang', function (Blueprint $table) {
            $table->id('id_gelombang')->primary();
            $table->string('gelombang_name');
            $table->date('date');
            $table->integer('gelombang');
            $table->string('semester');
            $table->timestamps();
        });

        Schema::create('pewawancara', function (Blueprint $table) {
            $table->id('id_pewawancara')->primary();
            $table->string('pewawancara_name');
            $table->string('nip');
            $table->timestamps();
        });

        Schema::create('detail_wawancara', function (Blueprint $table) {
            $table->id('id_detail_wawancara')->primary();
            $table->string('no_peserta');
            $table->string('nip');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('merged_participants');
    }
};
