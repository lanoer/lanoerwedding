@if ($paginator->hasPages())
<ul class="pagination">
    @if ($paginator->onFirstPage())
    <li class="page-item disabled"><span class="page-link">Previous</span></li>
    @else
    <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
    @endif

    @foreach ($paginator->links() as $link)
    <li class="page-item {{ $link->active ? 'active' : '' }}">
        <a class="page-link" href="{{ $link->url }}">{{ $link->label }}</a>
    </li>
    @endforeach

    @if ($paginator->hasMorePages())
    <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a></li>
    @else
    <li class="page-item disabled"><span class="page-link">Next</span></li>
    @endif
</ul>
@endif