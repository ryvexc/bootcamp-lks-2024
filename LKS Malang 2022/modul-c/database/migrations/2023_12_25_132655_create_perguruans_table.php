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
        Schema::create('perguruans', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->enum("kategori", ["Politeknik", "Swasta", "Negeri", "Sekolah Tinggi", "Institut"]);
            $table->integer("biaya");
            $table->string("telepon");
            $table->string("email");
            $table->string("whatsapp");
            $table->string("link_gambar")->nullable();
            $table->string("description")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perguruans');
    }
};
