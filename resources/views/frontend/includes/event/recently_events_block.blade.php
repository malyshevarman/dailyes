@php
$recently_events = recently_events($event);
@endphp

@if (count($recently_events) > 0)
<div class="col-md-12">
    <div class="similar-title">
        Недавно просмотренные акции
    </div>
    <div class="owl-carousel events-block gallery_owl">
        @foreach($recently_events as $recently_event)
            <div>
                <div class="events-block__image">
                    <a href="{{ route('frontend.event.show', $recently_event) }}"><img
                                src="{{ $recently_event->image_url }}" alt="{{$recently_event->name}}"/><div class="animation-block"></div></a>
                    @if($recently_event->favorite)
                        <div class="events-block__cool">
                            <img src="/images/icons/success.svg"/> Выбор редакции
                        </div>
                    @endif
                    <div class="events-block__badges">
                        @foreach($recently_event->labels as $label)
                            <div class="events-block__badges-group">
                                <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                {{ $label->name }}
                            </div>
                        @endforeach
                    </div>
                    <bookmark :event="{{ json_encode($recently_event->only('slug')) }}"
                              :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $recently_event->id) : false) }}"></bookmark>
                </div>
                <div class="events-block__title">
                    <a href="{{ route('frontend.event.show', $recently_event) }}">{{ $recently_event->name }}</a>
                </div>
                @if($recently_event->tags->count() > 0)
                    <a href="{{ route('frontend.city.event.tag.show', $recently_event->tags[0]) }}"
                        class="events-block__group-a">
                        <span class="events-block__group">{{ $recently_event->tags[0]->name }}</span>
                    </a>
                @endif
                <div class="events-block__text-desc">
                    <a href="{{ route('frontend.company.show', $recently_event->company) }}">{{ $recently_event->company->name }}</a>
                </div>
                <div class="events-block__text-desc">
                    @if($recently_event->status == 'active')
                        Дата окончания: {{!is_null($recently_event->end) ? $recently_event->end->locale('ru')->isoFormat('D MMMM YYYY') : 'Бессрочная'}}
                    @elseif($recently_event->status == 'before')
                        Дата начала: {{ $recently_event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                    @elseif($recently_event->status == 'after')
                        Завершено
                    @endif
                </div>
                <div class="events-block__text-icons v-align">
                    <img src="/images/icons/thumb-up-blue.svg"/> {{ $recently_event->rec }}%
                    <img src="/images/icons/star-blue.svg"/> {{ round($recently_event->star, 1) }}
                    <img src="/images/icons/eye.svg"/> {{ $recently_event->views }}
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="col-md-12">
    <div class="blue_hr"></div>
</div>
@endif