<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('gelombang', function (Blueprint $table) {
            $table->id('id_gelombang')->primary();
            $table->string('gelombang_name');
            $table->date('date');
            $table->integer('gelombang');
            $table->string('semester');
            $table->boolean('status')->default(true); 
            $table->string('file_path')->nullable(); 
            $table->timestamps();
        });

        Schema::create('ruang', function (Blueprint $table) {
            $table->string('id_ruang')->primary();
            $table->string('link_ruang');
        });

        Schema::create('ruang_gelombang', function (Blueprint $table) {
            $table->id('id_ruang_gelombang')->primary();
            $table->string('id_ruang');
            $table->unsignedBigInteger('id_gelombang');
            $table->foreign('id_gelombang')->references('id_gelombang')->on('gelombang')->onDelete('cascade');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruang')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('peserta', function (Blueprint $table) {
            $table->string('no_peserta')->primary();
            $table->string('peserta');
            $table->string('prodi'); 
            $table->timestamps();
        });  
        
        Schema::create('peserta_gelombang', function (Blueprint $table) {
            $table->id('id_peserta_ruang')->primary();
            $table->string('no_peserta');
            $table->foreign('no_peserta')->references('no_peserta')->on('peserta')->onDelete('cascade');
            $table->unsignedBigInteger('id_gelombang');
            $table->foreign('id_gelombang')->references('id_gelombang')->on('gelombang')->onDelete('cascade');
            $table->timestamps();
        });
  
        Schema::create('pewawancara', function (Blueprint $table) {
            $table->string('id_pewawancara')->primary();;
            $table->string('pewawancara_name');
            $table->timestamps();
            $table->string('password')->default(Str::random(10));
        });

        Schema::create('detail_wawancara', function (Blueprint $table) {
            $table->id('id_detail_wawancara')->primary();
            $table->unsignedBigInteger('id_gelombang');
            $table->foreign('id_gelombang')->references('id_gelombang')->on('gelombang')->onDelete('cascade');
            $table->string('id_pewawancara');
            $table->string('no_peserta');
            $table->foreign('id_pewawancara')->references('id_pewawancara')->on('pewawancara')->onDelete('cascade');
            $table->foreign('no_peserta')->references('no_peserta')->on('peserta')->onDelete('cascade');
            $table->boolean('status')->default(true); 
            $table->string('q1');
            $table->string('q2');
            $table->string('q3');
            $table->string('q4');
            $table->string('q5');
            $table->boolean('completion')->default(false);
            $table->timestamps();
        });

        Schema::create('host', function (Blueprint $table) {
            $table->string('id_host')->primary();
            $table->string('nama_host');
            $table->string('username_zoom');
            $table->string('pass_zoom');
        });        

        Schema::create('ruang_host', function (Blueprint $table) {
            $table->id('id_ruang_host')->primary();
            $table->string('id_host');
            $table->foreign('id_host')->references('id_host')->on('host')->onDelete('cascade');
            $table->string('id_ruang');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruang')->onDelete('cascade');
            $table->unsignedBigInteger('id_gelombang');
            $table->foreign('id_gelombang')->references('id_gelombang')->on('gelombang')->onDelete('cascade');
            $table->boolean('status')->default(true); 
        });   

        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin')->primary();
            $table->string('username');
            $table->string('password');
        });

        Schema::create('pimpinan', function (Blueprint $table) {
            $table->id('id_pimpinan')->primary();
            $table->string('password');
            $table->string('nama_pimpinan');
        });

        Schema::create('ruang_pewawancara', function (Blueprint $table) {
            $table->id('id_pewawancara_ruang')->primary();
            $table->string('id_pewawancara');
            $table->foreign('id_pewawancara')->references('id_pewawancara')->on('pewawancara')->onDelete('cascade');
            $table->string('id_ruang');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruang')->onDelete('cascade');
            $table->unsignedBigInteger('id_gelombang');
            $table->foreign('id_gelombang')->references('id_gelombang')->on('gelombang')->onDelete('cascade');
            $table->boolean('status')->default(true); 
        }); 

    
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merged_participants');
    }
};
