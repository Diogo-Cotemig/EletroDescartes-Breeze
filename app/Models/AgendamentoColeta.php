<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'user_id',
    ];
    
    /**
     * Um agendamento tem um pagamento associado.
     * Usamos 'agendamento_id' como chave estrangeira na tabela 'pagamentos'.
     */
    public function pagamento(): HasOne
    {
        // hasOne(ModelRelacionado::class, 'nome_da_fk_na_tabela_relacionada')
        return $this->hasOne(Pagamento::class, 'agendamento_id');
    }
    public function usuario()
   {
    return $this->belongsTo(User::class, 'user_id');
  }
}