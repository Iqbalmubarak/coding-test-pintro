<ul class="pagination  pagination-primary  justify-content-center">
    @if ($paginator->onFirstPage())
    <li class="page-item disabled">
        <a href="#" class="page-link" aria-label="Previous">
            Previous
        </a>
    </li>
    @else
    <li class="page-item">
        <a href="{{ $paginator->previousPageUrl() }}" class="page-link" aria-label="Previous">
            Previous
        </a>
    </li>
    @endif
    @foreach ($elements as $element)
    @if (is_string($element))
    <li class="page-item disabled"><a href="#" class="page-link">{{ $element }}</a></li>
    @endif

    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="page-item active"><a href="#" class="page-link">{{ $page }}</a></li>
    @else
    <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
    @endif
    @endforeach
    @endif
    @endforeach

    @if ($paginator->hasMorePages())
    <li class="page-item">
        <a href="{{ $paginator->nextPageUrl() }}" class="page-link" aria-label="Next">
            Next
        </a>
    </li>
    @else
    <li class="page-item disabled">
        <a href="#" class="page-link" aria-label="Next">
            Next
        </a>
    </li>
    @endif
</ul>
