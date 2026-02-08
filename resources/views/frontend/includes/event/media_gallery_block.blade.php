@if($event->gallery_items->count() > 0)
    <div class="text-block__title">
        Медиагалерея
    </div>
    <div class="mediagalleryMob">
        <div id="owl-gallery" class="owl-carousel">
            @foreach($event->gallery_items as $gallery_item)
                @if($gallery_item->attachable_type == 'App\Video' || ($loop->iteration == 6 && $loop->remaining > 0))
                    <div class="item">
                        <div class="block-gallery">
                            <img class="block-gallery__photo"
                                 src="{{isset($gallery_item->attachable) ? $gallery_item->attachable->url : ''}}"/>
                            <a data-fancybox="gallery-mob"
                               href="{{ $gallery_item->attachable_type == 'App\Video' ? $gallery_item->attachable->link : $gallery_item->attachable->url }}">
                                <div class="block-gallery__shadow">
                                    <div class="h-align">
                                        <div class="v-align">
                                            @if($loop->iteration == 6 && $loop->remaining > 0)
                                                <div class="block-gallery__shadow-title">
                                                    +{{ $loop->remaining }}</div>
                                            @elseif($gallery_item->attachable_type == 'App\Video')
                                                <img src="/images/icons/play-arrow.svg"/>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="item">
                        <div class="block-gallery">
                            <a data-fancybox="gallery-mob"
                               href="{{isset($gallery_item->attachable) ? $gallery_item->attachable->url : ''}}">
                                <img class="block-gallery__photo"
                                     src="{{isset($gallery_item->attachable) ? $gallery_item->attachable->url : ''}}"/>
                            </a>
                        </div>
                    </div>
                @endif
                @if($loop->iteration == 6)
                    @break
                @endif
            @endforeach
        </div>
        <div hidden>
            @foreach($event->gallery_items as $gallery_item)
                @if($loop->iteration <= 6)
                    @continue
                @else
                    @if($gallery_item->attachable_type == 'App\Video')
                        <a data-fancybox="gallery-mob" href="{{ $gallery_item->attachable->link }}"></a>
                    @elseif($gallery_item->attachable_type == 'App\Download')
                        <a data-fancybox="gallery-mob"
                           href="{{isset($gallery_item->attachable) ? $gallery_item->attachable->url : ''}}"></a>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
    <div class="row block-gallery__global">
        @foreach($event->gallery_items as $gallery_item)
            @if($gallery_item->attachable_type == 'App\Video' || ($loop->iteration == 6 && $loop->remaining > 0))
                <div class="col-md-4">
                    <div class="block-gallery">
                        <img class="block-gallery__photo" src="{{isset($gallery_item->attachable) ? $gallery_item->attachable->url : ''}}"/>
                        <a data-fancybox="gallery"
                           href="{{ $gallery_item->attachable_type == 'App\Video' ? $gallery_item->attachable->link : $gallery_item->attachable->url }}">
                            <div class="block-gallery__shadow">
                                <div class="h-align">
                                    <div class="v-align">
                                        @if($loop->iteration == 6 && $loop->remaining > 0)
                                            <div class="block-gallery__shadow-title">
                                                +{{ $loop->remaining }}</div>
                                        @elseif($gallery_item->attachable_type == 'App\Video')
                                            <img src="/images/icons/play-arrow.svg"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <div class="block-gallery">
                        <a data-fancybox="gallery" href="{{isset($gallery_item->attachable) ? $gallery_item->attachable->url : ''}}">
                            <img class="block-gallery__photo"
                                 src="{{isset($gallery_item->attachable) ? $gallery_item->attachable->url : ''}}"/>
                        </a>
                    </div>
                </div>
            @endif
            @if($loop->iteration == 6)
                @break
            @endif
        @endforeach
        <div hidden>
            @foreach($event->gallery_items as $gallery_item)
                @if($loop->iteration <= 6)
                    @continue
                @else
                    @if($gallery_item->attachable_type == 'App\Video')
                        <a data-fancybox="gallery" href="{{ $gallery_item->attachable->link }}"></a>
                    @elseif($gallery_item->attachable_type == 'App\Download')
                        <a data-fancybox="gallery"
                           href="{{isset($gallery_item->attachable) ? $gallery_item->attachable->url : ''}}"></a>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
@endif