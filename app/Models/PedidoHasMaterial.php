<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoHasMaterial extends Model
{
    use HasFactory;


    protected $table = 'pedido_has_materials';

    protected $fillable = ['pedido_id', 'material_id', 'quantidade', 'subtotal'];
}
