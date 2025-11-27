<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primeiro, atualiza registros existentes com valores antigos
        DB::table('pagamentos')
            ->where('status', 'pago')
            ->update(['status' => 'aprovado']);
            
        DB::table('pagamentos')
            ->where('status', 'cancelado')
            ->update(['status' => 'rejeitado']);
        
        // Agora altera o ENUM para os novos valores
        DB::statement("ALTER TABLE `pagamentos` MODIFY COLUMN `status` ENUM('pendente', 'aprovado', 'rejeitado') NOT NULL DEFAULT 'pendente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       DB::statement("ALTER TABLE `pagamentos` MODIFY COLUMN `status` ENUM('pendente', 'pago', 'cancelado') NOT NULL DEFAULT 'pendente'");
    }
};
