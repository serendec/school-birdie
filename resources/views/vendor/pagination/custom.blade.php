@if ($paginator->hasPages())
    <div class="pager">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}" class="button button-secondary">
                <span class="material-symbols-outlined">
                    navigate_before
                </span>
            </a>
        @endif
        
        <span class="text size-small">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="button button-secondary">
                <span class="material-symbols-outlined">
                    navigate_next
                </span>
            </a>
        @endif
    </div>
@endif
