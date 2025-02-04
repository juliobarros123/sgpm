<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AreaMotorista;
use App\Models\Logger;
use App\Models\MetodoPagamento;
use App\Models\RegisterMotorista;
use App\Models\RegisterPassageiro;
use App\Models\ServicoMotorista;
use App\Models\ServicoPassageiro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{


    public function __construct()
    {

        $this->logger = new Logger();

    }
    public function loggerData($mensagem)
    {

        $this->logger->Log('info', $mensagem);
    }
    public function store_passageiro(Request $request)
    {
        $tipo_servicos = $request->it_id_tipo_servico;
        
        try {
            $nome = "$request->vc_primeiro_nome $request->vc_meio_nome $request->vc_ultimo_nome";
            $user = User::create([
                'name' => $nome,
                'bi' => $request->vc_numero_bi_ou_passaporte,
                'telefone' => $request->vc_telefone,
                'tipoUtilizador' => 'Passageiro',
                'email' => $request->vc_email,
                'password' => Hash::make('12345678'),
            ]);

            $register_passageiro = RegisterPassageiro::create([
                'dt_nascimento' => $request->dt_nascimento,
                'vc_pais' => $request->vc_pais,
                'vc_provincia' => $request->vc_provincia,
                'vc_localidade' => $request->vc_localidade,
                'it_id_user' => $user->id,
            ]);

            foreach ($tipo_servicos as $value) {
                ServicoPassageiro::create([
                    'it_id_tipo_servico' => $value,
                    'it_id_register_passageiro' => $register_passageiro->id,
                ]);
            }
           
            //$this->loggerData("O usuário $nome cadastrou-se no sistema");
            return redirect()->back()->with('success', ['status' => '1', 'sms' => 'Cadastrado com sucesso']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', ['status' => '1', 'sms' => 'Erro ao cadastrar']);
        }

    }

    public function store_motorista(Request $request)
    {
        $tipo_servicos = $request->it_id_tipo_servico;
        
        try { 
            $nome = "$request->vc_primeiro_nome $request->vc_meio_nome $request->vc_ultimo_nome";
            $user = User::create([
                'name' => $nome,
                'bi' => $request->vc_numero_bi_ou_passaporte,
                'telefone' => $request->vc_telefone,
                'tipoUtilizador' => 'Motorista',
                'genero' =>  $request->vc_sexo,
                'email' => $request->vc_email,
                'password' => Hash::make('12345678'),
            ]);

            
            $register_motorista = RegisterMotorista::create([
                'dt_nascimento'=> $request->dt_nascimento,
                'vc_alternativo_telefone'=> $request->vc_alternativo_telefone,
                'vc_disponibilidade'=> $request->vc_disponibilidade,
                'vc_descricao'=> $request->vc_descricao,
                'vc_pais'=> $request->vc_pais,
                'vc_provincia'=> $request->vc_provincia,
                'vc_localidade'=> $request->vc_localidade,
                'vc_municipio'=> $request->vc_municipio,
                'vc_destrito'=> $request->vc_destrito,
                'vc_zona'=> $request->vc_zona,
                'vc_bairro'=> $request->vc_bairro,
                'it_id_user' => $user->id,
            ]);

            foreach ($tipo_servicos as $value) {
                ServicoMotorista::create([
                    'it_id_tipo_servico' => $value,
                    'it_id_register_motorista' => $register_motorista->id,
                ]);
            }
            AreaMotorista::create([
                'vc_municipio_estudo_trabalho'=> $request->vc_municipio_estudo_trabalho,
                'vc_distrito_estudo_trabalho'=> $request->vc_distrito_estudo_trabalho,
                'vc_zona_estudo_trabalho'=> $request->vc_zona_estudo_trabalho,
                'vc_bairro_estudo_trabalho'=> $request->vc_bairro_estudo_trabalho,
                'vc_area_dirigir_frequencia'=> $request->vc_area_dirigir_frequencia,
                'it_id_register_motorista'=> $register_motorista->id,
            ]);

            MetodoPagamento::create([
                'vc_forma_pagamento'=> $request->vc_forma_pagamento,
                'vc_metodo_pagamento'=> $request->vc_metodo_pagamento,
                'it_id_register_motorista'=> $register_motorista->id,
            ]);
            
            //$this->loggerData("O usuário $nome cadastrou-se no sistema");
            return redirect()->back()->with('success', ['status' => '1', 'sms' => 'Cadastrado com sucesso']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', ['status' => '1', 'sms' => 'Erro ao cadastrar']);
        }

    }

}
