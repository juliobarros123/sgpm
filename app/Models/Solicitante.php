<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'grupo_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
