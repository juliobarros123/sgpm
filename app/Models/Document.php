<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'titulo',
        'caminho_arquivo',
        'numero_paginas',
        'tamanho_bytes',
    ];
}
