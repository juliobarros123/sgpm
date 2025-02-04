<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Bolsa;
use Illuminate\Http\Request;

class BolsaController extends Controller
{
    //
    public function bolsas()
    {
        // dd(today());
        $response['bolsas'] = Bolsa::where('ativa', 1)->where('n_bolsas', '!=', 0)
        ->whereDate('data_fim_inscricao','>=',now())
        ->get();
        // dd( $response['bolsas'] );
        return view('site.bolsa.index', $response);
    }
}
