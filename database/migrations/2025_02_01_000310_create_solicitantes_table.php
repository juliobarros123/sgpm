<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitantes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('grupo_id')->nullable(); // Permitir NULL

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('grupo_id')
                ->references('id')
                ->on('grupos')
                ->onDelete('NO ACTION') // Mantém sem alteração ao deletar
                ->onUpdate('NO ACTION'); // Evita cascata na atualização

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitantes');
    }
};
