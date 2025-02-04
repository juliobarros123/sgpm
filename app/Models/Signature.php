<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'caminho_assinatura',
        'tipo_assinatura',
        'texto_associado',
        'posicao_x',
        'posicao_y',
        'largura',
        'altura',
        'tamanho_bytes',
    ];
}
