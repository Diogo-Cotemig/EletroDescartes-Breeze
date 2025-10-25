<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicket extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'support_tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'category',
        'priority',
        'description',
        'attachments',
        'receive_notifications',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attachments' => 'array',
        'receive_notifications' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Categorias disponíveis
     */
    public const CATEGORIES = [
        'coleta' => 'Problema na Coleta',
        'agendamento' => 'Agendamento de Serviço',
        'equipamento' => 'Dúvida sobre Equipamento',
        'certificado' => 'Certificado de Descarte',
        'pagamento' => 'Questões de Pagamento',
        'outro' => 'Outros',
    ];

    /**
     * Prioridades disponíveis
     */
    public const PRIORITIES = [
        'baixa' => '🟢 Baixa',
        'media' => '🟡 Média',
        'alta' => '🔴 Alta',
        'urgente' => '🚨 Urgente',
    ];

    /**
     * Status disponíveis
     */
    public const STATUSES = [
        'pendente' => 'Pendente',
        'em_andamento' => 'Em Andamento',
        'resolvido' => 'Resolvido',
        'fechado' => 'Fechado',
    ];

    /**
     * Scopes
     */
    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeEmAndamento($query)
    {
        return $query->where('status', 'em_andamento');
    }

    public function scopeResolvido($query)
    {
        return $query->where('status', 'resolvido');
    }

    public function scopeUrgente($query)
    {
        return $query->where('priority', 'urgente');
    }

    public function scopeAlta($query)
    {
        return $query->where('priority', 'alta');
    }

    public function scopePorCategoria($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Accessors
     */
    public function getCategoryNameAttribute()
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function getPriorityNameAttribute()
    {
        return self::PRIORITIES[$this->priority] ?? $this->priority;
    }

    public function getStatusNameAttribute()
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * Verifica se o ticket está pendente
     */
    public function isPendente()
    {
        return $this->status === 'pendente';
    }

    /**
     * Verifica se o ticket está em andamento
     */
    public function isEmAndamento()
    {
        return $this->status === 'em_andamento';
    }

    /**
     * Verifica se o ticket está resolvido
     */
    public function isResolvido()
    {
        return $this->status === 'resolvido';
    }

    /**
     * Verifica se o ticket é urgente
     */
    public function isUrgente()
    {
        return $this->priority === 'urgente';
    }

    /**
     * Marca o ticket como em andamento
     */
    public function marcarEmAndamento()
    {
        return $this->update(['status' => 'em_andamento']);
    }

    /**
     * Marca o ticket como resolvido
     */
    public function marcarResolvido()
    {
        return $this->update(['status' => 'resolvido']);
    }

    /**
     * Marca o ticket como fechado
     */
    public function marcarFechado()
    {
        return $this->update(['status' => 'fechado']);
    }
}
