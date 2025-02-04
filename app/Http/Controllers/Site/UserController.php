<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'bi' => ['nullable', 'string', 'max:14', 'unique:users'],

            'telefone' => 'nullable|string|max:255',

            'genero' => ['nullable', 'string', Rule::in(['masculino', 'feminino'])],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_photo' => 'nullable|image',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'bi.max' => 'O número de identificação / passaporte não pode ter mais de 14 caracteres.',
            'bi.unique' => 'Este B.I já está sendo utilizado.',

            'telefone.max' => 'O telefone não pode ter mais de 255 caracteres.',
            'genero.in' => 'O gênero selecionado é inválido.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'email.unique' => 'Este e-mail já está sendo utilizado.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'profile_photo.image' => 'O arquivo deve ser uma imagem.',
        ]);

        // Salvar o usuário no banco de dados
        $user = User::create([
            'name' => $request->name,
            'bi' => $request->bi,
            'telefone' => $request->telefone,
            'tipoUtilizador' => 'Candidato',
            'genero' => $request->genero,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Adicionar lógica para salvar a foto de perfil se necessário
        ]);

        // Redirecionar após o registro bem-sucedido

        return redirect()->route('login')->with('feedback', ['type' => 'success', 'sms' => 'Usuário registrado com sucesso!']);


    }
    public function perfil_actualizar(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'bi' => ['nullable', 'string', 'max:14', 'unique:users'],
            'telefone' => 'nullable|string|max:255',

            'genero' => ['nullable', 'string', Rule::in(['masculino', 'feminino'])],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_photo' => 'nullable|image',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'bi.max' => 'O número de identificação / passaporte não pode ter mais de 14 caracteres.',

            'telefone.max' => 'O telefone não pode ter mais de 255 caracteres.',
            'genero.in' => 'O gênero selecionado é inválido.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'email.unique' => 'Este e-mail já está sendo utilizado.',
            'bi.unique' => 'Este B.I já está sendo utilizado.',

            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'profile_photo.image' => 'O arquivo deve ser uma imagem.',
        ]);

        // Salvar o usuário no banco de dados
        $user = User::create([
            'name' => $request->name,
            'bi' => $request->bi,
            'telefone' => $request->telefone,
            'genero' => $request->genero,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Adicionar lógica para salvar a foto de perfil se necessário
        ]);

        // Redirecionar após o registro bem-sucedido

        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Usuário actualizado com sucesso!']);

    }
}
