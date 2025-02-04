<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedPDF extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'caminho_pdf',
        'data_geracao',
    ];

    // Corrigido: A tabela deve ser uma string, não um array
    protected $table = 'generated_pdfs';
}
