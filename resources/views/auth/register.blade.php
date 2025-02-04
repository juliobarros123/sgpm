@extends('layouts.app')
@section('titulo', 'Criar Conta')

@section('conteudo')

<section class="ftco-section ftco-about img" id="servicos">
    <div class="container">

        <!-- Título atualizado -->
        <h3 class="mb-3 text-center text-white" style="font-size: 28px; line-height: 1.5;">
            INAGBE <br> Criar uma Conta
        </h3>

        <!-- Exibição de erros -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-center">
            <div class="card shadow-lg border-light" style="max-width: 400px;">
                <div class="card-body">
                    <!-- Formulário de registro -->
                    <form class="form" action="{{ route('site.registar') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Ícone de Assinatura -->
                        <div class="text-center mb-4">
                            <a class="navbar-brand p-0 d-flex flex-column align-items-center justify-content-center " href="/">
                                <div class="p-2">
                                    <i class="bx bxs-pen me-2" style="font-size: 80px"></i>
                                </div>
                                <p class="text-muted" style="font-size: 22px;">Assinatura Digital
                                    <br> <span style="font-size: 12px">«Abrir uma Conta»</span> </p>
                            </a>
                        </div>

                        <!-- Nome completo -->
                        <div class="form-group mb-3">
                            <label for="inputname" class="sr-only">Nome completo <span>*</span></label>
                            <input type="text" id="inputname" class="form-control form-control-lg"
                                placeholder="Nome completo" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                        </div>

                        <!-- Telefone -->
                        <div class="form-group mb-3">
                            <label for="inputPhoneNumber" class="sr-only">Telefone</label>
                            <input type="tel" id="inputPhoneNumber" name="telefone" required
                                class="form-control form-control-lg" placeholder="Telefone" value="{{ old('telefone') }}">
                        </div>

                        <!-- Gênero -->
                        <div class="form-group mb-3">
                            <label for="inputGenero" class="sr-only">Gênero</label>
                            <select id="inputGenero" name="genero" class="form-control form-control-lg">
                                <option value="" disabled {{ old('genero') ? '' : 'selected' }}>Selecione o Gênero </option>
                                <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="feminino" {{ old('genero') == 'feminino' ? 'selected' : '' }}>Feminino</option>
                                <option value="outro" {{ old('genero') == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                        </div>

                        <!-- E-mail -->
                        <div class="form-group mb-3">
                            <label for="inputEmail" class="sr-only">Endereço de e-mail <span>*</span></label>
                            <input type="email" id="inputEmail" class="form-control form-control-lg" required
                                placeholder="Endereço de e-mail" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
                        </div>

                        <!-- Senha -->
                        <div class="form-group mb-3">
                            <label for="inputPassword" class="sr-only">Senha <span>*</span></label>
                            <input type="password" id="inputPassword" name="password"
                                class="form-control form-control-lg" placeholder="Senha" required>
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="form-group mb-3">
                            <label for="inputConfirmPassword" class="sr-only">Confirmar Senha <span>*</span></label>
                            <input type="password" id="inputConfirmPassword" name="password_confirmation"
                                class="form-control form-control-lg" placeholder="Confirmar Senha" required>
                        </div>

                        <!-- Foto de Perfil -->
                        <div class="form-group mb-3">
                            <label for="inputProfilePhoto" class="sr-only">Foto de Perfil</label>
                            <input type="file" id="inputProfilePhoto" name="profile_photo_path" class="form-control form-control-lg" accept="image/*">
                        </div>

                        <!-- Permaneça logado (opcional) -->
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                            <label class="form-check-label" for="rememberMe">Permaneça logado</label>
                        </div>

                        <!-- Botão de envio -->
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Criar Conta</button>

                        <!-- Direitos autorais -->
                        <p class="mt-5 mb-3 text-muted text-center">© {{ date('Y') }}</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
