<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('scratch_cards', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nome da raspadinha (ex: Centavo da Sorte)
        $table->string('description')->nullable(); // Descrição breve (opcional)
        $table->string('banner')->nullable(); // Caminho do banner (largão, tipo um "destaque")
        $table->string('image')->nullable(); // Caminho da imagem/card (ícone ou imagem quadrada)
        $table->decimal('price', 10, 2)->default(0); // Preço para jogar
        $table->string('max_prize')->nullable(); // Prêmio máximo exibido (ex: "60.000,00")
        $table->float('rtp')->default(30); // Porcentagem de vitória (RTP)
        $table->boolean('active')->default(true); // Card ativo/desativado
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
         public function down()
        {
            Schema::dropIfExists('scratch_cards');
        }

};
