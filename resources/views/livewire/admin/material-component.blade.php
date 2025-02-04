<div class="content">
    <div class="container-fluid">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="modal {{ $visibleModal ? 'show' : 'false' }} bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">{{ $updateMode ? 'Atualizar' : 'Adicionar' }} Material</h4>
                        </div>
                        <div class="content">
                            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome:</label>
                                            <input type="text" class="form-control border-input" placeholder="Digite o Nome" wire:model="nome">
                                            @error('nome') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Preço</label>
                                            <input type="number" class="form-control border-input" placeholder="Digite o preço" wire:model="preco">
                                            @error('preco') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-default" type="submit">{{ $updateMode ? 'Atualizar' : 'Cadastrar' }}</button>
                                    {{-- @if ($updateMode) --}}
                                        <button class="btn btn-default" wire:click="resetInputFieldsMaterial" type="button">Cancelar</button>
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
                        <h4 class="title">Materiais</h4>
                        <div class="category" style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="flex-grow: 1;">Registro de materiais</span>
                            <div style="flex-shrink: 0;">
                                <button class="btn btn-default" wire:click="abrirModal" >
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
                                placeholder="Pesquisar materiais..." 
                                wire:model.live.debounce.250ms="search"
                            >
                        </div>
                        <table class="table table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Preço</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materiais as $material)
                                    <tr>
                                        <td>{{ $material->id }}</td>
                                        <td>{{ $material->nome }}</td>
                                        <td>{{ $material->preco }}</td>
                                        <td>
                                            <div class="btn-group justify-content-end">
                                                <a class="btn btn-sm btn-success" data-toggle="modal" data-target=".bd-example-modal-lg" wire:click="edit({{ $material->id }})">
                                                    <span class="ti-pencil"></span> Editar
                                                </a>
                                                <a class="btn btn-sm btn-danger" wire:click="destroy({{ $material->id }})" onclick="confirm('Tem certeza que deseja excluir?') || event.stopImmediatePropagation()">
                                                    <span class="ti-trash"></span> Eliminar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination">
                            @if ($materiais->previousPageUrl())
                                <a href="{{ $materiais->previousPageUrl() }}" class="pagination-link">
                                    &laquo; Anterior
                                </a>
                            @else
                                <span class="pagination-link disabled">&laquo; Anterior</span>
                            @endif
                        
                            @foreach ($materiais->getUrlRange(1, $materiais->lastPage()) as $page => $url)
                                <a 
                                    href="{{ $url }}" 
                                    class="pagination-link {{ $materiais->currentPage() == $page ? 'active' : '' }}"
                                >
                                    {{ $page }}
                                </a>
                            @endforeach
                        
                            @if ($materiais->nextPageUrl())
                                <a href="{{ $materiais->nextPageUrl() }}" class="pagination-link">
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
