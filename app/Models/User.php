<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{ 
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'descarte_points', // 👈 ADICIONAR AQUI
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'descarte_points' => 'decimal:2', // 👈 ADICIONAR CAST
        ];
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function respondedTickets()
    {
        return $this->hasMany(SupportTicket::class, 'responded_by');
    }

    /**
     * Relacionamento: pagamentos do usuário
     */
    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }
}