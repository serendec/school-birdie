<div class="pager">
    {{-- Previous Page Link --}}
    @if ($previous)
        <a href="{{ route($route, $previous->id) }}" class="button button-secondary">
            <span class="material-symbols-outlined">
                navigate_before
            </span>
        </a>
    @endif
    
    <span class="text size-small">{{ $currentNumber }} / {{ $totalNumber }}</span>

    {{-- Next Page Link --}}
    @if ($next)
        <a href="{{ route($route, $next->id) }}" class="button button-secondary">
            <span class="material-symbols-outlined">
                navigate_next
            </span>
        </a>
    @endif
</div>
