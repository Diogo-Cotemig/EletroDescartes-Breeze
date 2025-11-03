<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendamentoColeta extends Model
{
    use HasFactory;
    
    // Define o nome da tabela no banco de dados
    protected $table = 'agendamentos_coleta';

    // Campos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'nome_completo',
        'telefone',
        'email',
        'itens_descartados',
        'observacoes_itens',
        'data_coleta',
        'periodo_preferencia',
        'distancia_estimada',
        'status',
    ];
}
