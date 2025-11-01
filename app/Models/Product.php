<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'condition',
        'category',
        'image',
        'status',
        'stock',
        'badge',
    ];

    /**
     * Retorna o preço formatado
     */
    public function getFormattedPriceAttribute()
    {
        return 'R$ ' . number_format($this->price, 2, ',', '.');
    }

    /**
     * Retorna o label da condição
     */
    public function getConditionLabelAttribute()
    {
        $labels = [
            'novo' => 'Novo',
            'seminovo' => 'Seminovo',
            'usado' => 'Usado',
        ];

        return $labels[$this->condition] ?? 'Desconhecido';
    }

    /**
     * Verifica se o produto está ativo
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Verifica se tem estoque
     */
    public function hasStock()
    {
        return $this->stock > 0;
    }
}
