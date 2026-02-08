@extends('frontend.layouts.app')

@section('header')
    @include('frontend.includes.headers.city')
@endsection

@section('title', 'Dailyes - выгодные предложения, акции и скидки в городе ' . $city->name)
@section('description', 'На нашем сайте собраны лучшие скидки, акции, специальные предложения, бесплатные купоны и промокоды на каждый день, от разных компаний в твоём городе! Регистрируйся и экономь вместе с Дейлис!')

@section('content')
<div class="row">
    <div class="oh container-fluid">
        @if($tags->count() == 0)
            <div class="container minus-15">
                <div class="info_block">
                    <div>Скоро здесь появится информация о проходящих акциях</div>
                </div>
            </div>

        @endif
        @if($tags->count() > 0)
        <div class="container minus-15">
            <div class="title-catalog">
                <div>Категории акций</div>
                <div class="title-more__desc">Выберите интересующую вас категорию</div>
            </div>
            <div id="owl-1" class="owl-carousel events-block">
                @foreach($tags as $tag)
                    <a href="{{ route('frontend.city.event.tag.show', $tag) }}">
                        <div class="events-block__item">
                            <img src="{{ $tag->image_url }}" alt="Акции категории {{$tag->name}}"/>
                            <div class="events-block__text">
                                {{ $tag->name }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
    @if($tags->count() > 0)
    <div class="oh container-fluid">
        @if (count($slides) > 0)
        <div class="row">
            <div id="owl-2" class="owl-carousel rating-block owl-theme">
                @foreach($slides as $slide)
                    <div class="rating-block__item">
                        <img src="{{ $slide->image_url }}" alt="{{$slide->name}}"/>
                        <div class="rating-block__content">
                            <div class="container">
                                <div class="rating-block__content-block">
                                    <div class="rating-block__content-title">
                                        {{ $slide->name }} {{$slide->city ? '' : 'в городе ' . $city->name}}
                                    </div>
                                    <div class="rating-block__content-desc">
                                        {!! nl2br(e($slide->summary)) !!}
                                    </div>
                                    <a href="{{isset($slide->url) ? $slide->url : ''}}">
                                        <div class="rating-block__content-button">
                                            {{ $slide->button }}
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @else
        <div style="height: 40px;"></div>
        @endif
        @if (count($tiles) > 0)

        <div class="container inter-blog">
            <div class="row">
                <div id="owl-3" class="owl-carousel">
                    @foreach($tiles as $tile)
                        <div>
                            <a href="{{isset($tile->url) ? $tile->url : ''}}">
                                <div class="inter-blog__item">
                                    <div class="inter-blog__item-title">{{ $tile->name }} {{$tile->city ? '' : 'в городе ' . $city->name}}</div>
                                    <div class="inter-blog__item-desc">{!! nl2br(e($tile->summary)) !!}
                                    </div>
                                    <div class="inter-blog__item-button"><img src="/images/icons/open_button.svg"/>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div style="height: 40px;"></div>
        @endif
    </div>
    @endif
    <div class="oh container-fluid">
        <div class="container minus-15">
            <div class="main-page-map-button-block">
                <div class="main-page-map-button">
                    <a href="/stocks?map=1">
                        <div class="label">
                            <svg width="20" height="25" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.12534 10.6221C7.54271 10.9003 8.03357 11.0489 8.5359 11.0491L7.12534 10.6221ZM7.12534 10.6221C6.70778 10.3438 6.38263 9.9485 6.1907 9.48634M7.12534 10.6221L6.1907 9.48634M6.1907 9.48634C5.99878 9.0242 5.94859 8.51578 6.0464 8.02531M6.1907 9.48634L6.0464 8.02531M6.0464 8.02531C6.14422 7.53483 6.38572 7.08402 6.74065 6.73M6.0464 8.02531L6.74065 6.73M6.74065 6.73C7.09561 6.37597 7.54809 6.13464 8.04097 6.03686M6.74065 6.73L8.04097 6.03686M8.04097 6.03686C8.53386 5.93907 9.04474 5.98928 9.50892 6.18105M8.04097 6.03686L9.50892 6.18105M9.50892 6.18105C9.97308 6.37281 10.3695 6.69741 10.6482 7.11352M9.50892 6.18105L10.6482 7.11352M10.6482 7.11352C10.9268 7.52939 11.0755 8.01807 11.0756 8.51785L10.6482 7.11352ZM9.28666 1.28936V1.24923L8.5359 1.25C6.60501 1.25197 4.75335 2.0178 3.3873 3.38008C2.02118 4.74243 1.25231 6.59006 1.25 8.51772V8.51861C1.25 9.78359 1.66062 11.14 2.23223 12.4292C2.80797 13.7278 3.57173 15.0125 4.3327 16.1484C5.8547 18.4205 7.40592 20.157 7.54016 20.3065L7.54133 20.3078C7.667 20.4471 7.82053 20.5584 7.99191 20.6346C8.16326 20.7107 8.34867 20.75 8.53611 20.75C8.72356 20.75 8.90896 20.7107 9.0803 20.6346C9.25168 20.5584 9.40521 20.4471 9.53088 20.3078L9.53205 20.3065C9.66629 20.157 11.2175 18.4205 12.7395 16.1484C13.5005 15.0125 14.2642 13.7278 14.84 12.4292C15.4116 11.14 15.8222 9.78359 15.8222 8.51861L15.8222 8.51772C15.8199 6.59027 15.0512 4.74283 13.6853 3.38052C12.4974 2.19561 10.942 1.46184 9.28666 1.28936ZM11.0756 8.51794C11.0749 9.18839 10.8076 9.83157 10.3317 10.3062C9.85572 10.781 9.20995 11.0484 8.53599 11.0491L11.0756 8.51794Z" stroke="#fff" stroke-width="1.5"/>
                            </svg>
                            Смотреть на карте 
                        </div>
                    </a>
                    <span>Для быстрого <br class="main-page-map-button-br"> и удобного поиска акций</span>
                </div>
            </div>
        </div>
    </div>
    @if (count($eventsToday) !== 0)
    <div class="row">
    <div class="oh container-fluid">
        <div class="container minus-15">
            <div class="title-more md-margin">
                <div class="title-more__title title-today">
                    Новые акции
                    <span class="title-more__all">{{ $eventsTodayCount }} {{ pular($eventsTodayCount, ['акция', 'акции', 'акций']) }}</span>
                </div>
            </div>
            <div>
                <div class="title-more__container">
                    <div class="title-more__desc">Не откладывай на завтра</div>
                    <div class="title-more__view"><a
                                href="{{ route('frontend.event.index', ['label_id' => 1]) }}">Показать
                            еще</a></div>
                </div>
            </div>
            <div class="owl-carousel events-block gallery_owl">
                @foreach($eventsToday as $event)
                    <div>
                        <div class="events-block__image">
                            <a href="{{ route('frontend.event.show', $event) }}">
                                <div class="events-block__empty"></div>
                                <div class="animation-block"></div>
                            </a>
                            <img src="{{ $event->image_url }}" alt="{{$event->name}}"/>
                            @if($event->favorite)
                                <div class="events-block__cool">
                                    <img src="/images/icons/success.svg"/> Выбор редакции
                                </div>
                            @endif
                            <div class="events-block__badges">
                                @foreach($event->labels as $label)
                                    <div class="events-block__badges-group">
                                        <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                        {{ $label->name }}
                                    </div>
                                @endforeach
                            </div>
                            <bookmark :event="{{ json_encode($event->only('slug')) }}"
                                      :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false) }}"></bookmark>
                        </div>
                        <div class="events-block__title">
                            <a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a>
                        </div>
                        @if($event->tags->count() > 0)
                            <a href="{{ route('frontend.city.event.tag.show', $event->tags[0]) }}"
                                class="events-block__group-a">
                                <span class="events-block__group">{{ $event->tags[0]->name }}</span>
                            </a>
                        @endif
                        <div class="events-block__text-desc">
                            <a href="{{ route('frontend.company.show', $event->company) }}">{{ $event->company->name }}</a>
                        </div>
                        <div class="events-block__text-desc">
                            @if($event->status == 'active')
                                Дата окончания: {{$event->end != null ? $event->end->locale('ru')->isoFormat('D MMMM YYYY') : 'Бессрочная'}}
                            @elseif($event->status == 'before')
                                Дата начала: {{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                            @elseif($event->status == 'after')
                                Завершено
                            @endif
                        </div>
                        <div class="events-block__text-icons">
                            <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                            <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                            <img src="/images/icons/eye.svg"/> {{ $event->views }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="container">
                <div class="col-md-12 bnp">
                <a class="show-more-button-mob"
                   href="{{ route('frontend.event.index', ['label_id' => 1]) }}">
                    <button>Показать еще</button>
                </a>
            </div>
            </div>
        </div>
    </div>
    </div>
    @endif
    @if (count($eventsFavorite) !== 0)
    <div class="row">
    <div class="oh container-fluid">
        <div class="container minus-15">
            <div class="title-more">
                <div class="title-more__title title-index">
                    Рекомендуемые акции
                    <span class="title-more__all">{{ $eventsFavoriteCount }} {{ pular($eventsFavoriteCount, ['акция', 'акции', 'акций']) }}</span>
                </div>
            </div>
            <div>
                <div class="title-more__container">
                    <div class="title-more__desc">То, на что мы обратили свое внимание</div>
                    <div class="title-more__view"><a href="{{ route('frontend.event.index', ['favorite' => 1]) }}">Показать
                            еще</a></div>
                </div>
            </div>
            <div class="owl-carousel events-block gallery_owl">
                @foreach($eventsFavorite as $event)
                    <div>
                        <div class="events-block__image">
                            <a href="{{ route('frontend.event.show', $event) }}">
                                <div class="events-block__empty"></div>
                                <div class="animation-block"></div>
                            </a>
                            <img src="{{ $event->image_url }}" alt="{{$event->name}}"/>
                            @if($event->favorite)
                                <div class="events-block__cool">
                                    <img src="/images/icons/success.svg"/> Выбор редакции
                                </div>
                            @endif
                            <div class="events-block__badges">
                                @foreach($event->labels as $label)
                                    <div class="events-block__badges-group">
                                        <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                        {{ $label->name }}
                                    </div>
                                @endforeach
                            </div>
                            <bookmark :event="{{ json_encode($event->only('slug')) }}"
                                      :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false) }}"></bookmark>
                        </div>
                        <div class="events-block__title">
                            <a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a>
                        </div>
                         @if($event->tags->count() > 0)
                            <a href="{{ route('frontend.city.event.tag.show', $event->tags[0]) }}"
                                class="events-block__group-a">
                                <span class="events-block__group">{{ $event->tags[0]->name }}</span>
                            </a>
                        @endif
                        <div class="events-block__text-desc">
                            <a href="{{ route('frontend.company.show', $event->company) }}">{{ $event->company->name }}</a>
                        </div>
                        <div class="events-block__text-desc">
                            @if($event->status == 'active')
                                Дата окончания: {{$event->end != null ? $event->end->locale('ru')->isoFormat('D MMMM YYYY') : 'Бессрочная'}}
                            @elseif($event->status == 'before')
                                Дата начала: {{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                            @elseif($event->status == 'after')
                                Завершено
                            @endif
                        </div>
                        <div class="events-block__text-icons">
                            <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                            <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                            <img src="/images/icons/eye.svg"/> {{ $event->views }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="container">
                <div class="col-md-12 bnp">
                <a class="show-more-button-mob" href="{{ route('frontend.event.index', ['favorite' => 1]) }}">
                    <button>Показать еще</button>
                </a>
            </div>
                
            </div>
        </div>
    </div>
    </div>
    @endif
    @if (count($eventsStar) !== 0)
    <div class="row">
    <div class="oh container-fluid">
        <div class="container">
            <div class="title-more">
                <div class="title-more__title title-index">
                    Акции с лучшими оценками
                    <span class="title-more__all">{{ $eventsStarCount }} {{ pular($eventsStarCount, ['акция', 'акции', 'акций']) }}</span>
                </div>
            </div>
            <div>
                <div class="title-more__container">
                    <div class="title-more__desc">Основываясь на положительных отзывах пользователей портала</div>
                    <div class="title-more__view"><a
                                href="{{ route('frontend.event.index', ['sort-raiting' => 'desc']) }}">Показать еще</a>
                    </div>
                </div>
            </div>
            <div class="owl-carousel events-block gallery_owl">
                @foreach($eventsStar as $event)
                    <div>
                        <div class="events-block__image">
                            <a href="{{ route('frontend.event.show', $event) }}">
                                <div class="events-block__empty"></div>
                                <div class="animation-block"></div>
                            </a>
                            <img src="{{ $event->image_url }}" alt="{{$event->name}}"/>
                            @if($event->favorite)
                                <div class="events-block__cool">
                                    <img src="/images/icons/success.svg"/> Выбор редакции
                                </div>
                            @endif
                            <div class="events-block__badges">
                                @foreach($event->labels as $label)
                                    <div class="events-block__badges-group">
                                        <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                        {{ $label->name }}
                                    </div>
                                @endforeach
                            </div>
                            <bookmark :event="{{ json_encode($event->only('slug')) }}"
                                      :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false) }}"></bookmark>
                        </div>
                        <div class="events-block__title">
                            <a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a>
                        </div>
                         @if($event->tags->count() > 0)
                            <a href="{{ route('frontend.city.event.tag.show', $event->tags[0]) }}"
                                class="events-block__group-a">
                                <span class="events-block__group">{{ $event->tags[0]->name }}</span>
                            </a>
                        @endif
                        <div class="events-block__text-desc">
                            <a href="{{ route('frontend.company.show', $event->company) }}">{{ $event->company->name }}</a>
                        </div>
                        <div class="events-block__text-desc">
                            @if($event->status == 'active')
                                Дата окончания: {{$event->end != null ? $event->end->locale('ru')->isoFormat('D MMMM YYYY') : 'Бессрочная'}}
                            @elseif($event->status == 'before')
                                Дата начала: {{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                            @elseif($event->status == 'after')
                                Завершено
                            @endif
                        </div>
                        <div class="events-block__text-icons">
                            <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                            <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                            <img src="/images/icons/eye.svg"/> {{ $event->views }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="container">
                <div class="col-md-12 bnp">
                <a class="show-more-button-mob" href="{{ route('frontend.event.index', ['sort-raiting' => 'desc']) }}">
                    <button>Показать еще</button>
                </a>
            </div>
            </div>
        </div>
    </div>
    </div>
    @endif
    @if (count($eventsPopular) !== 0)
    <div class="row">
    <div class="oh container-fluid">
        <div class="container">
            <div class="title-more">
                <div class="title-more__title title-index">
                    Популярные акции
                    <span class="title-more__all">{{ $eventsPopularCount }} {{ pular($eventsPopularCount, ['акция', 'акции', 'акций']) }}</span>
                </div>
            </div>
            <div>
                <div class="title-more__container">
                    <div class="title-more__desc">Мы выбрали для вас популярные акции на текущий день</div>
                    <div class="title-more__view"><a
                                href="{{ route('frontend.event.index', ['sort-views' => 'desc']) }}">Показать еще</a>
                    </div>
                </div>
            </div>
            <div class="owl-carousel events-block gallery_owl">
                @foreach($eventsPopular as $event)
                    <div>
                        <div class="events-block__image">
                            <a href="{{ route('frontend.event.show', $event) }}">
                                <div class="events-block__empty"></div>
                                <div class="animation-block"></div>
                            </a>
                            <img src="{{ $event->image_url }}" alt="{{$event->name}}"/>
                            @if($event->favorite)
                                <div class="events-block__cool">
                                    <img src="/images/icons/success.svg"/> Выбор редакции
                                </div>
                            @endif
                            <div class="events-block__badges">
                                @foreach($event->labels as $label)
                                    <div class="events-block__badges-group">
                                        <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                        {{ $label->name }}
                                    </div>
                                @endforeach
                            </div>
                            <bookmark :event="{{ json_encode($event->only('slug')) }}"
                                      :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false) }}"></bookmark>
                        </div>
                        <div class="events-block__title">
                            <a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a>
                        </div>
                         @if($event->tags->count() > 0)
                            <a href="{{ route('frontend.city.event.tag.show', $event->tags[0]) }}"
                                class="events-block__group-a">
                                <span class="events-block__group">{{ $event->tags[0]->name }}</span>
                            </a>
                        @endif
                        <div class="events-block__text-desc">
                            <a href="{{ route('frontend.company.show', $event->company) }}">{{ $event->company->name }}</a>
                        </div>
                        <div class="events-block__text-desc">
                            @if($event->status == 'active')
                                Дата окончания: {{$event->end != null ? $event->end->locale('ru')->isoFormat('D MMMM YYYY') : 'Бессрочная'}}
                            @elseif($event->status == 'before')
                                Дата начала: {{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                            @elseif($event->status == 'after')
                                Завершено
                            @endif
                        </div>
                        <div class="events-block__text-icons">
                            <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                            <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                            <img src="/images/icons/eye.svg"/> {{ $event->views }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="container">
                <div class="col-md-12 bnp">
                <a class="show-more-button-mob" href="{{ route('frontend.event.index', ['sort-views' => 'desc']) }}">
                    <button>Показать еще</button>
                </a>
            </div>
            </div>
        </div>
    </div>
    </div>
    @endif
    @if (count($eventsAll) !== 0)
    <div class="row">
    <div class="oh container-fluid">
        <div class="container minus-15">
            <div class="title-more">
                <div class="title-more__title title-index">
                    Все акции города
                    <span class="title-more__all">{{ $eventsAllCount }} {{ pular($eventsAllCount, ['акция', 'акции', 'акций']) }}</span>
                </div>
            </div>
            <div>
                <div class="title-more__container">
                    <div class="title-more__desc">Вы точно найдете здесь что то интересное</div>
                    <div class="title-more__view"><a href="{{ route('frontend.event.index') }}">Показать еще</a></div>
                </div>
            </div>
            <div class="owl-carousel events-block gallery_owl">
                @foreach($eventsAll as $event)
                    <div>
                        <div class="events-block__image">
                            <a href="{{ route('frontend.event.show', $event) }}">
                                <div class="events-block__empty"></div>
                                <div class="animation-block"></div>
                            </a>
                            <img src="{{ $event->image_url }}" alt="{{$event->name}}"/>
                            @if($event->favorite)
                                <div class="events-block__cool">
                                    <img src="/images/icons/success.svg"/> Выбор редакции
                                </div>
                            @endif
                            <div class="events-block__badges">
                                @foreach($event->labels as $label)
                                    <div class="events-block__badges-group">
                                        <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                        {{ $label->name }}
                                    </div>
                                @endforeach
                            </div>
                            <bookmark :event="{{ json_encode($event->only('slug')) }}"
                                      :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false) }}"></bookmark>
                        </div>
                        <div class="events-block__title">
                            <a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a>
                        </div>
                         @if($event->tags->count() > 0)
                            <a href="{{ route('frontend.city.event.tag.show', $event->tags[0]) }}"
                                class="events-block__group-a">
                                <span class="events-block__group">{{ $event->tags[0]->name }}</span>
                            </a>
                        @endif
                        <div class="events-block__text-desc">
                            <a href="{{ route('frontend.company.show', $event->company) }}">{{ $event->company->name }}</a>
                        </div>
                        <div class="events-block__text-desc">
                            @if($event->status == 'active')
                                Дата окончания: {{$event->end != null ? $event->end->locale('ru')->isoFormat('D MMMM YYYY') : 'Бессрочная'}}
                            @elseif($event->status == 'before')
                                Дата начала: {{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                            @elseif($event->status == 'after')
                                Завершено
                            @endif
                        </div>
                        <div class="events-block__text-icons">
                            <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                            <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                            <img src="/images/icons/eye.svg"/> {{ $event->views }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="container">
                <div class="col-md-12 bnp">
                <a class="show-more-button-mob" href="{{ route('frontend.event.index') }}">
                    <button>Показать еще</button>
                </a>
            </div>
            </div>
        </div>
    </div>
    </div>
    @endif
    @include('frontend.includes.adv.horizontal_banner_main_page', ['item' => $mainBannerPlace])

@endsection
@push('after-scripts')
    <script>
        owl_banner_main_mobile = $('#owl-banner-main-mobile');
        owl_banner_main = $('#owl-banner-main');
        responsiveBanner = function () {
            if ($(window).width() <= '600'){
                owl_banner_main.hide();
                owl_banner_main_mobile.show();
            } else {
                owl_banner_main.show();
                owl_banner_main_mobile.hide();
            }
        }
        $(window).on('load resize',responsiveBanner);
    </script>
@endpush
