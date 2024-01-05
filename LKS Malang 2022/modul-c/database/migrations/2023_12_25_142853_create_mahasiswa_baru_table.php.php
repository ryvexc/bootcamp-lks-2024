<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa_baru', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->integer("perguruan_id");
            $table->integer("fakultas_id");
            $table->integer("jurusan_id");
            $table->integer("user_id");
            $table->boolean("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_baru');
    }
};
