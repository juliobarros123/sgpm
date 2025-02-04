<?php
namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;
use App\Models\CategoriaServico;
use App\Models\Logger;
use Illuminate\Http\Request;

class ContactoController extends Controller
{


       public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }



    public function index(){

        return view('site.contacto.index');

    }

}
