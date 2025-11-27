<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'endereco',
        'cidade',
        'estado',
    ];

    // Endereço completo para usar no JS
    public function getDestinoAttribute()
    {
        return "{$this->endereco}, {$this->cidade} - {$this->estado}";
    }
}