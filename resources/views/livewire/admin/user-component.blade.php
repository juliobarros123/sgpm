<div class="content">
    <div class="container-fluid">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="modal {{ $visibleModal ? 'show' : 'false' }} bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Adicionar Usuário</h4>
                        </div>
                        <div class="content">
                            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome:</label>
                                            <input type="text" class="form-control border-input"
                                                placeholder="Digite o Nome Completo" wire:model="name">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail:</label>
                                            <input type="email" class="form-control border-input"
                                                placeholder="Digite o e-mail" wire:model="email">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Perfil</label>
                                            <select class="form-control border-input" wire:model="perfil"
                                                wire:change="activarGrupo">
                                                @if ($user)
                                                    <option value="{{ $user->perfil }}">{{ $user->perfil }}
                                                    </option>
                                                @else
                                                    <option value="" selected>Selecciona...</option>
                                                @endif

                                                @foreach (['aprovador', 'solicitante'] as $perifl)
                                                    <option value="{{ $perifl }}">{{ $perifl }}</option>
                                                @endforeach
                                            </select>
                                            @error('perfil')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @if ($activeSelectGrupo)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Grupo (opcional)</label>
                                                <select class="form-control border-input" wire:model="grupo_id"
                                                    wire:change="activarGrupo">

                                                    @if ($solicitante)
                                                        <option value="{{ $solicitante->grupo_id }}">
                                                            {{ $solicitante->nome }}</option>
                                                    @else
                                                        <option value="" selected>Selecciona...</option>
                                                    @endif


                                                    @foreach ($grupos as $grupo)
                                                        <option value="{{ $grupo->id }}">{{ $grupo->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('grupo_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Senha:</label>
                                            <input type="password" class="form-control border-input"
                                                placeholder="Digite a senha" wire:model="password">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Confirmar Senha:</label>
                                            <input type="password" class="form-control border-input"
                                                placeholder="Digite a senha" wire:model="confirmed">
                                            @error('confirmed')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-default"
                                        type="submit">{{ $updateMode ? 'Atualizar' : 'Cadastrar' }}</button>
                                    {{-- @if ($updateMode) --}}
                                    <button class="btn btn-default" wire:click="resetInputFieldsUser"
                                        type="button">Cancelar</button>
                                    {{-- @endif --}}
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Usuários</h4>
                        <div class="category"
                            style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="flex-grow: 1;">Registro de Usuários</span>
                            <div style="flex-shrink: 0;">
                                <button class="btn btn-default" wire:click="abrirModal">
                                    <span class="ti-plus"></span> Adicionar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <div class="search-container">
                            <i class="search-icon ti-search"></i>
                            <input 
                                type="text" 
                                class="search-input" 
                                placeholder="Pesquisar usuários..." 
                                wire:model.live.debounce.250ms="search"
                            >
                        </div>
                        <table class="table table-striped table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>

                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Perfil</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }} </td>
                                        <td>{{ $user->perfil }}</td>
                                        <td>
                                            <div class="btn-group justify-content-end">
                                                <a class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    wire:click="edit({{ $user->id }})">
                                                    <span class="ti-pencil"></span> Editar
                                                </a>
                                                <a class="btn btn-sm btn-danger"
                                                    wire:click="destroy({{ $user->id }})"
                                                    onclick="confirm('Tem certeza que deseja excluir?') || event.stopImmediatePropagation()">
                                                    <span class="ti-trash"></span> Eliminar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination">
                            @if ($users->previousPageUrl())
                                <a href="{{ $users->previousPageUrl() }}" class="pagination-link">
                                    &laquo; Anterior
                                </a>
                            @else
                                <span class="pagination-link disabled">&laquo; Anterior</span>
                            @endif
                        
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                <a 
                                    href="{{ $url }}" 
                                    class="pagination-link {{ $users->currentPage() == $page ? 'active' : '' }}"
                                >
                                    {{ $page }}
                                </a>
                            @endforeach
                        
                            @if ($users->nextPageUrl())
                                <a href="{{ $users->nextPageUrl() }}" class="pagination-link">
                                    Próximo &raquo;
                                </a>
                            @else
                                <span class="pagination-link disabled">Próximo &raquo;</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
