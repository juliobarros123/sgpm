<?php

use App\Models\Pedido;
use App\Models\PedidoHasMaterial;

use App\Models\Solicitante;



function fhna_solicitantes()
{
    return Solicitante::join('users', 'users.id', 'solicitantes.usuario_id')
        ->join('grupos', 'grupos.id', 'solicitantes.grupo_id')
        ->select('solicitantes.*', 'grupos.nome', 'users.name');

}
function fha_meu_grupo()
{
    // dd(Auth::User()->id);
    if (!isset(Auth::User()->id)) {
        return null;
    }
    // dd("oa")
//  ;   // dd(Grupo::firstWhere('aprovador_id', Auth::User()->id));
    $r = fhna_solicitantes()->select('grupos.*')->firstWhere('usuario_id', Auth::User()->id)
    ;
    // dd($r);
    return $r;

}


function fha_grupos_sem_solicitantes()
{
    $gruposSemSolicitantes = DB::table('grupos')
        ->leftJoin('solicitantes', 'solicitantes.grupo_id', '=', 'grupos.id')
        ->whereNull('solicitantes.id')
        ->select('grupos.*')
        ->get();
    return $gruposSemSolicitantes;
}
function fhna_pedidos()
{
    $pedidos = Pedido::join('users', 'users.id', '=', 'pedidos.solicitante_id')
        ->join('grupos', 'grupos.id', '=', 'pedidos.grupo_id')
        ->select('pedidos.*', 'grupos.nome as grupo_nome', 'users.name as solicitante_nome', 'grupos.saldo_permitido');
    // ->get();
    if (Auth::user()->perfil == "aprovador") {
        $pedidos = $pedidos->where('grupos.aprovador_id', Auth::user()->id);
    }
    if (Auth::user()->perfil == "solicitante") {
        $pedidos = $pedidos->where('pedidos.solicitante_id', Auth::user()->id);
    }
    return $pedidos;
}


function fha_detalhes_pedido($pedido_id)
{
    $pedido = fhna_pedidos()->firstWhere('pedidos.id', $pedido_id);
    $response['pedido'] = $pedido;
    $response['materias'] = pedidos_materias()->where('pedidos.id', $pedido_id)->get();
    return $response;
}
function pedidos_materias()
{
    return PedidoHasMaterial::join('pedidos', 'pedidos.id', 'pedido_has_materials.pedido_id')
        ->join('materials', 'materials.id', 'pedido_has_materials.material_id')
        ->select('pedido_has_materials.*', 'materials.nome as material_nome', 'materials.preco', 'materials.preco as material_preco');

}