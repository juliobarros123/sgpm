<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CategoriaServico;
use App\Models\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperadorController extends Controller
{
    public function __construct()
    {

        $this->logger = new Logger();

    }
    public function loggerData($mensagem)
    {

        $this->logger->Log('info', $mensagem);
    }

    public function index()
    {
        $data['operadores'] = DB::table('operadores')
            ->join('titulo_habilitantes', 'titulo_habilitantes.it_id_operador', 'operadores.id')
            ->select('*', 'operadores.id')->get();
            $data['servico_licenciados'] = DB::table('servico_licenciados')
            ->join('titulo_habilitantes', 'titulo_habilitantes.id', 'servico_licenciados.it_id_titulo_habilitante')
            ->join('operadores', 'operadores.id', 'titulo_habilitantes.it_id_operador')
            ->join('categoria_servicos', 'categoria_servicos.id', 'servico_licenciados.it_id_categoria_servico')
            ->select('*', 'operadores.id')->get();

        return view('site.operador.index', $data);

    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $data['operadores'] = DB::table('operadores')
            ->join('titulo_habilitantes', 'titulo_habilitantes.it_id_operador', '=', 'operadores.id')
            ->where(function ($query) use ($search) {
                $query->where('operadores.vc_nome', 'like', "%$search%")
                    ->orWhere('titulo_habilitantes.vc_numero_titulo', 'like', "%$search%")
                    ->orWhere('titulo_habilitantes.dt_emissao', 'like', "%" . date('Y-m-d', strtotime(str_replace('/', '-', $search))) . "%");
            })
            ->select('*', 'operadores.id')
            ->get();

       $data['servico_licenciados'] = DB::table('servico_licenciados')
            ->join('titulo_habilitantes', 'titulo_habilitantes.id', 'servico_licenciados.it_id_titulo_habilitante')
            ->join('operadores', 'operadores.id', 'titulo_habilitantes.it_id_operador')
            ->join('categoria_servicos', 'categoria_servicos.id', 'servico_licenciados.it_id_categoria_servico')
            ->select('*', 'operadores.id')->get();
            return response()->json($data);

    }

    public function show($id)
    {
        
        $data['operador'] = DB::table('operadores')
            ->join('titulo_habilitantes', 'titulo_habilitantes.it_id_operador', '=', 'operadores.id')
            ->join('morada_sedes', 'morada_sedes.it_id_operadore', 'operadores.id')
            ->where('operadores.id', $id)
            ->select('*', 'operadores.id')
            ->first();
            if (!$data['operador']) {
                return redirect()->back();
            }


        $data['servico_licenciados'] = DB::table('servico_licenciados')
            ->join('titulo_habilitantes', 'titulo_habilitantes.id', 'servico_licenciados.it_id_titulo_habilitante')
            ->join('categoria_titulo_habilitantes', 'categoria_titulo_habilitantes.id', 'titulo_habilitantes.it_id_categoria_titulo_habilitante')
            ->join('operadores', 'operadores.id', 'titulo_habilitantes.it_id_operador')
            ->join('categoria_servicos', 'categoria_servicos.id', 'servico_licenciados.it_id_categoria_servico')
            ->where('operadores.id', $id)
            ->select('*', 'servico_licenciados.id')->get();

            $data['ponto_focals'] = DB::table('ponto_focals')
            ->join('operadores', 'operadores.id', 'ponto_focals.it_id_operadore')
            ->where('operadores.id', $id)
            ->select('*', 'ponto_focals.id')->get();

            //dd($data['ponto_focals']);

        return view('site.operador.show.index', $data);
    }

}
