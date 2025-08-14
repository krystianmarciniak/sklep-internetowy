<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dim_produkt', function (Blueprint $table) {
            $table->id('produkt_id');
            $table->string('nazwa', 100);
            $table->string('parametr', 50)->nullable();
            $table->double('cena_brutto', 10, 2);
            $table->unsignedBigInteger('id_kategoria');
            $table->foreign('id_kategoria')->references('kategoria_id')->on('dim_kategoria');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('dim_produkt');
    }
};
