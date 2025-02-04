<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'signature_id',
        'posicao_x',
        'posicao_y',
        'largura',
        'altura',
        'data_assinatura',
    ];
}
