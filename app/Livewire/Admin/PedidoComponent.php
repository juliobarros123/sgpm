<?php

namespace App\Livewire\Admin;

use App\Models\Grupo;
use App\Models\Material;
use App\Models\Pedido;
use App\Models\PedidoHasMaterial;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PedidoComponent extends Component
{


    public  $message, $updateMode = false, $nome, $saldo_permitido, $grupo_id, $visibleModal = false, $post_id, $materias, $aprovador_id, $grupo;
    public $pedido_selecionado_id;
    public $id_material_adicionado, $materias_adicionados, $total;
    public $search = '';
    public function __construct()
    {
        $this->materias_adicionados = collect();
    }
    protected $rules = [
        'nome' => 'required|string|min:3|max:255',
        'saldo_permitido' => 'required|numeric|min:0',
        'aprovador_id' => 'required',

    ];

    protected $messages = [
        'nome.required' => 'O nome do grupo é obrigatório.',
        'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
        'saldo_permitido.required' => 'O saldo  do grupo é obrigatório.',
        'saldo_permitido.numeric' => 'O saldo  deve ser um número válido.',
        'saldo_permitido.min' => 'O saldo  não pode ser negativo.',
        'aprovador_id.required' => 'Escolha um aprovador.',

    ];

    public function render()
    {
        $query = fhna_pedidos();

        if (!empty($this->search)) {
            // dd($this->search);
            $query->where(function ($q) {
                $q->where('pedidos.total', 'like', '%' . $this->search . '%')
                    ->orWhere('pedidos.status', 'like', '%' . $this->search . '%')
                    ->orWhere('pedidos.created_at', 'like', '%' . $this->search . '%')
                    ->orWhere('grupos.nome', 'like', '%' . $this->search . '%')
                  
                    ->orWhere('users.name', 'like', '%' . $this->search . '%');
            });
        }

        $response['pedidos'] = $query->paginate(5);
        $this->materias = Material::get();

        return view('livewire.admin.pedido-component', $response)->layout('layouts.admin');
    }
    public function verDetalhes($pedido_id)
    {
        $this->pedido_selecionado_id = $pedido_id;
    }
    public function add_material()
    {
        if ($this->id_material_adicionado) {
            // Verificar se o material já foi adicionado
            $linha = $this->materias_adicionados->where('id', $this->id_material_adicionado)->count();

            if (!$linha) {
                // Encontrar o material no banco de dados
                $m = Material::find($this->id_material_adicionado);

                if ($m) {
                    // Criar um array com os dados do material
                    $novoMaterial = (object) [
                        'id' => $m->id,
                        'nome' => $m->nome,
                        'preco' => $m->preco,
                        'quantidade' => 1, // Inicializar a quantidade com 1
                        'subtotal' => $m->preco // O subtotal é preço * quantidade
                    ];

                    // Adicionar na coleção
                    $this->materias_adicionados->push($novoMaterial);
                    // dd($this->materias_adicionados);
                }
            }
        }

        // Resetar o select após adicionar
        $this->id_material_adicionado = null;
    }

    public function atualizarquantidade($qt, $material_id)
    {
        $this->materias_adicionados = $this->materias_adicionados->map(function ($item) use ($material_id, $qt) {
            if ($item->id == $material_id) {
                $item->quantidade = $qt;
                $item->subtotal = $item->preco * $qt;
            }
            return $item;
        });
        // dd(    $this->materias_adicionados);
    }
    public function remove_material($material_id)
    {
        // Remover o item pelo ID
        $this->materias_adicionados = $this->materias_adicionados->reject(function ($item) use ($material_id) {
            return $item->id == $material_id;
        });
    }

    public function destroy($id)
    {
        $grupo = Pedido::find($id);

        if ($grupo) {
            $grupo->delete();
            session()->flash('message', 'Pedido excluído com sucesso!');
        }
    }


    public function store()
    {
        DB::beginTransaction();

        try {
            if (!$this->materias_adicionados->count()) {
                session()->flash('error', 'Adiciona  um material.');
                return;
            }
            $pedido = Pedido::create([
                'total' => $this->materias_adicionados->sum('subtotal'),
                'status' => 'novo',
                'solicitante_id' => Auth::user()->id,
                'grupo_id' => fha_meu_grupo()->id
            ]);

            foreach ($this->materias_adicionados as $material_adicionado) {
                PedidoHasMaterial::create([
                    'pedido_id' => $pedido->id,
                    'material_id' => $material_adicionado->id,
                    'quantidade' => $material_adicionado->quantidade,
                    'subtotal' => $material_adicionado->preco * $material_adicionado->quantidade
                ]);
            }

            DB::commit();


            session()->flash('message', 'Pedido Criado com Sucesso.');
            $this->resetInputFieldsPedido();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao criar pedido: ' . $e->getMessage());
        }
    }

    public function resetInputFieldsPedido()
    {
        $this->materias_adicionados = collect();
        $this->saldo_permitido = "";
        $this->material_id = null;
        $this->visibleModal = false;
        $this->grupo = null;
        $this->updateMode = false;
    }
    public function abrirModal()
    {

        $this->visibleModal = true;
    }
    public function edit($id)
    {

        $this->pedido_selecionado_id = $id;
        $response = fha_detalhes_pedido($this->pedido_selecionado_id);
        // dd($response);
        $this->grupo_saldo = intval($response['pedido']->saldo_permitido);
        $this->pedido_selecionado = $response['pedido'];
        $response['materias'] = $response['materias']->toArray();
        foreach ($response['materias'] as $m) {
            $this->materias_adicionados->push((object) $m);
        }
        // dd( $this->materias_adicionados);

        // dd((object));
        // $this->materias_adicionados = $response['materias'];
        $this->updateMode = true;
        $this->visibleModal = true;
        // if ($this->grupo) {
        //     $this->nome = $this->grupo->nome;
        //     $this->saldo_permitido = $this->grupo->saldo_permitido;
        //     $this->grupo_id = $id;
        //  
        //     $this->visibleModal = true;
        // }
    }



    public function update()
    {
        $this->visibleModal = true;

        DB::beginTransaction();
        // dd("ola");
        try {


            if (!$this->materias_adicionados->count()) {
                session()->flash('error', 'Adiciona  um material.');
                return;
            }

            $pedido = Pedido::find($this->pedido_selecionado_id)->update([
                'total' => $this->materias_adicionados->sum('subtotal'),
                'status' => 'novo'
            ]);
            PedidoHasMaterial::where('pedido_id', $this->pedido_selecionado_id)->delete();
            // dd($this->materias_adicionados );
            foreach ($this->materias_adicionados as $material_adicionado) {

                // dd("ola",$material_adicionado-);
                $id_material = isset($material_adicionado->material_id) ? $material_adicionado->material_id : $material_adicionado->id;
                PedidoHasMaterial::create([
                    'pedido_id' => $this->pedido_selecionado_id,
                    'material_id' => $id_material,
                    'quantidade' => $material_adicionado->quantidade,
                    'subtotal' => $material_adicionado->preco * $material_adicionado->quantidade
                ]);

            }

            DB::commit();

            $this->dispatch('pedido_atualizado', $this->pedido_selecionado_id);
            session()->flash('message', 'Pedido Actualizado com Sucesso.');
            $this->resetInputFieldsPedido();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao criar pedido: ' . $e);
        }
    }
}
