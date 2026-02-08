@extends('frontend.layouts.app')

@section('header')
    @include('frontend.includes.headers.event-tag')
@endsection

@push('after-scripts')
    <script>
        $('.events-container').infiniteScroll({
            path: '.pagination__next',
            append: '.event-item',
            button: '.view-more-button',
            // using button, disable loading on scroll
            scrollThreshold: false,
            // status: '.page-load-status',
        });
    </script>
@endpush

@section('content')
    <div class="container-fluid search-panel">
        <div class="container minus-15">
            <div class="row">
                
                    @if(!isset($tag))
                    @if($events->count() != 0 || count(Request::input()) != 0)
                    <div class="col-md-12">
                        <div class="search-panel__sort">
                            <ul>
                                @if (isset($newTab[0]))
                                    <li class="@if(request()->label_id == 1) active @endif">
                                        <a href="{{ route('frontend.city.event.tag.show', [$tag, 'label_id' => 1]) }}">Новые</a>
                                    </li>
                                @endif
                                @if (isset($endTab[0]))
                                    <li class="@if(request()->label_id == 2) active @endif">
                                        <a href="{{ route('frontend.event.index', ['label_id' => 2]) }}">Успейте воспользоваться</a>
                                    </li>
                                @endif
                                    <li class="@if(request()->favorite) active @endif">
                                        <a href="{{ route('frontend.event.index', ['favorite' => 1]) }}">Рекомендуем</a>
                                    </li>
                                    <li class="@if(Request::input('sort-raiting')) active @endif">
                                        <a href="{{ route('frontend.event.index', ['sort-raiting' => 'desc']) }}">Лучшие оценки</a>
                                    </li>
                                    <li class="@if(Request::input('sort-views')) active @endif">
                                        <a href="{{ route('frontend.event.index', ['sort-views' => 'desc']) }}">Популярные</a>
                                    </li>
                                    <li class="@if(Request::input() == NULL) active @endif">
                                        <a href="{{ route('frontend.event.index') }}">Все акции</a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    @endif

                    @if(isset($tagsForNavigation) && count($tagsForNavigation) > 0)
                    <div class="category-tags-block">
                        <ul class="category-tags" style="margin-top: 40px;">
                            @foreach ($tagsForNavigation as $key => $value)
                                <li>
                                    <span class="filter_tag {{$tag->id !== $value->id ? 'grey' : ''}}">
                                        <a href="{{ route('frontend.city.event.tag.show', $value) }}">
                                            {{$value->name}}
                                        </a>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="col-md-12">
                    @if($events->count() == 0 && !Request::get('text') && !Request::get('location'))
                        <div class="container minus-15">
                            <div class="info_block">
                                <div>Скоро здесь появится информация о проходящих акциях</div>
                            </div>
                        </div>
                    @endif
                        @if($events->count() == 0 && Request::get('text') || $events->count() == 0 && Request::get('location'))
                            <div class="container minus-15">
                                <div class="info_block">
                                    <div>К сожалению, по вашему запросу ничего не найдено</div>
                                </div>
                            </div>
                        @endif

                    <div class="events-block">
                        <div class="row events-container bootfix-row">
                            @foreach($events as $key => $event)
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 event-item bootfix-col">
                                    <div class="events-block__image">
                                        <a href="{{ route('frontend.event.show', $event) }}"><img
                                                    src="{{ $event->image_url }}" alt="{{$event->name}}"/><div class="animation-block"></div></a>
                                        @if($event->favorite)
                                            <div class="events-block__cool">
                                                <img src="/images/icons/success.svg"/> Выбор редакции
                                            </div>
                                        @endif
                                        <div class="events-block__badges">
                                            @foreach($event->labels as $label)
                                                <div class="events-block__badges-group">
                                                    <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                                    {{ $label->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                        <bookmark :event="{{ json_encode($event->only('slug')) }}"
                                                  :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false) }}"></bookmark>
                                    </div>
                                    <div class="events-block__title">
                                        <a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a>
                                    </div>
                                    <a href="{{ route('frontend.city.event.tag.show', [empty($tag) ? (empty($event->tags[0]) ? null : $event->tags[0] ) : $tag]) }}"
                                       class="events-block__group-a">
                                        <span class="events-block__group">{{empty($tag) ? (empty($event->tags[0]) ? null : $event->tags[0]->name) : $tag->name }}</span>
                                    </a>
                                    <div class="events-block__text-desc">
                                        <a href="{{ route('frontend.company.show', $event->company) }}">{{ $event->company->name }}</a>
                                    </div>
                                    <div class="events-block__text-desc">
                                        @if($event->status == 'active')
                                            Дата окончания: {{is_null($event->end) ? "бессрочная" : $event->end->locale('ru')->isoFormat('D MMMM YYYY') }}
                                        @elseif($event->status == 'before')
                                            Дата начала: {{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                                        @elseif($event->status == 'after')
                                            Завершено
                                        @endif
                                    </div>
                                    <div class="events-block__text-icons v-align">
                                        <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                                        <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                                        <img src="/images/icons/eye.svg"/> {{ $event->views }}
                                    </div>
                                </div>
                                @if(($key + 1) == 8)
                                    @include('frontend.includes.adv.horizontal_banner', ['item' => $eventListOnePlace, 'placeNumber' => 1])
                                @elseif(($key + 1) == 16)
                                    @include('frontend.includes.adv.horizontal_banner', ['item' => $eventListSecondPlace, 'placeNumber' => 2])
                                @elseif(($key + 1) == 24)
                                    @include('frontend.includes.adv.horizontal_banner', ['item' => $eventListTreePlace, 'placeNumber' => 3])
                                @endif
                            @endforeach
                        </div>

                        @if(!request()->newstocks == 1 && !Request::input('sort-views'))
                        <div class="row" >
                            <div class="col-md-12 bootfix-col">
                                <div class="row d-flex justify-content-center">
                                    <div style="display:none;" class="col-lg-6 col-sm-8">
                                        {{ $events->appends(['text' => Request::input('text'), 'date' => Request::input('date'), 'categories' => Request::input('categories'), 'location' => Request::input('location')])->links('frontend.includes.pagination', ['paginator' => $events]) }}
                                    </div>
                                    <div class="col-lg-3 col-sm-4 show-more">
                                        @if ($events->lastPage() != $events->currentPage())
                                            <a href="">
                                                <div class="view-more-button">Показать еще</div>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-md-12 direct">--}}
                            {{--<img src="/images/ad.png"/>--}}
                            {{--</div>--}}
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container seoblock">
        {!!str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->eventSeo->page_text)!!}
    </div>
    <div class="modal fade map-modal" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <event-modal-map-index
                :new-tab="{{json_encode($newTab)}}"
                :end-tab="{{json_encode($endTab)}}"
                :city="{{json_encode($city)}}"
                :current-tag="{{json_encode($tag)}}"></event-modal-map-index>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script>
        first_slider = $('#owl-company-list-1');
        second_slider = $('#owl-company-list-2');
        third_slider = $('#owl-company-list-3');
        first_slide_mobile = $('#owl-company-list-1-mobile');
        second_slide_mobile = $('#owl-company-list-2-mobile');
        third_slide_mobile = $('#owl-company-list-3-mobile');
        responsiveBanner = function () {
            if ($(window).width() <= '600'){
                first_slider.hide();
                second_slider.hide();
                third_slider.hide();
                first_slide_mobile.show();
                second_slide_mobile.show();
                third_slide_mobile.show();
            } else {
                first_slide_mobile.hide();
                second_slide_mobile.hide();
                third_slide_mobile.hide();
                first_slider.show();
                second_slider.show();
                third_slider.show();
            }
        }
        $(window).on('load resize',responsiveBanner);
    </script>
@endpush
