<?php
namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;
use App\Models\CategoriaTituloHabilitante;
use App\Models\CategoriaServico;
use App\Models\Logger;
use App\Models\Operador;
use App\Models\ServicoLicenciado;
use Illuminate\Http\Request;

class HomeController extends Controller
{


       public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }



    public function home(){
        // seeders();
        //$data['categoria_servicos']=CategoriaServico::all();
        //$this->loggerData("Listou Categoria Serviço");
        // dd("ola");
        // $data['categoria_titulo_habilitantes'] = CategoriaTituloHabilitante::paginate(4);
        // $data['operadores'] = Operador::get();
        // $data['qtd_categoria_servico'] = CategoriaServico::count();
        // $data['qtd_servico_licenciado'] = ServicoLicenciado::count();
        // $data['paginate'] = "1";
        return redirect('/admin/dashboard');
        // return view('site.principal.index');

    }

}
