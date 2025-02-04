<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card shadow-sm mb-4">


        <div class="header">
            <h4 class="title">Pedido #{{ $pedido_selecionado->id }}</h4>
            <div class="category" style="display: flex; justify-content: space-between; align-items: center;">
                <span style="flex-grow: 1;">Criado em {{ $pedido_selecionado->created_at->format('d/m/Y') }} às
                    {{ $pedido_selecionado->created_at->format('H:i') }}</span>
                @if (Auth::user()->perfil == 'aprovador')

                    <div style="flex-shrink: 0;">

                        @if ($pedido_selecionado->status != 'aprovado')
                            <button class="btn btn-success me-2" wire:click="mudar_estado('Aprovado')">
                                <i class="ti ti-check"></i> Aprovar
                            </button>
                        @endif
                        @if ($pedido_selecionado->status != 'em_revisao')
                            <button class="btn btn-warning me-2" wire:click="mudar_estado('em_revisao')">
                                <i class="ti ti-check"></i> Revisar
                            </button>
                        @endif
                        @if ($pedido_selecionado->status != 'alteracoes_solicitadas')
                            <button class="btn btn-warning me-2" wire:click="mudar_estado('alteracoes_solicitadas')">
                                <i class="ti ti-pencil"></i> Solicitar Alterações
                            </button>
                        @endif
                        @if ($pedido_selecionado->status != 'rejeitado')
                            <button class="btn btn-danger" wire:click="mudar_estado('rejeitado')">
                                <i class="ti ti-close"></i> Rejeitar
                            </button>
                        @endif
                        @if ($pedido_selecionado->status == 'alteracoes_solicitadas' && $pedido_selecionado->motivo_alteracao)
                            <button class="btn btn-secondary" wire:click="editar_motivo">
                                <i class="ti ti-pencil"></i> Alterar Motivo de Solicitação de alteração
                            </button>
                        @endif
                    </div>
                @endif


            </div>
        </div>
        <div class="content">
            <dl class="row">
                <dt class="col-sm-3 pl-5"> Solicitante</dt>
                <dd class="col-sm-9">{{ $pedido_selecionado->solicitante_nome }}({{ $pedido_selecionado->grupo_nome }})
                </dd>

                <dt class="col-sm-3 pl-5">Status</dt>
                <dd class="col-sm-9">

                    <span
                        class="badge 
                                                @if ($pedido_selecionado->status == 'novo') badge-primary
                                                @elseif ($pedido_selecionado->status == 'em_revisao')
                                                    badge-warning
                                                @elseif ($pedido_selecionado->status == 'alteracoes_solicitadas')
                                                    badge-info
                                                @elseif ($pedido_selecionado->status == 'aprovado')
                                                    badge-success
                                                @elseif ($pedido_selecionado->status == 'rejeitado')
                                                    badge-danger @endif">
                        {{ ucfirst($pedido_selecionado->status) }}
                    </span>

                </dd>
                @if ($pedido_selecionado->status == 'alteracoes_solicitadas' && $pedido_selecionado->motivo_alteracao)
                    <dt class="col-sm-3 pl-5 ">Desc. Alterações</dt>
                    <dd class="col-sm-9 text-warning">

                        {{ $pedido_selecionado->motivo_alteracao }}

                    </dd>
                @endif

                <dt class="col-sm-3  pl-5">Grupo</dt>
                <dd class="col-sm-9">{{ $pedido_selecionado->grupo_nome }}</dd>

                <dt class="col-sm-3  pl-5">Saldo Disponível</dt>
                <dd class="col-sm-9"> {{ $pedido_selecionado->saldo_permitido }}akz</dd>
            </dl>
        </div>
    </div>


    <div class="modal {{ $visibleModalMotivo ? 'show' : 'false' }}" tabindex="-1" role="dialog"
        aria-labelledby="modalMotivoLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="title">Motivo da Solicitação</h5>
                    </div>
                    <div class="card-body p-4">
                        <form wire:submit.prevent="cadastrar_actualizar_motivo">
                            <div class="form-group">
                                <label for="motivo">Descrição:</label>
                                <textarea id="motivo" class="form-control border-input" placeholder="Digite a descrição" wire:model="motivo"
                                    rows="3">{{ $motivo }}
                                </textarea>

                                @error('motivo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-center mt-3">
                                <button class="btn btn-primary" type="submit">Solicitar</button>
                                <button class="btn btn-secondary" wire:click="resetInputFieldsDetalhes"
                                    type="button">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Materiais Solicitados -->
    <div class="card shadow-sm mb-4 p-4">
        <div class="card-header">
            <h5 class="mb-0">Materiais Solicitados</h5>
        </div>
        <div class="content">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Material</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materias as $material)
                        <tr>
                            <td>{{ $material->material_nome }} </td>
                            <td>{{ $material->quantidade }}</td>
                            <td>{{ $material->material_preco }} akz</td>
                            <td>{{ $material->subtotal }} akz</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="total text-right">
                <strong>Total: </strong> {{ $materias->sum('subtotal') }} akz
            </div>
        </div>
    </div>



    </main>
</div>
