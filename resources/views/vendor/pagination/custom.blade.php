<style>
    .custom-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
}

.custom-pagination .paginate-btn {
    padding: 8px 12px;
    margin: 0 5px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.custom-pagination .paginate-btn:hover {
    background-color: #0056b3;
    color: #fff;
}

.custom-pagination .paginate-btn.active {
    background-color: #28a745;
    color: white;
    pointer-events: none;
}

.custom-pagination .paginate-btn.disabled {
    background-color: #6c757d;
    color: #fff;
    cursor: not-allowed;
    pointer-events: none;
    opacity: 0.65;
}

.custom-pagination .paginate-btn:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

</style>
@if ($paginator->hasPages())
    <div class="custom-pagination">
        {{-- First Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="paginate-btn disabled" aria-disabled="true">First</a>
        @else
            <a href="{{ $paginator->url(1) }}" class="paginate-btn">First</a>
        @endif

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="paginate-btn disabled" aria-disabled="true">Previous</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="paginate-btn">Previous</a>
        @endif

        {{-- Page Number Links --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="paginate-btn disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="paginate-btn active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}" class="paginate-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="paginate-btn">Next</a>
        @else
            <a class="paginate-btn disabled" aria-disabled="true">Next</a>
        @endif

        {{-- Last Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="paginate-btn">Last</a>
        @else
            <a class="paginate-btn disabled" aria-disabled="true">Last</a>
        @endif
    </div>
@endif
