@if ($paginator->hasPages())
    <div class="container_pagination">
        <p class="small text-muted">
            {!! __('Showing') !!}
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            {!! __('of') !!}
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
        <div class="custom-pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="disabled">&lsaquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            @endif

            {{-- Pagination Elements --}}
            @php
                $startPage = max($paginator->currentPage() - 2, 1);
                $endPage = min($paginator->currentPage() + 2, $paginator->lastPage());
            @endphp

            @if ($startPage > 1)
                <a href="{{ $paginator->url(1) }}">1</a>
                @if ($startPage > 2)
                    <span class="disabled">...</span>
                @endif
            @endif

            @for ($i = $startPage; $i <= $endPage; $i++)
                @if ($i == $paginator->currentPage())
                    <span class="active">{{ $i }}</span>
                @else
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                @endif
            @endfor

            @if ($endPage < $paginator->lastPage())
                @if ($endPage < $paginator->lastPage() - 1)
                    <span class="disabled">...</span>
                @endif
                <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            @else
                <span class="disabled" aria-disabled="true">&rsaquo;</span>
            @endif
        </div>
    </div>
@endif
<style>
    .container_pagination {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom-pagination {
        display: flex;
        justify-content: flex-end;
        list-style: none;
        padding: 0;
    }

    .custom-pagination li {
        margin: 0 5px;
    }

    .custom-pagination a,
    .custom-pagination span {
        display: inline-block;
        padding: 5px 10px;
        border: 1px solid #cccccc67;
        text-decoration: none;
        color: #3bafda;
    }

    .custom-pagination a:hover {
        background-color: #f5f5f5;
    }

    .custom-pagination .active {
        background-color: #3bafda;
        color: #fff;
    }

    .custom-pagination .disabled {
        pointer-events: none;
        color: #cccccc67;
    }

    .custom-pagination .disabled:hover {
        background-color: transparent;
    }
</style>
