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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            $table->decimal('total');
            $table->enum('status', ['novo', 'em_revisao', 'alteracoes_solicitadas', 'aprovado', 'rejeitado']);
            $table->unsignedBigInteger('solicitante_id');
            $table->unsignedBigInteger('grupo_id');
            
            // Alteração para evitar conflitos de cascata
            $table->foreign('solicitante_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('NO ACTION')->onUpdate('NO ACTION'); // Mudança para NO ACTION

            $table->longText('motivo_alteracao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
