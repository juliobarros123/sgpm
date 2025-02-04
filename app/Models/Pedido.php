<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'status', 'data_criacao', 'data_atualizacao', 'solicitante_id', 'grupo_id','motivo_alteracao'];

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'pedido_has_materials')
                    ->withPivot('quantidade', 'subtotal');
    }
}
