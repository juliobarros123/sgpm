<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CategoriaTituloHabilitante;
use Illuminate\Http\Request;
use DB;

class GraficoController extends Controller
{
    //
    public function getInscritosBolsas()
    {
        $data = DB::table('inscritos')
            ->join('bolsas', 'bolsas.id', '=', 'inscritos.id_bolsa')
            ->select('bolsas.nome as label', DB::raw('count(*) as total'))
            ->groupBy('bolsas.nome')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json($data);
    }
    public function inscritos_por_provincia(){
        
    }
}
