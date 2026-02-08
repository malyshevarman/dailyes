@extends('frontend.layouts.app')

@section('header')
    @include('frontend.includes.headers.company-tag')
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

@section('content')
    <div class="container-fluid search-panel">
        <div class="container minus-15">
            <div class="row">
                
                    @if(isset($tagsForNavigation) && count($tagsForNavigation) > 0)
                    <div class="category-tags-block">
                        <ul class="category-tags" style="margin-top: 40px;">
                            @foreach ($tagsForNavigation as $key => $value)
                                <li>
                                    <span class="filter_tag {{$tag->id !== $value->id ? 'grey' : ''}}">
                                        <a href="{{ route('frontend.city.company.tag.show', $value) }}">
                                            {{$value->name}}
                                        </a>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                <div class="col-md-12">
                    @if($companies->count() == 0 && !Request::get('text') && !Request::get('location'))
                        <div class="container minus-15">
                            <div class="info_block">
                                <div>Скоро здесь появится информация о компаниях</div>
                            </div>

                        </div>
                    @endif


                    @if($companies->count() == 0 && Request::get('text') || $companies->count() == 0 && Request::get('location'))
                        <div class="container minus-15">
                            <div class="info_block">
                                <div>К сожалению, по вашему запросу ничего не найдено</div>
                            </div>

                        </div>
                    @endif

                    <div class="events-block company-block">
                        <div class="row companies-container bootfix-row">
                            @foreach($companies as $key => $company)
                                <div class="col-lg-3 col-md-6 col-sm-6 company-item bootfix-col">
                                    <div class="search-panel__company-block">
                                        <img src="{{ $company->image_url }}" alt="{{$company->name}}"/>
                                        <a href="{{ route('frontend.company.show', $company) }}">
                                            <div class="events-block__empty" style="z-index: unset;"></div>
                                            <div class="animation-block"></div>
                                        </a>

                                        @if ($company->tags->count() > 0)
                                        <a href="{{ route('frontend.city.company.tag.show', $company->tags[0]) }}">
                                            <div class="search-panel__company-group">
                                                {{$company->tags[0]->name}}
                                            </div>
                                        </a>
                                        @endif
                                        <company-bookmark :company="{{ json_encode($company->only('slug')) }}"
                                                          :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_companies->contains('id', $company->id) : false) }}"></company-bookmark>
                                        
                                        <div class="search-panel__company-text">
                                            <div class="search-panel__company-title">{{ $company->name }}</div>
                                            <div class="search-panel__company-place">{{ $company->addresses->count() > 0 ? (isset($current_address) ? $current_address : $company->addresses[0]->address) : '' }}{{ $company->addresses->count() > 1 ? ' и еще ' : ''}} <span>{{ $company->addresses->count() > 1 ? ($company->addresses->count() - 1). ' ' . pular(($company->addresses->count() - 1), ['адрес', 'адреса', 'адресов']) : '' }}</span></div>
                                            <div class="search-panel__company-badges">
                                                <img src="/images/icons/thumb-up-black.svg"/>
                                                <span>{{ $company->rec }}</span>
                                                <img class="star" src="/images/icons/star.svg"/>
                                                <span>{{ round($company->star, 1) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(($key + 1) == 8)
                                    @include('frontend.includes.adv.horizontal_banner', ['item' => $companyListOnePlace, 'placeNumber' => 1])
                                @elseif(($key + 1) == 16)
                                    @include('frontend.includes.adv.horizontal_banner', ['item' => $companyListSecondPlace, 'placeNumber' => 2])
                                @elseif(($key + 1) == 24)
                                    @include('frontend.includes.adv.horizontal_banner', ['item' => $companyListTreePlace, 'placeNumber' => 3])
                                @endif
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-12 bot-panel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-sm-8" style="display:none;">
                                        {{ $companies->appends(['text' => Request::input('text'), 'categories' => Request::input('categories'), 'location' => Request::input('location')])->links('frontend.includes.pagination', ['paginator' => $companies]) }}
                                    </div>
                                    <div class="col-lg-3 col-sm-4 show-more">
                                        @if ($companies->lastPage() != $companies->currentPage())
                                            <a href="">
                                                <div class="view-more-button">Показать еще</div>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
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
        {!!str_replace(array("city", "tag"), array($city->name, $tag->name), $tag->companySeo->page_text)!!}
    </div>
    {{--<div class="modal fade" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                <company-map :balloon="true" :drag="true" :addresses="{{ $addresses }}" :modal="true"></company-map>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
    <div class="modal fade map-modal" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <modal-map-index
                :city="{{json_encode($city)}}"
                :current-tag="{{json_encode($tag)}}"></modal-map-index>
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
