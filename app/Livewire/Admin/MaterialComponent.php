<?php

namespace App\Livewire\Admin;

use App\Models\Material;
use Livewire\Component;

class MaterialComponent extends Component
{
    public  $message, $updateMode = false, $nome, $preco, $material_id, $visibleModal = false, $post_id;

    public $search = '';
    protected $rules = [
        'nome' => 'required|string|min:3|max:255',
        'preco' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'nome.required' => 'O nome do material é obrigatório.',
        'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
        'preco.required' => 'O preço do material é obrigatório.',
        'preco.numeric' => 'O preço deve ser um número válido.',
        'preco.min' => 'O preço não pode ser negativo.',
    ];

    public function abrirModal()
    {

        $this->visibleModal = true;
    }
    public function render()
    {
        $query = Material::orderBy('id', 'desc');
        if (!empty($this->search)) {
            // dd($this->search);
            $query->where(function ($q) {
                $q->where('materials.nome', 'like', '%' . $this->search . '%')
                    ->orWhere('materials.preco', 'like', '%' . $this->search . '%');
            });
        }

        $materiais = $query->paginate(8);
        return view('livewire.admin.material-component',  [
            'materiais' => $materiais
        ])->layout('layouts.admin');
    }

    public function destroy($id)
    {
        $material = Material::find($id);

        if ($material) {
            $material->delete();
            session()->flash('message', 'Material excluído com sucesso!');
        }
    }

    public function store()
    {
        $this->visibleModal = true;
        $this->validate();
        Material::create([
            'nome' => $this->nome,
            'preco' => $this->preco
        ]);

        session()->flash('message', 'Material Criado com Sucesso.');
        $this->resetInputFieldsMaterial();

    }

    public function resetInputFieldsMaterial()
    {
        $this->nome = "";
        $this->preco = "";
        $this->material_id = null;
        $this->visibleModal = false;
    }

    public function edit($id)
    {
        $material = Material::find($id);

        if ($material) {
            $this->nome = $material->nome;
            $this->preco = $material->preco;
            $this->post_id = $id;
            $this->updateMode = true;
            $this->visibleModal = true;
        }
    }

    public function update()
    {
        $this->visibleModal = true;
        $this->validate();

        Material::find($this->post_id)->update([
            'nome' => $this->nome,
            'preco' => $this->preco
        ]);

        session()->flash('message', 'Material Atualizado com Sucesso.');
        $this->updateMode = false;
        $this->visibleModal = false;
        $this->resetInputFieldsMaterial();
    }
}
