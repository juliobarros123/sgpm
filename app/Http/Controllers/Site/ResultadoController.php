<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    //
    public function consultar()
    {
        return view('site.resultado.consultar.index');

    }
    public function visualizar(Request $request)
    {
        // dd($request);
        $bolsas = bolsas_inscritos()->where('inscritos.n_bi',$request->bi)->get();
        // dd($bolsas);
        if($bolsas->count()==0){
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => "Não existe nehuma inscrição com este Nº de Bilhete" ]);
        }else{
            $response['bolsas']= $bolsas;
            return view('site.resultado.visualizar.index',$response);

        }
     
    }
}
