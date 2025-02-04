<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use App\Models\Inscrito;

class RelatorioController extends Controller
{
    //
    public function territorial()
    {
        return view('admin.relatorio.territorial.index');
    }

    public function territorial_pdf(Request $request)
    {
        // dd($request);
        // Receber os dados do formulário
        $dataInicio = $request->input('dataInicio');
        $dataTermino = $request->input('dataTermino');
        $id_provincia = $request->input('id_provincia');
        $id_municipio = $request->input('id_municipio');
        $provincias = getProvincesBD();
        $municipios = getMunicipalitiesBD();
        // Construir a consulta base
        $id_bolsa = $request->input('id_bolsa');
        $bolsas = bolsas()->get();

        $query = Inscrito::query();
        if ($id_bolsa) {
            // dd($id_bolsa);
            $query = $query->where('id_bolsa', $id_bolsa);
            $bolsas = $bolsas->where('id', $id_bolsa);
            // dd(  $query->get());
        }
        // Aplicar os filtros
        if ($dataInicio) {
            $query->whereDate('created_at', '>=', $dataInicio);
        }

        if ($dataTermino) {
            $query->whereDate('created_at', '<=', $dataTermino);
        }

        if ($id_provincia && $id_provincia !== 'Todas') {
            $query->where('id_provincia', $id_provincia);
            $provincias = getProvincesBD()->where('id', $id_provincia);
            $municipios = $municipios->where('it_id_provincia', $id_provincia);

        }
        if ($id_municipio && $id_municipio !== 'Todas') {
            $query->where('id_municipio', $id_municipio);
            $municipios = getMunicipalitiesBD()->where('id', $id_municipio);
        }
        // dd( $municipios->first());

        $response['provincias'] = $provincias;
        $response['municipios'] = $municipios;
        $response['dataTermino'] = $dataTermino;
        $response['dataInicio'] = $dataInicio;

        $response['bolsas'] = $bolsas;

        $resultados = $query->get();
        // dd(    $response);
        $response['resultados'] = $resultados;
        // dd($response['resultados']->where('provincia_residencia','Bengo')->count());
        $html = view('admin.relatorio.territorial.pdf', $response)->render();

        // Inicializar mPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 7,
            // 'margin_left' => 5,
            // 'margin_right' => 0,
            // 'margin_bottom' => 0,
            // 'format' => [54, 84]
        ]);

        // Definir fonte
        // $mpdf->SetImportUse();

        // Adicionar página e definir conteúdo
        $mpdf->WriteHTML($html);

        // Saída do PDF
        return $mpdf->Output();
    }

    public function avaliacao()
    {
        return view('admin.relatorio.avaliacao.index');
    }

    public function avaliacao_pdf(Request $request)
    {
        // dd($request);
        // Receber os dados do formulário
        $id_bolsa = $request->input('id_bolsa');
        $resultado = $request->input('resultado');
        $bolsas = bolsas()->get();
        $resultado_estado = $request->input('resultado');
        $estatistica = scopeGroupedByStatusAndGender()->get();
       
        // Aplicar os filtros
        if ($id_bolsa) {
            // dd($id_bolsa);
            $estatistica = $estatistica->where('id_bolsa', $id_bolsa);
            $bolsas = $bolsas->where('id', $id_bolsa);
            // dd(  $query->get());
        }
        if ($resultado != 'Todos') {
            if ($resultado) {
                $resultado_texto = 'Aptos';
                $resultado_estados = ['Aptos'];
                // $resultado_texto = 'Todos';
                $estatistica = $estatistica->where('estado', 1);


            } else {
                $resultado_texto = 'N/Aptos';
                $resultado_estados = ['N/Aptos'];
                $estatistica = $estatistica->where('estado', 0);
            }

        } else {
            $resultado_estados = ['N/Aptos', 'Aptos'];
            $resultado_texto = 'Todos';
        }
        // dd($resultado_estados);
        // dd( $municipios->first());

        $response['id_bolsa'] = $id_bolsa;
        $response['resultado'] = $resultado;
        $response['resultado_texto'] = $resultado_texto;
        $response['bolsas'] = $bolsas;
        $response['resultado_estados'] = $resultado_estados;
        $response['estatistica'] = $estatistica;

        $response['estatisticaf'] = $estatistica;

        $html = view('admin.relatorio.avaliacao.pdf', $response)->render();

        // Inicializar mPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 7,
            // 'margin_left' => 5,
            // 'margin_right' => 0,
            // 'margin_bottom' => 0,
            // 'format' => [54, 84]
        ]);

        // Definir fonte
        // $mpdf->SetImportUse();

        // Adicionar página e definir conteúdo
        $mpdf->WriteHTML($html);

        // Saída do PDF
        return $mpdf->Output();
    }

}
