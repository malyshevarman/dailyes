@if($mainBannerPlace->activeBanners->count() > 0)

    <div class="col-md-12"><div class="blue_hr"></div></div>

    <div id="owl-banner-main" class="container owl-carousel owl-theme">
        @foreach($mainBannerPlace->activeBanners as $activeBanner)
            <a href="{{ $activeBanner->link }}" target="_blank">
                <img class="banner" style="width: 100%;" src="{{isset($activeBanner->download->url) ? $activeBanner->download->url : ''}}"/>
            </a>
        @endforeach
    </div>
    <div class="oh container-fluid">
        <div id="owl-banner-main-mobile" class="container owl-carousel owl-theme" style="display: none;">
            @foreach($mainBannerPlace->activeBanners as $activeBanner)
                <a href="{{ $activeBanner->link }}" target="_blank">
                    <img class="banner" style="width: 100%;" src="{{isset($activeBanner->mobile->url) ? $activeBanner->mobile->url : ''}}"/>
                </a>
            @endforeach
        </div>

        <div>
            <div class="h-align">
                <a href="/ad" style="color: #8BA3B9;
                                                            font-size: 12px;
                                                            font-family: 'Monsterrat-medium';">
                    + Разместить рекламу
                </a>
            </div>
        </div>
    </div>

@else
    <!-- <div id="owl-banner-main" class="container owl-carousel owl-theme">
        <img class="banner" style="width: 100%;" src="/images/banner_adv_horizontal-placeholder.png"/>
    </div>
    <div class="oh container-fluid">
        <div id="owl-banner-main-mobile" class="container owl-carousel owl-theme" style="display: none;">
            <img class="banner" style="width: 100%;" src="/images/banner_adv_horizontal-placeholder.png"/>
        </div>
    </div> -->
    <div class="col-md-12"><div class="blue_hr"></div></div>
    <div id="owl-banner-main" class="container owl-carousel owl-theme">
        <div class="empty_banner-h">
            <div>
                Здесь может быть ваша реклама
            </div>
            <a href="/ad">
                Разместить рекламу
            </a>
        </div>
    </div>
    <div class="oh container-fluid">
        <div id="owl-banner-main-mobile" class="container owl-carousel owl-theme" style="display: none;">
            <div class="empty_banner-h">
                <div>
                    Здесь может быть ваша реклама
                </div>
                <a href="/ad">
                    Разместить рекламу
                </a>
            </div>
        </div>
    </div>
@endif