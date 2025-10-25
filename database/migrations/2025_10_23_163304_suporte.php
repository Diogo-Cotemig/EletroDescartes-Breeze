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
        Schema::create('suporte', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('category', [
                'coleta',
                'agendamento',
                'equipamento',
                'certificado',
                'pagamento',
                'outro'
            ]);
            $table->enum('priority', ['baixa', 'media', 'alta', 'urgente'])->default('baixa');
            $table->text('description');
            $table->json('attachments')->nullable();
            $table->boolean('receive_notifications')->default(true);
            $table->enum('status', ['pendente', 'em_andamento', 'resolvido', 'fechado'])->default('pendente');
            $table->timestamps();
            $table->softDeletes();

            // Índices para melhor performance nas consultas
            $table->index('email');
            $table->index('category');
            $table->index('priority');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
