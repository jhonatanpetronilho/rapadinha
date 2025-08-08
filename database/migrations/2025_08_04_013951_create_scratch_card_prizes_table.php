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
            Schema::create('scratch_card_prizes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('scratch_card_id');
                $table->string('name'); // Nome do prêmio: “Pix 100”, “Nada”, etc
                $table->decimal('value', 10, 2)->default(0);
                $table->string('image')->nullable(); // Imagem do prêmio
                $table->integer('quantity')->default(1); // Quantas vezes aparece na raspadinha
                $table->timestamps();

                $table->foreign('scratch_card_id')->references('id')->on('scratch_cards')->onDelete('cascade');
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scratch_card_prizes');
    }
};
