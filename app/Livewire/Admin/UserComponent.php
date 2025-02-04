<?php

namespace App\Livewire\Admin;

use App\Models\Grupo;
use App\Models\Solicitante;
use App\Models\User;
use Hash;
use Livewire\Component;

class UserComponent extends Component
{
    public  $message, $updateMode = false;
    public $name, $email, $perfil, $password, $confirmed, $user_id, $visibleModal = false;
    public $grupos, $grupo_id, $activeSelectGrupo = false, $solicitante, $user;
    public $search = '';
    /**
     * Regras de validação para criação.
     */
    protected function rules(): array
    {
        // Regras básicas para ambos os métodos store e update
        $rules = [
            'name' => 'required|string|max:45', // Máximo 45 caracteres
            'email' => 'required|email|max:255',
            'perfil' => 'required|in:aprovador,solicitante',
        ];

        if (!$this->updateMode) {
            $rules['email'] = 'required|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:8';
            $rules['confirmed'] = 'required|string|min:8|same:password';
        } else {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->user_id;
            if ($this->password) {
                $rules['password'] = 'sometimes|string|min:8';
                $rules['confirmed'] = 'sometimes|string|min:8|same:password';
            }
        }

        if ($this->perfil === 'solicitante') {
            $rules['grupo_id'] = 'required|exists:grupos,id';
        }

        return $rules;
    }



    protected $messages = [
        'name.required' => 'O nome é obrigatório.',
        'email.required' => 'O e-mail é obrigatório.',
        'email.email' => 'O e-mail informado não é válido.',
        'email.unique' => 'Este e-mail já está em uso.',
        'perfil.required' => 'O perfil é obrigatório.',
        'perfil.in' => 'O perfil selecionado é inválido.',
        'password.required' => 'A senha é obrigatória.',
        'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
        'confirmed.required' => 'A confirmação de senha é obrigatória.',
        'confirmed.same' => 'A confirmação da senha não confere.',
        'grupo_id.required' => 'Selecione um grupo para o solicitante.',
        'grupo_id.exists' => 'O grupo selecionado não existe.',
    ];

    public function render()
    {

        $query = User::orderBy('id', 'desc');
        if (!empty($this->search)) {
            // dd($this->search);
            $query->where(function ($q) {
                $q->where('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%')
                    ->orWhere('users.perfil', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%');
            });
        }

        $response['users'] = $query->paginate(8);
        $this->grupos = fha_grupos_sem_solicitantes();
        return view('livewire.admin.user-component', $response)->layout('layouts.admin');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            session()->flash('message', 'Usuário excluído com sucesso!');
        }
    }

    public function store()
    {

        $this->validate([
            'name' => 'required|string|max:45',
            'email' => 'required|email|max:255|unique:users,email',
            'perfil' => 'required|in:aprovador,solicitante',
            'password' => 'required|string|min:8',
            'confirmed' => 'required|string|min:8|same:password',

        ]);



        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'perfil' => $this->perfil,
            'password' => Hash::make($this->password),
        ]);


        if ($user && $this->perfil === 'solicitante') {
            Solicitante::create([
                'usuario_id' => $user->id,
                'grupo_id' => $this->grupo_id,
            ]);
        }

        session()->flash('message', 'Usuário criado com sucesso.');
        $this->resetInputFieldsUser();
    }

    public function resetInputFieldsUser()
    {
        $this->name = "";
        $this->email = "";
        $this->perfil = "";
        $this->password = "";
        $this->confirmed = "";
        $this->user_id = null;
        $this->grupo_id = null;
        $this->visibleModal = false;
        $this->updateMode = false;
        $this->solicitante = null;
        $this->user = null;
        $this->activeSelectGrupo = false;
    }

    public function abrirModal()
    {
        $this->resetInputFieldsUser();
        $this->visibleModal = true;
    }

    public function edit($id)
    {
        $this->user = User::find($id);
        // Supondo que a função `fhna_solicitantes()` retorne uma coleção ou query builder para os solicitantes
        $this->solicitante = fhna_solicitantes()->firstWhere('users.id', $id);

        if ($this->user) {
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->perfil = $this->user->perfil;
            $this->user_id = $id;
            $this->visibleModal = true;
            $this->updateMode = true;

            if ($this->perfil == 'solicitante') {
                $this->activeSelectGrupo = true;
                // Se houver solicitante, preenche o grupo
                if ($this->solicitante) {
                    $this->grupo_id = $this->solicitante->grupo_id;
                }
            } else {
                $this->activeSelectGrupo = false;
            }
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:45',
            'email' => 'required|email|max:255|',
            'perfil' => 'required|in:aprovador,solicitante',
            'password' => 'required|string|min:8',
            'confirmed' => 'required|string|min:8|same:password',

        ]);


        User::find($this->user_id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'perfil' => $this->perfil,
        ]);

        if ($this->perfil === 'solicitante') {
            if (isset($this->solicitante->id)) {
                $this->solicitante->update([
                    'usuario_id' => $this->user_id,
                    'grupo_id' => $this->grupo_id,
                ]);
            } else {
                Solicitante::create([
                    'usuario_id' => $this->user_id,
                    'grupo_id' => $this->grupo_id,
                ]);
            }
        }

        // Se foi informada uma nova senha, atualiza-a
        if ($this->password) {
            User::find($this->user_id)->update([
                'password' => Hash::make($this->password),
            ]);
        }

        session()->flash('message', 'Usuário atualizado com sucesso.');
        $this->resetInputFieldsUser();
    }

    /**
     * Método chamado ao alterar o perfil.
     * Ativa ou desativa a seleção do grupo conforme o perfil.
     */
    public function activarGrupo()
    {
        $this->activeSelectGrupo = ($this->perfil === 'solicitante');
    }
}
