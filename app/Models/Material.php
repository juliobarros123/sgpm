<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'preco'];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_has_materials')
            ->withPivot('quantidade', 'subtotal');
    }
}
