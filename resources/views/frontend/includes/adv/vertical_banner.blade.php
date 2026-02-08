<div class="col-lg-3 col-md-12 text-center">
    <div class="text-block__ad-fixed mobhb">
        @if($itemFirstPlace->activeBanners->count() > 0)
            <div id="owl-card-1" class="owl-carousel owl-theme">
                @foreach($itemFirstPlace->activeBanners as $activeBanner)
                    <a href="{{ $activeBanner->link }}" target="_blank">
                        <img src="{{isset($activeBanner->download->url) ? $activeBanner->download->url : ''}}" style="display: block; width: 100%;"/>
                    </a>
                @endforeach
            </div>
            <div id="owl-card-1-mobile" class="owl-carousel owl-theme">
                @foreach($itemFirstPlace->activeBanners as $activeBanner)
                    @if (isset($activeBanner->mobile->url))
                    <a href="{{ $activeBanner->link }}" target="_blank">
                        <img src="{{$activeBanner->mobile->url}}" style="display: block; width: 100%;"/>
                    </a>
                    @endif
                @endforeach
            </div>

        @else
        <div id="owl-card-1" class="owl-carousel owl-theme">
            <div class="empty_banner-v">
                <div>
                    Здесь может быть ваша реклама
                </div>
                <a href="/ad">
                    Разместить рекламу
                </a>
            </div>
        </div>
        <div id="owl-card-1-mobile" class="owl-carousel owl-theme">
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
    <div class="scroll_ad adhd">
        <ul>
            <li>
                <div class="text-block__ad-fixed">
                    @if($itemFirstPlace->activeBanners->count() > 0)
                        <div id="owl-card-2" class="owl-carousel owl-theme">
                            @foreach($itemFirstPlace->activeBanners as $activeBanner)
                                <a href="{{ $activeBanner->link }}" target="_blank">
                                    <img src="{{isset($activeBanner->download->url) ? $activeBanner->download->url : ''}}"/>
                                </a>
                            @endforeach
                        </div>
                        <div id="owl-card-2-mobile" class="owl-carousel owl-theme">
                            @foreach($itemFirstPlace->activeBanners as $activeBanner)
                                @if (isset($activeBanner->mobile->url))
                                <a href="{{ $activeBanner->link }}" target="_blank">
                                    <img src="{{$activeBanner->mobile->url}}"/>
                                </a>
                                @endif
                            @endforeach
                        </div>

                    @else

                        <div id="owl-card-2" class="owl-carousel owl-theme">
                            <div class="empty_banner-v">
                                <div>
                                    Здесь может быть ваша реклама
                                </div>
                                <a href="/ad">
                                    Разместить рекламу
                                </a>
                            </div>
                        </div>
                        <div id="owl-card-2-mobile" class="owl-carousel owl-theme">
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
            </li>
            <li>
                <div class="text-block__ad-fixed">
                    @if($itemSecondPlace->activeBanners->count() > 0)
                        <div id="owl-card-3" class="owl-carousel owl-theme">
                            @foreach($itemSecondPlace->activeBanners as $activeBanner)
                                <a href="{{ $activeBanner->link }}" target="_blank">
                                    <img src="{{isset($activeBanner->download->url) ? $activeBanner->download->url : ''}}"/>
                                </a>
                            @endforeach
                        </div>
                        <div id="owl-card-3-mobile" class="owl-carousel owl-theme">
                            @foreach($itemSecondPlace->activeBanners as $activeBanner)
                                @if (isset($activeBanner->mobile->url))
                                <a href="{{ $activeBanner->link }}" target="_blank">
                                    <img src="{{$activeBanner->mobile->url}}"/>
                                </a>
                                @endif
                            @endforeach
                        </div>
                     @else

                        <div id="owl-card-3" class="owl-carousel owl-theme">
                            <div class="empty_banner-v">
                                <div>
                                    Здесь может быть ваша реклама
                                </div>
                                <a href="/ad">
                                    Разместить рекламу
                                </a>
                            </div>
                        </div>
                        <div id="owl-card-3-mobile" class="owl-carousel owl-theme">
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
            </li>
        </ul>
    </div>
</div>