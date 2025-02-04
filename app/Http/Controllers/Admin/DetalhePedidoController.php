<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetalhePedidoController extends Controller
{
    //
    public function index()
    {

        
        return view('admin.detalhe-pedido.index');
    }
    public function detalhe_pedido($id_pedido)
    {
        $response['id_pedido'] = $id_pedido;
        return view('admin.pedido.index', $response);
    }
}
