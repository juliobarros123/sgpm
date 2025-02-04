<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Bolsa;
use Illuminate\Http\Request;
use App\Models\Inscrito;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class InscricaoController extends Controller
{
    //

    public function inscricao_interna()
    {
        return view('site.inscricao.index');
    }
    public function inscrever_me($id_bolsa)
    {
        // dd($id);

        // dd($request);
        if (jaEhInscrito(Auth::User()->id, $id_bolsa)) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => "Usuário já é um inscrito!"]);
        }
        $response['bolsa'] = Bolsa::find($id_bolsa);
        // dd(   $response['bolsa']);
        if ($response['bolsa']) {
            // if ($response['bolsa']->tipo == 'Interna') {
                return view('site.inscricao.index', $response);
            // } else {

            // }
        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => "Bolsa Inválida"]);

        }

    }
    public function submter(Request $request, $id)
    {
        // dd($id);
        // try {    
        //code...
        // try {
        //code...
// dd($request);
        $messages = [
            'required' => 'O campo :attribute é obrigatório.',
            'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
            'date' => 'O campo :attribute deve ser uma data válida.',
            'in' => 'O campo :attribute deve ser um valor válido.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'mimes' => 'O arquivo enviado para o campo :attribute deve ser do tipo :values.',
            'file' => 'O campo :attribute deve ser um arquivo.',
        ];
        // dd("o");
        $request->validate([
            'nome_completo' => 'required|string|max:255',
            'dt_nascimento' => 'required|date',
            'genero' => 'required|string|in:Masculino,Feminino', // Assumindo apenas duas opções
            'n_bi' => 'required|string|max:14',
            'dt_emissao' => 'required|date',
            'dt_vencimento' => 'required|date',
            'estado_civil' => 'required|string|max:20',
            'provincia_nascimento' => 'required|string|max:255',
            'naturalidade' => 'required|string|max:255',
            'pais_residencia' => 'required|string|max:255',
            'id_provincia' => 'required|integer',
            'id_municipio' => 'required|integer',
            'endereco' => 'required|string|max:255',
            'telefone_principal' => 'required|string|max:20',
            'telefone_alternativo' => 'nullable|string|max:20',
            'nome_banco' => 'nullable|string|max:50',
            'n_canta_bancaria' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:50',
            'pai' => 'required|string|max:100',
            'mae' => 'required|string|max:100',
            'pais_conclusao' => 'required|string|max:255',
            'provincia_conclusao' => 'required|string|max:255',
            'nivel_conclusao' => 'required|string|max:255',
            'instituto_conclusao' => 'required|string|max:255',
            'curso' => 'required|string|max:255',

            'media_conclusao' => 'required|numeric|min:0|max:20',
            'pais_candidatura' => 'required|string|max:255',
            'provincia_candidatura' => 'required|string|max:255',
            'instituto_candidatura' => 'required|string|max:255',
            'nivel_formacao_candidatura' => 'required|string|max:255',
            'curso_candidatura' => 'required|string|max:255',
            'ano_ingresso_candidatura' => 'required',


            'ano_ingresso' => 'required',
            'ano_conclusao' => 'required',
            'ano_frequencia_atual' => 'required|string|min:0|max:6',
            'regime_candidatura_bolsa' => 'required|string|max:255',
            'carenciado' => 'required|string|in:Sim,Não',
            'bi_file' => 'required|file|mimes:pdf|max:1024',
            'atestado_pobreza' => 'required|file|mimes:pdf|max:1024',
            'certificado' => 'required|file|mimes:pdf|max:1024',
            'declaracao_frequencia' => 'required|file|mimes:pdf|max:1024',
        ], $messages);
        // dd( $request);
        $inscrito = new Inscrito();
        $inscrito->nome_completo = $request->nome_completo;
        $inscrito->dt_nascimento = $request->dt_nascimento;
        $inscrito->genero = $request->genero;
        $inscrito->n_bi = Auth::User()->bi;
        $inscrito->dt_emissao = $request->dt_emissao;
        $inscrito->dt_vencimento = $request->dt_vencimento;
        $inscrito->estado_civil = $request->estado_civil;
        $inscrito->provincia_nascimento = $request->provincia_nascimento;
        $inscrito->naturalidade = $request->naturalidade;
        $inscrito->pais_residencia = $request->pais_residencia;
        $inscrito->id_provincia = $request->id_provincia;
        $inscrito->id_municipio = $request->id_municipio;
        $inscrito->endereco = $request->endereco;
        $inscrito->telefone_principal = $request->telefone_principal;
        $inscrito->telefone_alternativo = $request->telefone_alternativo;
        $inscrito->nome_banco = $request->nome_banco;
        $inscrito->n_conta_bancaria = $request->n_conta_bancaria;
        $inscrito->iban = $request->iban;
        $inscrito->pai = $request->pai;
        $inscrito->mae = $request->mae;
        $inscrito->pais_conclusao = $request->pais_conclusao;
        $inscrito->provincia_conclusao = $request->provincia_conclusao;
        $inscrito->nivel_conclusao = $request->nivel_conclusao;
        $inscrito->instituto_conclusao = $request->instituto_conclusao;
        $inscrito->curso = $request->curso;
        $inscrito->ano_ingresso = $request->ano_ingresso;
        $inscrito->ano_conclusao = $request->ano_conclusao;
        $inscrito->media_conclusao = $request->media_conclusao;
        $inscrito->pais_candidatura = $request->pais_candidatura;
        $inscrito->provincia_candidatura = $request->provincia_candidatura;
        $inscrito->instituto_candidatura = $request->instituto_candidatura;
        $inscrito->ano_frequencia_atual = $request->ano_frequencia_atual;


        $inscrito->nivel_formacao_candidatura = $request->nivel_formacao_candidatura;
        $inscrito->curso_candidatura = $request->curso_candidatura;
        $inscrito->ano_ingresso_candidatura = $request->ano_ingresso_candidatura;
        $inscrito->regime_candidatura_bolsa = $request->regime_candidatura_bolsa;
        $inscrito->carenciado = $request->carenciado;
        $inscrito->id_bolsa = $id;
        $inscrito->id_user = Auth::User()->id;

        // Upload de arquivos
        $inscrito->atestado_pobreza = upload_file($request, 'atestado_pobreza', 'inscricao/atestado_pobreza');
        $inscrito->certificado = upload_file($request, 'certificado', 'inscricao/certificado');
        $inscrito->declaracao_frequencia = upload_file($request, 'declaracao_frequencia', 'inscricao/declaracao_frequencia');
        $inscrito->bi_file = upload_file($request, 'bi_file', 'inscricao/bi_file');
        if (Bolsa::find($id)->tipo == 'Externa') {
            $inscrito->carta_recomendacao_um_be = upload_file($request, 'carta_recomendacao_um_be', 'inscricao/carta_recomendacao_um_be');
            $inscrito->carta_recomendacao_dois_be = upload_file($request, 'carta_recomendacao_dois_be', 'inscricao/carta_recomendacao_dois_be');
            $inscrito->carta_recomendacao_tres_be = upload_file($request, 'carta_recomendacao_tres_be', 'inscricao/carta_recomendacao_tres_be');
            $inscrito->comprovativo_aceitacao_be = upload_file($request, 'comprovativo_aceitacao_be', 'inscricao/comprovativo_aceitacao_be');
            $inscrito->plano_estudo_be = upload_file($request, 'plano_estudo_be', 'inscricao/plano_estudo_be');
            $inscrito->passaporte_be = upload_file($request, 'passaporte_be', 'inscricao/passaporte_be');
            $inscrito->cv_be = upload_file($request, 'cv_be', 'inscricao/cv_be');

        }


        $inscrito->save();
        // dd($inscrito);
        $n = Bolsa::find($id)->n_bolsas;
        Bolsa::find($id)->update(['n_bolsas' => $n--]);
        return redirect()->route('site.bolsas')->with('feedback', ['type' => 'success', 'sms' => "Inscrição realizada com sucesso"]);

        // return 
        // } catch (\Throwable $th) {
        //     // dd($th);
        //     // throw $th;
        //     return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => "Erro de validação"]);
        // }
        return redirect()->route('inscritos.index');
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     dd($th);
        // }


    }
    public function ficha($id_inscricao)
    {
        $inscrito = bolsas_inscritos()->where('inscritos.id', $id_inscricao)
            ->where('id_user', Auth::User()->id)->get();
        if (!$inscrito->count()) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => "Pedido Inválido"]);

        }
        $response['inscrito'] = $inscrito->first();
        // dd($response['inscrito']);
        $html = view('admin.lista.ficha.pdf', $response)->render();

        // Inicializar mPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);
        // $mpdf->setHeader();

        // Definir fonte
        // $mpdf->SetImportUse();

        // Adicionar página e definir conteúdo
        $mpdf->WriteHTML($html);

        // Saída do PDF
        return $mpdf->Output("Ficha de inscrição $id_inscricao.pdf", "I");
        // dd($id);
    }
}
