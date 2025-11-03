<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    // 👇 força o nome correto da tabela no banco
    protected $table = 'pagamentos';

    protected $fillable = [
        'agendamento_id',
        'valor',
        'metodo',
        'status',
        'codigo_pix',
    ];

    public function agendamento()
    {
        return $this->belongsTo(AgendamentoColeta::class, 'agendamento_id');
    }
}
