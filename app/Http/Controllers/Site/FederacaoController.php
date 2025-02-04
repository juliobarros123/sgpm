<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FederacaoController extends Controller
{
    //
    public function index(){
        $response['federacoes']=federacoes()->get();
        return view('site.federacao.index',$response);
    }
    public function sobre(){
        $response['federacoes']=federacoes()->get();
        return view('site.sobre.index',$response);
    }
    public function ver_mais($id){
        $response['federacao']=federacoes()->where('id',$id)->first();
        return view('site.federacao.ver-mais.index', $response);


    }
    
}
