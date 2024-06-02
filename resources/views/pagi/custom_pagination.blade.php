<!-- <ul class="pagination pagination-sm justify-content-center m-0">
    @if($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link" aria-hidden="true">&lsaquo;</span>
        </li>
    @else
        <li class="page-item">
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link" aria-label="@lang('pagination.previous')">&lsaquo;</a>
        </li>
    @endif

    @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
        @if ($page == $paginator->currentPage())
            <li class="page-item active" aria-current="page">
                <span class="page-link">{{ $page }} of {{ $paginator->lastPage() }}</span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
            </li>
        @endif
    @endforeach

    @if($paginator->hasMorePages())
        <li class="page-item">
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link" aria-label="@lang('pagination.next')">&rsaquo;</a>
        </li>
    @else
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link" aria-hidden="true">&rsaquo;</span>
        </li>
    @endif
</ul> -->