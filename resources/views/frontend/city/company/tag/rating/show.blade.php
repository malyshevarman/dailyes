@extends('frontend.layouts.app')

@section('header')
    @include('frontend.includes.headers.company-rating')
@endsection

@push('after-scripts')
    <script>
        $('.companies-container').infiniteScroll({
            path: '.pagination__next',
            append: '.company-item',
            button: '.view-more-button',
            // using button, disable loading on scroll
            scrollThreshold: false,
            // status: '.page-load-status',
        });
    </script>
@endpush

@section('title', $tag->slide->name)
@section('description', $tag->slide->summary)
@section('image', $tag->slide->image_url ?? '')
@section('url', route('frontend.rating.company.show', $tag->slide))

@section('content')
    <div class="container-fluid search-panel">
        <div class="container minus-15">
            <div class="row">
                <div class="col-md-12">
                    <div class="events-block company-block">
                        <div class="raiting-company">
                            @foreach($companies as $key => $company)
                                <div class="raiting-company-item">
                                    <div class="raiting-company-item-place">
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

                                    <div class="raiting-company-item_item">
                                        <div>
                                            <a href="{{ route('frontend.company.show', $company) }}"><img
                                                        src="{{ $company->image_url }}" alt="{{$company->name}}"/></a>
                                        </div>
                                        <div>
                                            <div class="events-block__title">
                                                <a href="{{ route('frontend.company.show', $company) }}">{{ $company->name }}</a>
                                            </div>
                                            @if ($company->tags->count() > 0)
                                                <a href="{{ route('frontend.city.company.tag.show', $company->tags[0]) }}"
                                                    class="events-block__group-a">
                                                    <span class="events-block__group">{{ $company->tags[0]->name }}</span>
                                                </a>
                                            @endif
                                            <div class="events-block__text-desc-selection">
                                                <a style="display:block;" href="{{ route('frontend.company.show', $company) }}">{{iconv_strlen($company->about) < 100 ? $company->about : cutter($company->about)}}</a>
                                            </div>
                                            <div class="events-block__text-icons v-align">
                                                <img src="/images/icons/thumb-up-blue.svg"/> {{ $company->rec }}%
                                                <img src="/images/icons/star-blue.svg"/> {{ round($company->star, 1) }}
                                                <img src="/images/icons/eye.svg"/> {{ $company->views }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            {{--<div class="col-md-12 bot-panel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-sm-8" style="display:none;">
                                        {{ $companies->appends(['text' => Request::input('text'), 'categories' => Request::input('categories'), 'location' => Request::input('location')])->links('frontend.includes.pagination', ['paginator' => $companies]) }}
                                    </div>
                                    <div class="col-lg-6 col-sm-4 show-more">
                                        @if ($companies->lastPage() != $companies->currentPage())
                                            <a href="">
                                                <div class="view-more-button">Показать еще</div>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>--}}
                         <!--
                         <div class="col-md-12 direct">
                                <img src="/images/ad.png"/>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container seoblock">
            @if (is_null($tag->slide->text))
            @include('frontend.includes.seo.companies_rating_list_page')
            @else
                {!!str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->slide->text)!!}
            @endif
    </div>
    <div class="modal fade" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="map-content">
                <div class="map-content__header">
                    <span>Компании на карте</span>
                    <div class="map-content__header-close" data-dismiss="modal" aria-label="Close"><img
                                src="/images/icons/close.svg"/></div>
                </div>
                <div class="modal-body">
                    <div id="map" style="width: 100%; height: 600px">
                        <company-map :balloon="true" :addresses="{{ $addresses }}" :modal="true"></company-map>
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
