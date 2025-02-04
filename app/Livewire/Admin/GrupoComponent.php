<?php

namespace App\Livewire\Admin;

use App\Models\Grupo;
use App\Models\User;
use DB;
use Livewire\Component;
use Livewire\WithPagination;
class GrupoComponent extends Component
{
    use WithPagination;
    public $message, $updateMode = false, $nome, $g, $saldo_permitido, $grupo_id, $visibleModal = false, $aprovadores, $aprovador_id, $grupo;
    public $search = '';
    protected $rules = [
        'nome' => 'required|string|min:1|max:255',
        'saldo_permitido' => 'required|numeric|min:0',
        'aprovador_id' => 'required',

    ];

    protected $messages = [
        'nome.required' => 'O nome do grupo é obrigatório.',
        'nome.min' => 'O nome deve ter pelo menos 1 caracteres.',
        'saldo_permitido.required' => 'O saldo  do grupo é obrigatório.',
        'saldo_permitido.numeric' => 'O saldo  deve ser um número válido.',
        'saldo_permitido.min' => 'O saldo  não pode ser negativo.',
        'aprovador_id.required' => 'Escolha um aprovador.',

    ];

    public function render()
    {
        $query = Grupo::join('users', 'users.id', '=', 'grupos.aprovador_id')
            ->select('grupos.*', 'users.name as aprovador');

        if (!empty($this->search)) {
            // dd($this->search);
            $query->where(function ($q) {
                $q->where('grupos.nome', 'like', '%' . $this->search . '%')
                    ->orWhere('grupos.saldo_permitido', 'like', '%' . $this->search . '%')
                    ->orWhere('users.name', 'like', '%' . $this->search . '%');
            });
        }

        $grupos = $query->paginate(8);
        // dd(  $grupos);
        $this->aprovadores = User::where('perfil', 'aprovador')->get();

        return view('livewire.admin.grupo-component', [
            'grupos' => $grupos
        ])->layout('layouts.admin');
    }
    public function search($word)
    {
        dd($word);
        $this->search = $word;
    }

    public function destroy($id)
    {
        $grupo = Grupo::find($id);

        if ($grupo) {
            $grupo->delete();
            session()->flash('message', 'Grupo excluído com sucesso!');
        }
        $this->atualizarTabela();
    }

    public function store()
    {
        $this->visibleModal = true;
        $this->validate();
        Grupo::create([
            'nome' => $this->nome,
            'saldo_permitido' => $this->saldo_permitido,
            'aprovador_id' => $this->aprovador_id
        ]);

        session()->flash('message', 'Grupo Criado com Sucesso.');
        $this->resetInputFieldsGrupo();

    }

    public function resetInputFieldsGrupo()
    {
        $this->nome = "";
        $this->saldo_permitido = "";
        $this->aprovador_id = "";
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
        // dd("ola");
        $this->grupo = Grupo::join('users', 'users.id', 'grupos.aprovador_id')
            ->select('grupos.*', 'users.name as aprovador')->find($id);

        if ($this->grupo) {
            $this->nome = $this->grupo->nome;
            $this->saldo_permitido = $this->grupo->saldo_permitido;
            $this->grupo_id = $id;
            $this->aprovador_id = $this->grupo->aprovador_id;
            $this->updateMode = true;
            $this->visibleModal = true;
        }
    }
    public function searchTable($word)
    {
        dd($word);
    }


    public function update()
    {
        // $this->visibleModal = true;
        // dd($this->aprovador_id);
        $this->validate();

        Grupo::find($this->grupo_id)->update([
            'nome' => $this->nome,
            'saldo_permitido' => $this->saldo_permitido,
            'aprovador_id' => $this->aprovador_id
        ]);

        session()->flash('message', 'Grupo Atualizado com Sucesso.');
        $this->updateMode = false;
        $this->visibleModal = false;
        $this->dispatch('grupo-atualizado', ['message' => 'Grupo Atualizado com Sucesso!']);
        $this->resetInputFieldsGrupo();
    }
}
