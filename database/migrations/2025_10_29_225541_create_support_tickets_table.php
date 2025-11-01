<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('category', ['coleta', 'agendamento', 'equipamento', 'certificado', 'pagamento', 'outro']);
            $table->enum('priority', ['baixa', 'media', 'alta', 'urgente'])->default('baixa');
            $table->text('description');
            $table->string('attachment')->nullable();
            $table->enum('status', ['aberto', 'em_andamento', 'respondido', 'fechado'])->default('aberto');
            $table->boolean('notifications')->default(true);
            $table->text('admin_response')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
