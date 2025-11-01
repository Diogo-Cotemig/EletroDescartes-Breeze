<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agendamento_id')
                  ->constrained('agendamentos_coleta')
                  ->onDelete('cascade');
            $table->decimal('valor', 10, 2);

            // 👇 ESSA É A COLUNA QUE FALTAVA
            $table->string('metodo')->default('pix');

            $table->enum('status', ['pendente', 'pago', 'cancelado'])->default('pendente');
            $table->string('codigo_pix')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};

