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
        Schema::create('pedido_has_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('material_id');
            $table->integer('quantidade');
            $table->decimal('subtotal');
            
            // Alterações para evitar conflitos de cascata
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('NO ACTION')->onUpdate('NO ACTION'); // Mudança para NO ACTION
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_has_materials');
    }
};
