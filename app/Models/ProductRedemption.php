<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'points_spent',
        'product_name',
        'product_description',
        'product_image',
        'status',
        'admin_notes',
        'processed_at',
    ];

    protected $casts = [
        'points_spent' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pendente',
            'processing' => 'Em Processamento',
            'completed' => 'Concluído',
            'cancelled' => 'Cancelado',
            default => 'Desconhecido'
        };
    }

    public function getStatusClassAttribute()
    {
        return match($this->status) {
            'pending' => 'pending',
            'processing' => 'inprogress',
            'completed' => 'done',
            'cancelled' => 'cancelled',
            default => 'pending'
        };
    }
}