@if($item->activeBanners->count() > 0)
    <div id="owl-company-list-{{$placeNumber}}" class="col-md-12 text-center bootfix-col owl-carousel owl-theme">
        @foreach($item->activeBanners as $activeBanner)
            <a href="{{ $activeBanner->link }}" target="_blank">
                <img src="{{isset($activeBanner->download->url) ? $activeBanner->download->url : ''}}"/>
            </a>
        @endforeach
    </div>
    <div id="owl-company-list-{{$placeNumber}}-mobile" class="col-md-12 text-center bootfix-col owl-carousel owl-theme" style="display: none;">
        @foreach($item->activeBanners as $activeBanner)
            <a href="{{ $activeBanner->link }}" target="_blank">
                <img src="{{isset($activeBanner->mobile->url) ? $activeBanner->mobile->url : ''}}"/>
            </a>
        @endforeach
    </div>
    <div class="col-md-12 text-center ad bootfix-col">
        <div class="h-align">
            <a href="/ad" style="color: #8BA3B9;
                                                        font-size: 12px;
                                                        font-family: 'Monsterrat-medium';">
                + Разместить рекламу
            </a>
        </div>
    </div>

@else
    <div id="owl-company-list-{{$placeNumber}}" class="col-md-12 text-center bootfix-col owl-carousel owl-theme">
        <div class="empty_banner-h" style="margin-bottom: 50px;">
            <div>
                Здесь может быть ваша реклама
            </div>
            <a href="/ad">
                Разместить рекламу
            </a>
        </div>
    </div>
    <div id="owl-company-list-{{$placeNumber}}-mobile" class="col-md-12 text-center bootfix-col owl-carousel owl-theme" style="display: none;">
        <div class="empty_banner-h" style="margin-bottom: 50px;">
            <div>
                Здесь может быть ваша реклама
            </div>
            <a href="/ad">
                Разместить рекламу
            </a>
        </div>
    </div>
@endif