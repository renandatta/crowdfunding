@php
    $functionName = $functionName ?? '';
@endphp
@if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
    @if ($data->lastPage() > 1)
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" @if($data->currentPage() != 1) onclick="{{ $functionName . '(`' . $data->previousPageUrl() . '`)' }}" @endif><i class="icon ion-ios-arrow-back"></i></a>
            </li>
            @if($data->currentPage() > 7)
                <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="{{ $functionName . '()' }}">1</a></li>
            @endif
            @if($data->currentPage() > 8)
                <li class="page-item"><a class="page-link"> ... </a></li>
            @endif
            @foreach(range(1, $data->lastPage()) as $i)
                @if($i >= $data->currentPage() - 4 && $i <= $data->currentPage() + 4)
                    <li class="page-item {{ ($data->currentPage() == $i) ? 'active' : '' }}"><a class="page-link" href="javascript:void(0)" onclick="{{ $functionName . '(`' . $data->url($i) . '`)' }}">{{ $i }}</a></li>
                @endif
            @endforeach
            @if($data->currentPage() < $data->lastPage() - 7)
                <li class="page-item"><a class="page-link"> ... </a></li>
            @endif
            @if($data->currentPage() < $data->lastPage() - 6)
                <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="{{ $functionName . '(`' . $data->url($data->lastPage()) . '`)' }}">{{ $data->lastPage() }}</a></li>
            @endif
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" @if($data->currentPage() != $data->lastPage()) onclick="{{ $functionName . '(`' . $data->nextPageUrl() . '`)' }}" @endif><i class="icon ion-ios-arrow-forward"></i></a>
            </li>
        </ul>
    @endif
@endif
