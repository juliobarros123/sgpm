<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'signature_id',
        'valor',
        'metodo_pagamento',
        'data_pagamento',
        'document_id'
    ];
}
