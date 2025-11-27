<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rotas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rotas');
    }
};
