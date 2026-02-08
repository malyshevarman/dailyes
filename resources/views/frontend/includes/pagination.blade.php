@if ($paginator->hasPages())
    <div class="pagination-panel">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->currentPage() == 1)
                <!-- <li>
                    <img src="/images/icons/pagination-inactive.svg"/>
                </li> -->
            @else
                <li class="pagination-panel_prev-arrow">
                    <a href="{{ $paginator->previousPageUrl() }}">
                        <img src="/images/icons/pagination-left.svg"/>
                    </a>
                </li>
            @endif

            {{--{{ dd($elements) }}--}}
            {{-- Pagination Elements --}}
            @foreach ($elements as $key => $element)
                {{-- "Three Dots" Separator --}}
                {{--@if (is_string($element))--}}
                {{--<li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>--}}
                {{--@endif--}}

                @if (is_array($element))
                    @if($paginator->lastPage() > 9)
                        @if($key == 0 && count($element) > 7)
                            @php
                                $element = array_slice($element, 0, 7, true);
                            @endphp
                        @elseif($key == 2 && count($element) > 5)
                            @php
                                $element = array_slice($element, 0, 5, true);
                            @endphp
                        @elseif($key == 4 && count($element) > 7)
                            @php
                                $element = array_slice($element, count($element) - 7, count($element), true);
                            @endphp
                        @endif
                    @endif


                    {{--@if($key == 2 && count($elements) == 3 && count($element) > 7)--}}
                    {{--@php--}}
                    {{--$element = array_slice($element, 0, 7, true);--}}
                    {{--@endphp--}}
                    {{--@elseif (count($elements) == 5 && count($element) > 5)--}}
                    {{--@php--}}
                    {{--$element = array_slice($element, 0, 5, true);--}}
                    {{--@endphp--}}
                    {{--@endif--}}
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active">{{$page}}</li>
                        @else
                            <li><a href="{{ $url }}">{{$page}}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{--{{ dd($paginator->lastPage()) }}--}}

            {{-- Next Page Link --}}
            @if ($paginator->currentPage() == $paginator->lastPage())
                <!-- <li>
                    <img src="/images/icons/pagination-inactive-right.svg"/>
                </li> -->
            @else
                <li  class="pagination-panel_next-arrow">
                    <a class="pagination__next" href="{{ $paginator->nextPageUrl() }}">
                        <img src="/images/icons/pagination-right.svg"/>
                    </a>
                </li>
            @endif

        </ul>
    </div>
@endif
