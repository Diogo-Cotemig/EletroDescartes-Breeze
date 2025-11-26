<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicket extends Model
{
    // Nome da tabela (se não for o padrão)
    protected $table = 'support_tickets';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'category',
        'priority',
        'description',
        'attachment',
        'status',
        'admin_response',
        'responded_by',
        'responded_at'
    ];

    // Conversão de tipos
    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamento: usuário que criou
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacionamento: admin que respondeu
    public function respondedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    // Accessor: Label da categoria
    public function getCategoryLabelAttribute()
    {
        $categories = [
            'coleta' => 'Problema na Coleta',
            'agendamento' => 'Agendamento de Serviço',
            'equipamento' => 'Dúvida sobre Equipamento',
            'certificado' => 'Certificado de Descarte',
            'pagamento' => 'Questões de Pagamento',
            'outro' => 'Outros',
        ];
        return $categories[$this->category] ?? $this->category;
    }

    // Accessor: Label da prioridade
    public function getPriorityLabelAttribute()
    {
        $priorities = [
            'urgente' => '🚨 Urgente',
            'alta' => '🔴 Alta',
            'media' => '🟡 Média',
            'baixa' => '🟢 Baixa',
        ];
        return $priorities[$this->priority] ?? $this->priority;
    }

    // Accessor: Label do status
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'aberto' => 'Aberto',
            'em_andamento' => 'Em Andamento',
            'respondido' => 'Respondido',
            'fechado' => 'Fechado',
        ];
        return $statuses[$this->status] ?? $this->status;
    }
}
