<div data-sticky-container class="col-md-3 text-center hide_block">
    <div class="text-block__ad selector" data-margin-top="20" data-sticky-wrap="true">
        <div>
            @if($itemSecondPlace->activeBanners->count() > 0)
                <div id="owl-card-4" class="owl-carousel owl-theme">
                    @foreach($itemSecondPlace->activeBanners as $activeBanner)
                        <a href="{{ $activeBanner->link }}" target="_blank">
                            <img src="{{isset($activeBanner->download->url) ? $activeBanner->download->url : ''}}"/>
                        </a>
                    @endforeach
                </div>
                <div id="owl-card-4-mobile" class="owl-carousel owl-theme">
                    @foreach($itemSecondPlace->activeBanners as $activeBanner)
                        @if (isset($activeBanner->mobile->url))
                        <a href="{{ $activeBanner->link }}" target="_blank">
                            <img src="{{$activeBanner->mobile->url}}"/>
                        </a>
                        @endif
                    @endforeach
                </div>
            @else

                <div id="owl-card-4" class="owl-carousel owl-theme">
                    <div class="empty_banner-v">
                        <div>
                            Здесь может быть ваша реклама
                        </div>
                        <a href="/ad">
                            Разместить рекламу
                        </a>
                    </div>
                </div>
                <div id="owl-card-4-mobile" class="owl-carousel owl-theme">
                    <div class="empty_banner-v">
                        <div>
                            Здесь может быть ваша реклама
                        </div>
                        <a href="/ad">
                            Разместить рекламу
                        </a>
                    </div>
                </div>
            @endif
            <div class="h-align ad-button"><a href="/ad">+ Разместить рекламу</a></div>
        </div>
    </div>
</div>