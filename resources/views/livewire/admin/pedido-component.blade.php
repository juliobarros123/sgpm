<div class="content">
    <div class="container-fluid">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif


        <div class="modal {{ $visibleModal ? 'show' : 'false' }} bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-height: 80vh; overflow-y: auto;">
                <div class="modal-content">
                    <div class="card shadow-sm p-4">
                        <!-- Cabeçalho -->
                        <div class="card-header bg-white border-bottom">
                            <h1 class="h4 mb-1">

                                {{ $updateMode ? "Editar Pedido #$pedido_selecionado_id " : 'Criar Novo Pedido' }}
                            </h1>
                            <p class="text-muted small mb-0">
                                Preencha as informações abaixo para criar um novo pedido de materiais
                            </p>
                        </div>
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Formulário -->
                        <div class="card-body">
                            {{-- <form> --}}
                            <!-- Informações Básicas -->
                            <div class="row mb-2">
                                <div class="col-md-12 mb-3 mb-md-0">
                                    <label class="form-label">Grupo</label>
                                    @php
                                        $meu_grupo = fha_meu_grupo();
                                    @endphp
                                    @if ($meu_grupo)
                                        <select class="form-select">
                                            <option value="{{ $meu_grupo->id }}">{{ $meu_grupo->nome }}
                                            </option>

                                        </select>
                                    @else
                                        <br>
                                        <small>Sem Grupo</small>
                                    @endif

                                </div>

                            </div>


                            <!-- Lista de Materiais -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h2 class="h5 mb-0">Materiais</h2>
                                    <div rclass="row">
                                        <div class="col-md-9">
                                            <select class="form-select" wire:model="id_material_adicionado">
                                                <option value="">Selecione um material</option>
                                                @foreach ($materias as $material)
                                                    <option value="{{ $material->id }}">{{ $material->nome }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                                wire:click="add_material">
                                                <i class="ti ti-plus "></i>
                                                Adicionar Material
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                {{-- <br> --}}
                                <!-- Tabela de Materiais -->
                                <div class="table-responsive mt-5 ">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Material</th>
                                                <th>Quantidade</th>
                                                <th>Valor Unitário</th>
                                                <th>Subtotal</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($materias_adicionados as $item)
                                                <tr>
                                                    <td>{{ isset($item->nome) ? $item->nome : $item->material_nome }}
                                                    </td>
                                                    <td>
                                                        <input type="number" min="1" class="form-control"
                                                            value="{{ $item->quantidade }}"
                                                            wire:change="atualizarquantidade($event.target.value, {{ $item->id }})"
                                                            style="width: 100px;">
                                                    </td>
                                                    <td>{{ $item->preco }} akz</td>
                                                    <td>
                                                        {{ $item->subtotal }} akz</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger"
                                                            wire:click="remove_material({{ $item->id }})">
                                                            <i class="ti ti-close"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Alerta de Saldo -->
                                <div class="alert alert-warning mt-3">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="ti ti-alert-circle fa-lg"></i>
                                        </div>
                                        <div>

                                            <h6 class="alert-heading">Saldo disponível no grupo</h6>
                                            @if ($meu_grupo)
                                                <p class="mb-0">
                                                    Saldo atual: {{ $meu_grupo->saldo_permitido }} akz<br>
                                                    Valor do pedido: {{ $materias_adicionados->sum('subtotal') }}
                                                    akz<br>
                                                    Saldo restante:
                                                    {{ $total = $meu_grupo->saldo_permitido - $materias_adicionados->sum('subtotal') }}
                                                    akz
                                                </p>
                                            @else
                                                <p class="mb-0">
                                                    Sem Grupo
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Rodapé com Total e Botões -->
                            <div class="border-top pt-4 mt-4">
                                <div class="row align-items-center">
                                    <div class="col-md-7 mb-3 mb-md-0">
                                        <span class="h5">Total do Pedido: </span>
                                        <span
                                            class="h4 text-primary fw-bold">{{ $materias_adicionados->sum('subtotal') }}
                                            akz</span>
                                    </div>
                                    <div class="col-md-5 text-md-end">
                                        <button type="button" class="btn btn-light me-2"
                                            wire:click="resetInputFieldsPedido">Cancelar</button>
                                        <button type="submit" class="btn btn-primary"
                                            wire:click="{{ $updateMode ? 'update' : 'store' }}">
                                            {{ $updateMode ? 'Atualizar' : ' Criar Pedido' }}

                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Pedidos</h4>
                        <div class="category"
                            style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="flex-grow: 1;">Registro de Pedidos
                                @if (Auth::user()->perfil == 'solicitante')
                                    / Grupo: {{ $meu_grupo->nome }}
                                @endif
                            </span>

                            <div style="flex-shrink: 0;">
                                @if (Auth::user()->perfil == 'solicitante')
                                <button class="btn btn-default" wire:click="abrirModal">
                                    <span class="ti-plus"></span> Novo Pedido
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <div class="search-container">
                            <i class="search-icon ti-search"></i>
                            <input type="text" class="search-input" placeholder="Pesquisar pedidos..."
                                wire:model.live.debounce.250ms="search">
                        </div>
                        <table class="table table-striped table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Data do Pedido</th>
                                    <th>Solicitante</th>
                                    <th>Grupo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td>{{ $pedido->id }}</td>
                                        <td>{{ number_format($pedido->total, 2) }} akz</td>
                                        <td>
                                            <span
                                                class="badge 
                                                @if ($pedido->status == 'novo') badge-primary
                                                @elseif ($pedido->status == 'em_revisao')
                                                    badge-warning
                                                @elseif ($pedido->status == 'alteracoes_solicitadas')
                                                    badge-info
                                                @elseif ($pedido->status == 'aprovado')
                                                    badge-success
                                                @elseif ($pedido->status == 'rejeitado')
                                                    badge-danger @endif">
                                                {{ ucfirst($pedido->status) }}
                                            </span>
                                        </td>

                                        <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $pedido->solicitante_nome }}</td>
                                        <td>{{ $pedido->grupo_nome }}</td>

                                        <td>
                                            <div class="btn-group justify-content-end">
                                                <a href="#detalhes-pedido"
                                                    wire:click="verDetalhes({{ $pedido->id }})"
                                                    class="btn btn-sm btn-info">
                                                    <span class="ti-eye"></span> Ver Detalhes
                                                </a>
                                                @if (Auth::user()->perfil == 'solicitante')
                                                    <button class="btn btn-sm btn-success"
                                                        wire:click="edit({{ $pedido->id }})">
                                                        <span class="ti-pencil"></span> Editar
                                                    </button>
                                                @endif
                                                <!-- Botão para excluir pedido -->

                                                @if ($pedido->status != 'aprovado')
                                                    <button class="btn btn-sm btn-danger"
                                                        wire:click="destroy({{ $pedido->id }})"
                                                        onclick="confirm('Tem certeza que deseja excluir?') || event.stopImmediatePropagation()">
                                                        <span class="ti-trash"></span> Excluir
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="pagination">
                            @if ($pedidos->previousPageUrl())
                                <a href="{{ $pedidos->previousPageUrl() }}" class="pagination-link">
                                    &laquo; Anterior
                                </a>
                            @else
                                <span class="pagination-link disabled">&laquo; Anterior</span>
                            @endif

                            @foreach ($pedidos->getUrlRange(1, $pedidos->lastPage()) as $page => $url)
                                <a href="{{ $url }}"
                                    class="pagination-link {{ $pedidos->currentPage() == $page ? 'active' : '' }}">
                                    {{ $page }}
                                </a>
                            @endforeach

                            @if ($pedidos->nextPageUrl())
                                <a href="{{ $pedidos->nextPageUrl() }}" class="pagination-link">
                                    Próximo &raquo;
                                </a>
                            @else
                                <span class="pagination-link disabled">Próximo &raquo;</span>
                            @endif
                        </div>
                    </div>
                    <!-- Alerta de Saldo -->
                    @if (Auth::user()->perfil == 'solicitante')
                        <div class="alert alert-warning mt-3">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="ti ti-alert-circle fa-lg"></i>
                                </div>
                                <div>

                                    <h6 class="alert-heading">Saldo disponível no grupo</h6>
                                    @if ($meu_grupo)
                                        <p class="mb-0">
                                            Saldo atual: {{ $meu_grupo->saldo_permitido }} akz<br>

                                        </p>
                                    @else
                                        <p class="mb-0">
                                            Sem Grupo
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12" id="detalhes-pedido">
                @if ($pedido_selecionado_id)
                    <livewire:admin.detalhe-pedido-component :pedido_id="$pedido_selecionado_id" :key="$pedido_selecionado_id">
                @endif
            </div>

        </div>

    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('pedidoSelecionado', pedidoId => {
                let element = document.getElementById('detalhes-pedido-' + pedidoId);
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

</div>
