@extends('frontend.layouts.app')

@section('header')
    @include('frontend.includes.headers.event-rating')
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
                <div class="col-md-12">
                    <div class="events-block">
                        <div class="raiting-event">
                            @foreach($events as $key => $event)
                            <div class="raiting-event-item">
                                <div class="raiting-event-item-place">
                                    @if ($key !== 0 && $key !== 1 && $key !== 2)
                                        <div>
                                            <span class="raiting-place_span_two">
                                                {{$key + 1}}
                                            </span>
                                            <span class="raiting-place_span_sub_two">
                                                место
                                            </span>
                                        </div>
                                    @else
                                        <div>
                                            <span class="raiting-place_span">
                                                {{$key + 1}}
                                            </span>
                                            <span class="raiting-place_span_sub">
                                                место
                                            </span>
                                        </div>
                                    @endif

                                </div>

                                <div class="raiting-event-item_item">
                                    <div>
                                        <a href="{{ route('frontend.event.show', $event) }}"><img
                                                    src="{{ $event->image_url }}" alt="{{$event->name}}"/></a>
                                    </div>
                                    <div>
                                        <div class="events-block__title">
                                            <a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a>
                                        </div>

                                        @if (Request::input('categories') !== null)
                                            @php
                                            foreach ($event->categories as $event_category)
                                                if ($event_category->id == Request::input('categories')[0]) {
                                                    $req_cat = $event_category;
                                                } else {
                                                    $req_cat = $event->categories[0];
                                                }
                                            @endphp
                                        <a href="{{ route('frontend.city.event.category.show', $req_cat) }}"
                                           class="events-block__group-a">
                                            <span class="events-block__group">{{ $req_cat->name }}</span>
                                        </a>
                                        @elseif (empty($category))
                                        <a href="{{ route('frontend.city.event.category.show', $event->categories[0]) }}"
                                           class="events-block__group-a">
                                            <span class="events-block__group">{{ $event->categories[0]->name}}</span>
                                        </a>
                                        @else
                                        <a href="{{ route('frontend.city.event.category.show', $category) }}"
                                           class="events-block__group-a">
                                            <span class="events-block__group">{{ $category->name }}</span>
                                        </a>
                                        @endif
                                        <div class="events-block__text-desc-selection">
                                            <a style="display:block;" href="{{ route('frontend.event.show', $event) }}">{{iconv_strlen($event->about) < 100 ? $event->about : cutter($event->about)}}</a>
                                        </div>
                                        <div class="events-block__text-icons v-align">
                                            <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                                            <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                                            <img src="/images/icons/eye.svg"/> {{ $event->views }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-12 bootfix-col">
                                {{--<div class="row d-flex justify-content-center">
                                    <div style="display:none;" class="col-lg-6 col-sm-8">
                                        {{ $events->appends(['text' => Request::input('text'), 'date' => Request::input('date'), 'categories' => Request::input('categories'), 'location' => Request::input('location')])->links('frontend.includes.pagination', ['paginator' => $events]) }}
                                    </div>
                                    <div class="col-lg-6 col-sm-4 show-more">
                                        @if ($events->lastPage() != $events->currentPage())
                                            <a href="">
                                                <div class="view-more-button">Показать еще</div>
                                            </a>
                                        @endif
                                    </div>
                                </div>--}}
                            </div>
                            {{--<div class="col-md-12 direct">--}}
                            {{--<img src="/images/ad.png"/>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container seoblock">
        @if (is_null($category->tile->text))
            @include('frontend.includes.seo.events_rating_list_page')
        @else
            {!!str_replace(array("city", "category"), array($city->name, $category->name), $category->tile->text)!!}
        @endif
    </div>
    <div class="modal fade" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="map-content">
                <div class="map-content__header">
                    <span>Акции на карте</span>
                    <div class="map-content__header-close" data-dismiss="modal" aria-label="Close"><img
                                src="/images/icons/close.svg"/></div>
                </div>
                <div class="modal-body">
                    <div id="map" style="width: 100%; height: 600px">
                        <addresses-map :balloon="true" :addresses="{{ $addresses }}" :modal="true"></addresses-map>
                    </div>
                </div>
            </div>
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
