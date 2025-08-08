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
    Schema::create('scratch_card_plays', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('scratch_card_id');
        $table->json('cards'); // Resultado sorteado
        $table->boolean('win')->default(false);
        $table->decimal('prize', 10, 2)->default(0);
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('scratch_card_id')->references('id')->on('scratch_cards');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scratch_card_plays');
    }
};
