<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'pagamentos';

    protected $fillable = [
        'agendamento_id',
        'user_id',           // 👈 ADICIONAR
        'valor',
        'metodo',
        'status',
        'codigo_pix',
        'points_awarded',    // 👈 ADICIONAR
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'points_awarded' => 'decimal:2',
    ];

    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(AgendamentoColeta::class, 'agendamento_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}