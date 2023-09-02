@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li style="cursor: not-allowed;" class="page-item disabled" aria-disabled="true">
                    <span style="background: rgb(93, 134, 187);" class="page-link"><i style="font-size:2em;" class="fas fa-chevron-circle-left text-warning"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i style="font-size:2em;" class="fas fa-chevron-circle-left text-warning"></i></a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i style="font-size:2em;" class="fas fa-chevron-circle-right text-warning"></i></a>
                </li>
            @else
                <li style="cursor: not-allowed;" class="page-item disabled" aria-disabled="true">
                    <span style="background: rgb(93, 134, 187);" class="page-link"><i style="font-size:2em;" class="fas fa-chevron-circle-right text-warning"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
