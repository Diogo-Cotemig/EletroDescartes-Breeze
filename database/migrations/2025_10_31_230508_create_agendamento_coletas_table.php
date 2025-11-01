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
        Schema::create('agendamentos_coleta', function (Blueprint $table) {
            $table->id();

            // Dados do Cliente
            $table->string('nome_completo');
            $table->string('telefone');
            $table->string('email');

            // Dados da Coleta e Itens
            $table->text('itens_descartados'); // Ex: Hardware, Monitores, Cabos/Fios
            $table->text('observacoes_itens')->nullable();

            // Agendamento
            $table->date('data_coleta');
            $table->string('periodo_preferencia'); // Ex: manha, tarde, comercial

            // Informação da Rota (Opcional, mas útil para registro)
            $table->string('distancia_estimada')->nullable();

            // Status do Agendamento (para controle futuro)
            $table->enum('status', ['pendente', 'agendado', 'concluido', 'cancelado'])->default('pendente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamento_coletas');
    }
};
