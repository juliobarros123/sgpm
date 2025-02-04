<div class="pagination">
    @if ($data->previousPageUrl())
        <a href="{{ $data->previousPageUrl() }}" class="pagination-link">
            &laquo; Anterior
        </a>
    @else
        <span class="pagination-link disabled">&laquo; Anterior</span>
    @endif

    @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
        <a href="{{ $url }}" class="pagination-link {{ $data->currentPage() == $page ? 'active' : '' }}">
            {{ $page }}
        </a>
    @endforeach

    @if ($data->nextPageUrl())
        <a href="{{ $data->nextPageUrl() }}" class="pagination-link">
            Próximo &raquo;
        </a>
    @else
        <span class="pagination-link disabled">Próximo &raquo;</span>
    @endif
</div>
