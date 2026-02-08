@extends('frontend.layouts.app')

@section('header')
    @include('frontend.includes.headers.event')
@endsection

@push('after-scripts')
    <script src="/js/sticky.min.js"></script>
    <script>
        var sticky = new Sticky('.selector');
    </script>
    <script>
        function getBodyScrollTop()
        {
        return self.pageYOffset || (document.documentElement && document.documentElement.scrollTop) || (document.body && document.body.scrollTop);
        }
        $('#report6').click(function () {
            if ($(this).is(':checked')) {
                $('.report-textarea').show();
            } else {
                $('.report-textarea').hide();
            }
        });
        $(window).on('load', function() {
            if (getBodyScrollTop() > 0) {
                $('.icon-scroll').fadeOut();
            }
        })
        $(window).scroll(function () {
            if ($(this).scrollTop() > 500 || getBodyScrollTop() > 0) {
                $('.icon-scroll').fadeOut();
            } else {
                $('.icon-scroll').fadeIn();
            }
        });
        $('.icon-scroll').click(function (e) {
            e.preventDefault();
            jQuery('html, body').animate({
                scrollTop:  document.documentElement.clientHeight
            }, 1000);
        });
        first_slider = $('#owl-card-1');
        second_slider = $('#owl-card-2');
        third_slider = $('#owl-card-3');
        fourth_slider = $('#owl-card-4');
        first_slide_mobile = $('#owl-card-1-mobile');
        second_slide_mobile = $('#owl-card-2-mobile');
        third_slide_mobile = $('#owl-card-3-mobile');
        fourth_slide_mobile = $('#owl-card-4-mobile');
        responsiveBanner = function () {
            if ($(window).width() <= '600'){
                first_slider.hide();
                second_slider.hide();
                third_slider.hide();
                fourth_slider.hide();
                first_slide_mobile.show();
                second_slide_mobile.show();
                third_slide_mobile.show();
                fourth_slide_mobile.show();
            } else {
                first_slide_mobile.hide();
                second_slide_mobile.hide();
                third_slide_mobile.hide();
                fourth_slide_mobile.hide();
                first_slider.show();
                second_slider.show();
                third_slider.show();
                fourth_slider.show();
            }
        }
        $(window).on('load resize',responsiveBanner);

        // function successComment() {
        //       var button = document.getElementById('submit-review-form')
        //       var input = document.getElementById("review-text")
        //      if(input.value==="") { 
        //             button.disabled = true;
        //             button.classList.add("disabled");
        //         } else { 
        //             button.disabled = false;
        //             button.classList.remove("disabled");
        //         }
        //     }

        // function successAnswer() {
        //       var button = document.getElementById('submit-review-answer-form')
        //       var input = document.getElementById("review-answer-text")
        //      if(input.value==="") { 
        //             button.disabled = true;
        //             button.classList.add("disabled");
        //         } else { 
        //             button.disabled = false;
        //             button.classList.remove("disabled");
        //         }
        //     }
    </script>
@endpush

@section('title', $event->name ?? '')
@section('description', $event->summary ?? '')
@section('image', $event->image_url ?? $event->background_url)
@section('url', route('frontend.event.show', $event))

@section('content')
    <div class="icon-scroll">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="36" viewBox="0 0 24 36">
            <path fill="currentcolor" fill-rule="evenodd" d="M14 15c0 .828-.672 1.5-1.5 1.5h-1c-.829 0-1.5-.672-1.5-1.5v-4.5c0-.829.671-1.5 1.5-1.5h1c.828 0 1.5.671 1.5 1.5V15zM0 10v17.5c0 8 8.848 8.5 12 8.5 3.152 0 12-.5 12-8.5V10c0-8-8.848-10-12-10C8.848 0 0 2 0 10z"></path>
        </svg>
    </div>
    <div class="container-fluid minus-15">
        <div class="row">
            @include('frontend.includes.event.toggle_publish_block', $event)

        </div>
    </div>
    <div class="container mw text-global-block">
        <div class="row">
            @include('frontend.includes.event.description_block', $event)



            @include('frontend.includes.adv.vertical_banner', ['itemFirstPlace' => $eventOnePlace, 'itemSecondPlace' => $eventSecondPlace])


            <div class="col-lg-9 col-md-12">
                @include('frontend.includes.event.media_gallery_block', $event)

                @include('frontend.includes.event.map_block', $event)

                @include('frontend.includes.event.reviews_stars_block', $event)
            </div>

            @include('frontend.includes.adv.sticky_vertical_banner', ['itemSecondPlace' => $eventSecondPlace])

            
            <div class="col-md-12">
                <div class="questions-block">
                    @if(auth()->id() && auth()->id() !== $event->user->id)
                        @include('frontend.includes.event.questions_form_block', $event)
                    @endif
                    @include('frontend.includes.event.questions_block', $event)
                    <div class="col-md-12">
                        <button class="more_review">Показать еще отзывы</button>
                    </div>
                </div>
            </div>


            @include('frontend.includes.event.reviews_form_block', $event)


            @include('frontend.includes.event.reviews_block', $event)
            <div class="col-md-12">
                <button class="more_review">Показать еще отзывы</button>
            </div>

            @include('frontend.includes.forbusiness_block')


            {{--@if (count($event->selections) > 0)
            <div class="col-md-12  reiting-block-company">
                <div class="selection-block_main">
                    <div class="similar-title_selection">
                        Эта акция состоит в следующих рейтингах
                        <img src="/images/icons/open_button.svg"/>
                    </div>
                    <div class="gallery_owl_selection owl-carousel selections_owl">
                        @foreach ($event->selections as $selection)
                        <div>
                            <a href="{{isset($selection->tile) ? $selection->tile->url : ''}}">
                                <div class="selection-block">
                                    <img src="{{$selection->background_url}}" alt="{{$selection->name}}">
                                    <span class="selection-name">
                                        {{$selection->name}}
                                    </span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif--}}
            @include('frontend.includes.event.related_events_block', $event)
            
            @include('frontend.includes.event.recently_events_block', $event)
        </div>
    </div>
    @include('frontend.includes.event.report_form_panel', $event)
    {{--<div class="container mw seoblock">
                    @include('frontend.includes.seo.event_card_page')
            </div>--}}
    @include('frontend.includes.event.map_modal', $event)
@endsection
