<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fakt_zamowienie', function (Blueprint $table) {
            $table->id('zamowienie_id');

            $table->unsignedInteger('klient_id');
            $table->unsignedInteger('produkt_id');
            $table->unsignedInteger('czas_id');
            $table->integer('ilosc');
            $table->double('wartosc');
            $table->string('status', 20);

            // Klucze obce
            $table->foreign('klient_id')
                  ->references('klient_id')->on('dim_klient')->onDelete('cascade');

            $table->foreign('produkt_id')
                  ->references('produkt_id')->on('dim_produkt')->onDelete('cascade');

            $table->foreign('czas_id')
                  ->references('czas_id')->on('dim_czas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fakt_zamowienie');
    }
};
