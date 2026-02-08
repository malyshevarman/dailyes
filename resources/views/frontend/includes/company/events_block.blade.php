<div class="col-md-12">
    <div class="similar-title">
        Акции компании
        <ul class="nav similar-title__group">
            <li class="active similar-active">
                <a data-toggle="tab" class="active" href="#active">Активные</a><sup>{{count($company->active_events)}}</sup>
            </li>
            <li class="similar-completed">
                <a data-toggle="tab" href="#completed">Завершенные</a><sup>{{count($company->completed_events)}}</sup>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="active" class="tab-pane in active show">
            @if (count($company->active_events) == 0)
                <div class="tab-content__text">

                    <div class="info_block nomrg">
                        <div>В данный момент у компании нет ни одной активной акции. Добавьте эту компанию в избранное и как только у неё появится новое предложение, мы оповестим Вас об этом.
                        </div>
                    </div>

                </div>
            @else
            <div class="owl-carousel events-block gallery_owl">
                @foreach($company->active_events as $active_event)
                    <div>
                        <div class="events-block__image">
                            <a href="{{ route('frontend.event.show', $active_event) }}"><img
                                        src="{{ $active_event->image_url }}" alt="{{$active_event->name}}"/><div class="animation-block"></div></a>
                            @if($active_event->favorite)
                                <div class="events-block__cool">
                                    <img src="/images/icons/success.svg"/> Выбор редакции
                                </div>
                            @endif
                            <div class="events-block__badges">
                                @foreach($active_event->labels as $label)
                                    <div class="events-block__badges-group">
                                        <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                        {{ $label->name }}
                                    </div>
                                @endforeach
                            </div>
                            <bookmark :event="{{ json_encode($active_event->only('slug')) }}"
                                      :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $active_event->id) : false) }}"></bookmark>
                        </div>
                        <div class="events-block__title">
                            <a href="{{ route('frontend.event.show', $active_event) }}">{{ $active_event->name }}</a>
                        </div>
                        @if($active_event->tags->count() > 0)
                            <a href="{{ route('frontend.city.event.tag.show', $active_event->tags[0]) }}"
                                class="events-block__group-a">
                                <span class="events-block__group">{{ $active_event->tags[0]->name }}</span>
                            </a>
                        @endif
                        <div class="events-block__text-desc">
                            <a href="{{ route('frontend.company.show', $active_event->company) }}">{{ $active_event->company->name }}</a>
                        </div>
                        <div class="events-block__text-desc">
                            @if($active_event->status == 'active')
                                Дата
                                окончания: {{!is_null($active_event->end) ? $active_event->end->locale('ru')->isoFormat('D MMMM YYYY') : 'Бессрочная' }}
                            @elseif($active_event->status == 'before')
                                Дата
                                начала: {{ $active_event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                            @elseif($active_event->status == 'after')
                                Завершено
                            @endif
                        </div>
                        <div class="events-block__text-icons v-align">
                            <img src="/images/icons/thumb-up-blue.svg"/> {{ $active_event->rec }}%
                            <img src="/images/icons/star-blue.svg"/> {{ round($active_event->star, 1) }}
                            <img src="/images/icons/eye.svg"/> {{ $active_event->views }}
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
        <div id="completed" class="tab-pane">
            @if (count($company->completed_events) == 0)
                <div class="tab-content__text">


                    <div class="info_block nomrg">
                        <div>Здесь появится информация о прошедших акциях.</div>
                    </div>

                </div>


            @else
                <div class="owl-carousel events-block gallery_owl">
                    @foreach($company->completed_events as $completed_event)
                        <div>
                            <div class="events-block__ended">
                                    <div class="events-block__empty center">Акция завершена</div>
                                    <div class="animation-block"></div>
                                <img src="{{ $completed_event->image_url }}" alt="{{$completed_event->name}}"/>
                            </div>
                            <div class="events-block__title">
                                {{ $completed_event->name }}
                            </div>
                                @if($completed_event->tags->count() > 0)
                                    <span class="events-block__group">{{ $completed_event->tags[0]->name }}</span>
                                @endif
                            <div class="events-block__text-desc">
                                {{ $completed_event->company->name }}
                            </div>
                            <div class="events-block__text-desc">
                                @if($completed_event->status == 'active')
                                    Дата
                                    окончания: {{!is_null($completed_event->end) ? $completed_event->end->locale('ru')->isoFormat('D MMMM YYYY') : 'Бессрочная' }}
                                @elseif($completed_event->status == 'before')
                                    Дата
                                    начала: {{ $completed_event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                                @elseif($completed_event->status == 'after')
                                    Завершено
                                @endif
                            </div>
                            <div class="events-block__text-icons v-align">
                                <img src="/images/icons/thumb-up-blue.svg"/> {{ $completed_event->rec }}%
                                <img src="/images/icons/star-blue.svg"/> {{ round($completed_event->star, 1) }}
                                <img src="/images/icons/eye.svg"/> {{ $completed_event->views }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>