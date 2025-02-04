<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'saldo_permitido', 'aprovador_id'];

    // public function aprovador()
    // {
    //     return $this->belongsTo(Usuario::class, 'aprovador_id');
    // }

    public function solicitantes()
    {
        return $this->hasMany(Solicitante::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
    public function registros()
    {
        return Grupo::join('users', 'users.id', 'grupos.aprovador_id')
            ->select('grupos.*', 'users.name as aprovador')
        ;
    }
}