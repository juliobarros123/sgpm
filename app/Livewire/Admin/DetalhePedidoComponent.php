<?php

namespace App\Livewire\Admin;

use App\Models\Grupo;
use App\Models\Pedido;
use Livewire\Component;

class DetalhePedidoComponent extends Component
{
    public $pedido_selecionado_id, $pedido_selecionado, $materias, $grupo_saldo;
    public $motivo, $visibleModalMotivo;
    protected $listeners = ['pedido_atualizado' => 'carregar_detalhes'];
    public function render()
    {

        $response = fha_detalhes_pedido($this->pedido_selecionado_id);
        // dd($response);
        // return;
        $this->pedido_selecionado = $response['pedido'];
        $this->materias = $response['materias'];
        return view('livewire.admin.detalhe-pedido-component');
    }
    public function resetInputFieldsDetalhes()
    {

        $this->visibleModal = false;
        $this->visibleModalMotivo = false;
    }
    public function mount($pedido_id)
    {
        $this->pedido_selecionado_id = $pedido_id;
        $response = fha_detalhes_pedido($pedido_id);
        // dd($response);
        $this->grupo_saldo = intval($response['pedido']->saldo_permitido);
        $this->pedido_selecionado = $response['pedido'];
        $this->materias = $response['materias'];
        // dd($response);


    }

    public function carregar_detalhes($pedido_id = null)
    {
        $this->mount($pedido_id);
    }
    public function cadastrar_actualizar_motivo()
    {

        Pedido::find($this->pedido_selecionado_id)->update([
            'status' => 'alteracoes_solicitadas',
            'motivo_alteracao' => $this->motivo
        ]);

        session()->flash('message', 'Solicitação de alteração enviada!');
        $this->resetInputFieldsDetalhes();
    }
    public function editar_motivo()
    {

        $this->motivo = Pedido::find($this->pedido_selecionado_id)->motivo_alteracao;

        $this->visibleModalMotivo = true;
    }
    public function mudar_estado($estado)
    {
        $total_pedido = $this->materias->sum('subtotal');

        // dd($this->grupo_saldo, $total_pedido);
        if ($estado == 'Aprovado') {
            if ($this->grupo_saldo < $total_pedido) {
                session()->flash('message', 'Saldo insuficiente para aprovar o pedido.');
                return;
            }
        }
        if ($estado == 'alteracoes_solicitadas') {
            $this->visibleModalMotivo = true;
            $this->motivo = Pedido::find($this->pedido_selecionado_id)->motivo_alteracao;
            return;

        }
        Pedido::find($this->pedido_selecionado_id)->update([
            'status' => $estado
        ]);


        if ($estado == 'Aprovado') {
            // dd($this->grupo_saldo,$total_pedido);
            $novo_saldo = $this->grupo_saldo - $total_pedido;

            Grupo::find($this->pedido_selecionado->grupo_id)->update([
                'saldo_permitido' => $novo_saldo
            ]);
            $this->grupo_saldo = $novo_saldo;
            session()->flash('message', 'Pedido aprovado com sucesso!');
        } elseif ($estado == 'alteracoes_solicitadas') {
            session()->flash('message', 'Solicitação de alteração enviada!');
        } elseif ($estado == 'em_revisao') {
            session()->flash('message', 'Pedido em revisão!');
        } elseif ($estado == 'rejeitado') {
            session()->flash('message', 'Pedido rejeitado!');
        }

    }
}
