<?php
namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;
use App\Models\CategoriaServico;
use App\Models\Logger;
use Illuminate\Http\Request;

class SobreController extends Controller
{


       public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }



    public function index()
    {
        return view('site.sobre.index');

    }

    public function quadro_legal()
    {
        return view('site.sobre.quadro_legal.index');

    }

    public function regulador_associado()
    {
        return view('site.sobre.regulador_associado.index');
    }

    public function licenciamentos()
    {
        return view('site.sobre.licenciamentos.index');
    }

    

}
