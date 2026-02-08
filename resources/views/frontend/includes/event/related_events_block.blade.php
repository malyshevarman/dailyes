@if($event->related_events->count() > 0)
<div class="col-md-12">
    <div class="similar-title">
        Похожие акции
    </div>
    <div class="owl-carousel events-block gallery_owl">
        @foreach($event->related_events as $related_event)
            @if($event->id != $related_event->id)
                <div>
                <div class="events-block__image">
                    <a href="{{ route('frontend.event.show', $related_event) }}"><img
                                src="{{ $related_event->image_url }}" alt="{{$related_event->name}}"/><div class="animation-block"></div></a>
                    @if($related_event->favorite)
                        <div class="events-block__cool">
                            <img src="/images/icons/success.svg"/> Выбор редакции
                        </div>
                    @endif
                    <div class="events-block__badges">
                        @foreach($related_event->labels as $label)
                            <div class="events-block__badges-group">
                                <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                {{ $label->name }}
                            </div>
                        @endforeach
                    </div>
                    <bookmark :event="{{ json_encode($related_event->only('slug')) }}"
                              :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $related_event->id) : false) }}"></bookmark>
                </div>
                <div class="events-block__title">
                    <a href="{{ route('frontend.event.show', $related_event) }}">{{ $related_event->name }}</a>
                </div>
                @if($related_event->tags->count() > 0)
                    <a href="{{ route('frontend.city.event.tag.show', $related_event->tags[0]) }}"
                        class="events-block__group-a">
                        <span class="events-block__group">{{ $related_event->tags[0]->name }}</span>
                    </a>
                @endif
                <div class="events-block__text-desc">
                    <a href="{{ route('frontend.company.show', $related_event->company) }}">{{ $related_event->company->name }}</a>
                </div>
                <div class="events-block__text-desc">
                    @if($related_event->status == 'active')
                        Дата окончания: {{is_null($related_event->end) ? "Бессрочная" : $related_event->end->locale('ru')->isoFormat('D MMMM YYYY') }}
                    @elseif($related_event->status == 'before')
                        Дата начала: {{ $related_event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                    @elseif($related_event->status == 'after')
                        Завершено
                    @endif
                </div>
                <div class="events-block__text-icons v-align">
                    <img src="/images/icons/thumb-up-blue.svg"/> {{ $related_event->rec }}%
                    <img src="/images/icons/star-blue.svg"/> {{ round($related_event->star, 1) }}
                    <img src="/images/icons/eye.svg"/> {{ $related_event->views }}
                </div>
            </div>
        @endif
        @endforeach
    </div>
</div>
<div class="col-md-12">
    <div class="blue_hr"></div>
</div>
@endif