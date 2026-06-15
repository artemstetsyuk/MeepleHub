<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('board_games', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Переконайся, що цей рядок є і називається саме title!
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2);
        $table->integer('min_players');
        $table->integer('max_players');
        $table->integer('duration');
        $table->integer('stock')->default(0);
        
        // Зв'язок з категорією (зовнішній ключ)
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('board_games');
    }
};