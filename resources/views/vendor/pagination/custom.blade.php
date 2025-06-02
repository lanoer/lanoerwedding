@if ($paginator->hasPages())
<ul class="pwe-pagination-wrap align-center">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <li class="disabled"><span><i class="ti-arrow-left"></i></span></li>
    @else
    <li><a href="{{ $paginator->previousPageUrl() }}"><i class="ti-arrow-left"></i></a></li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <li class="disabled"><span>{{ $element }}</span></li>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li><a class="active">{{ $page }}</a></li>
    @else
    <li><a href="{{ $url }}">{{ $page }}</a></li>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <li><a href="{{ $paginator->nextPageUrl() }}"><i class="ti-arrow-right"></i></a></li>
    @else
    <li class="disabled"><span><i class="ti-arrow-right"></i></span></li>
    @endif
</ul>
@endif