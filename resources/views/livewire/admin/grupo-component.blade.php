
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
                            <h4 class="title">{{ $updateMode ? 'Atualizar' : 'Adicionar' }} Grupo</h4>
                        </div>
                        <div class="content">
                            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome:</label>
                                            <input type="text" class="form-control border-input"
                                                placeholder="Digite o Nome" wire:model="nome">
                                            @error('nome')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Saldo:</label>
                                            <input type="number" class="form-control border-input"
                                                placeholder="Digite o Saldo Permitido" wire:model="saldo_permitido">
                                            @error('saldo_permitido')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Aprovador</label>
                                            <select class="form-control border-input" wire:model="aprovador_id">
                                                @if ($grupo)
                                                    <option selected value="{{ $grupo->aprovador_id }}">
                                                        {{ $grupo->aprovador }}
                                                    </option>
                                                @else
                                                    <option value="" selected>Selecciona...</option>
                                                @endif

                                                @foreach ($aprovadores as $apv)
                                                    <option value="{{ $apv->id }}">{{ $apv->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('aprovador_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-default"
                                        type="submit">{{ $updateMode ? 'Atualizar' : 'Cadastrar' }}</button>
                                    {{-- @if ($updateMode) --}}
                                    <button class="btn btn-default" wire:click="resetInputFieldsGrupo"
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
                        <h4 class="title">Grupos</h4>
                        <div class="category"
                            style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="flex-grow: 1;">Registro de Grupos</span>
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
                                placeholder="Pesquisar grupos..." 
                                wire:model.live.debounce.250ms="search"
                            >
                        </div>
                        <table class="table table-striped table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Saldo Permitido</th>
                                    <th>Aprovador</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupos as $grupo)
                                    <tr>
                                        <td>{{ $grupo->id }}</td>
                                        <td>{{ $grupo->nome }}</td>
                                        <td>{{ $grupo->saldo_permitido }} akz</td>
                                        <td>{{ $grupo->aprovador }}</td>
                                        <td>
                                            <div class="btn-group justify-content-end">
                                                <a class="btn btn-sm btn-success"
                                                    wire:click="edit({{ $grupo->id }})">
                                                    <span class="ti-pencil"></span> Editar
                                                </a>
                                                <a class="btn btn-sm btn-danger"
                                                    wire:click="destroy({{ $grupo->id }})"
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
                            @if ($grupos->previousPageUrl())
                                <a href="{{ $grupos->previousPageUrl() }}" class="pagination-link">
                                    &laquo; Anterior
                                </a>
                            @else
                                <span class="pagination-link disabled">&laquo; Anterior</span>
                            @endif
                        
                            @foreach ($grupos->getUrlRange(1, $grupos->lastPage()) as $page => $url)
                                <a 
                                    href="{{ $url }}" 
                                    class="pagination-link {{ $grupos->currentPage() == $page ? 'active' : '' }}"
                                >
                                    {{ $page }}
                                </a>
                            @endforeach
                        
                            @if ($grupos->nextPageUrl())
                                <a href="{{ $grupos->nextPageUrl() }}" class="pagination-link">
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
