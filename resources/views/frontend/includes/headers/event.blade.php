@section('header-id', 'header-min-item')

@if(empty($event))
    @section('header-style', "background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/images/background.png'); background-size: cover; background-position: center center;")
@else
    @section('header-style', "background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('$event->background_url'); background-size: cover; background-position: center center;")
@endif

@section('header-class', "full-height")

<div class="container mw">
    <div class="top-block">
        <div class="top-block__breadcrumb">
            <ul>
                <li><a href="{{ route('frontend.city.show') }}">Главная</a></li>
                <li><a href="{{ route('frontend.event.index') }}">Акции</a></li>
                <li>{{ $event->name }}</li>
            </ul>
        </div>
        <div class="top-block__top-badges">
            <div class="v-align">
                @if($event->favorite)
                    <div class="choice"><img src="/images/icons/choice-red.svg"> Выбор редакции</div>
                @endif
                @foreach($event->labels as $label)
                    <div class="badge_f">
                        <div class="badge_f-image"><img src="{{ $label->icon_url }}"></div>
                        {{ $label->name }}
                    </div>
                @endforeach
                <div class="stat">
                    <img src="/images/icons/thumb-up-white.svg"/> {{ $event->rec }}% <img
                            src="/images/icons/star-white.svg"/> {{ round($event->star, 1) }} <img
                            src="/images/icons/eye-white.svg"/> {{ $event->views }}
                </div>
            </div>
        </div>
        <div class="top-block__title">
            <h1>{{ $event->name }}</h1>
        </div>
        <div class="top-block__descfull">
            {!! nl2br(e($event->summary)) !!}
        </div>
        @if($event->tags->count() > 0)
            @foreach($event->tags as $tag)
                <div class="top-block__desc">
                    {{ $tag->name }}
                </div>
            @endforeach
        @endif
        @include('frontend.includes.top-block-soc')
        <div class="top-block__ui">
            <div class="v-align">
                <div class="top-block__ui-stat">
                    @if($event->status == 'active')
                        @if(!is_null($event->end))
                        <div>До окончания осталось:
                            <span>{{ $event->end->locale('ru')->diffForHumans(null, true) }}</span>
                        </div>
                      
                        @endif
                    @elseif($event->status == 'before')
                        <div>Дата начала: <span>{{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}</span></div>
                    @elseif($event->status == 'after')
                        <div>Завершено: <span>{{ $event->end->locale('ru')->isoFormat('D MMMM YYYY') }}</span></div>
                    @endif
                        @if($event->status != 'after')
                    <div>За сегодня просмотрели: <span>{{ $event->views_today->count ?? 0 }} {{pular($event->views_today->count ?? 0, ['человек', 'человека', 'человек'])}}</span>
                    </div>
                        @endif
                </div>
                <div class="top-block__ui-stars">
                    <span>Поставьте оценку</span>
                    <div class="star-rating">
                        <div class="star-rating__wrap">
                            <rating-header :user-rating="{{ json_encode($event->user_rating) }}"></rating-header>
                        </div>
                    </div>
                </div>
                <div class="top-block__ui-rec">
                    <span>Рекомендовать</span>
                    <div class="thumb-rating">
                        <div class="thumb-rating__wrap">
                            <recommendation-header
                                    :user-recommendation="{{ json_encode($event->user_recommendation) }}"></recommendation-header>
                        </div>
                    </div>
                </div>
                <div class="top-block__ui-more">
                    <span>&nbsp;</span>
                    <div class="top-block__ui-group">
                        <bookmark :event="{{ json_encode($event->only('slug')) }}"
                                  :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false) }}"></bookmark>
                        <div class="events-block__badges-sad" title="Пожаловаться"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-block__soc-mob">
            @include('frontend.includes.soc-mobile')
        </div>
        <div class="top-block__nav">
            <div class="v-align">
                <div class="top-block__nav-date">
                    <img src="/images/icons/calendar-white.svg"/>
                    @if(!is_null($event->end))
                        С {{ $event->start->locale('ru')->isoFormat('D MMMM') }}
                        до {{ $event->end->locale('ru')->isoFormat('D MMMM') }}
                    @else
                        Бессрочная
                    @endif
                </div>
                <div data-toggle="modal" data-target="#map-modal" class="top-block__nav-map">
                    <svg style="margin-right: 8px;" width="20" height="25" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.12534 10.6221C7.54271 10.9003 8.03357 11.0489 8.5359 11.0491L7.12534 10.6221ZM7.12534 10.6221C6.70778 10.3438 6.38263 9.9485 6.1907 9.48634M7.12534 10.6221L6.1907 9.48634M6.1907 9.48634C5.99878 9.0242 5.94859 8.51578 6.0464 8.02531M6.1907 9.48634L6.0464 8.02531M6.0464 8.02531C6.14422 7.53483 6.38572 7.08402 6.74065 6.73M6.0464 8.02531L6.74065 6.73M6.74065 6.73C7.09561 6.37597 7.54809 6.13464 8.04097 6.03686M6.74065 6.73L8.04097 6.03686M8.04097 6.03686C8.53386 5.93907 9.04474 5.98928 9.50892 6.18105M8.04097 6.03686L9.50892 6.18105M9.50892 6.18105C9.97308 6.37281 10.3695 6.69741 10.6482 7.11352M9.50892 6.18105L10.6482 7.11352M10.6482 7.11352C10.9268 7.52939 11.0755 8.01807 11.0756 8.51785L10.6482 7.11352ZM9.28666 1.28936V1.24923L8.5359 1.25C6.60501 1.25197 4.75335 2.0178 3.3873 3.38008C2.02118 4.74243 1.25231 6.59006 1.25 8.51772V8.51861C1.25 9.78359 1.66062 11.14 2.23223 12.4292C2.80797 13.7278 3.57173 15.0125 4.3327 16.1484C5.8547 18.4205 7.40592 20.157 7.54016 20.3065L7.54133 20.3078C7.667 20.4471 7.82053 20.5584 7.99191 20.6346C8.16326 20.7107 8.34867 20.75 8.53611 20.75C8.72356 20.75 8.90896 20.7107 9.0803 20.6346C9.25168 20.5584 9.40521 20.4471 9.53088 20.3078L9.53205 20.3065C9.66629 20.157 11.2175 18.4205 12.7395 16.1484C13.5005 15.0125 14.2642 13.7278 14.84 12.4292C15.4116 11.14 15.8222 9.78359 15.8222 8.51861L15.8222 8.51772C15.8199 6.59027 15.0512 4.74283 13.6853 3.38052C12.4974 2.19561 10.942 1.46184 9.28666 1.28936ZM11.0756 8.51794C11.0749 9.18839 10.8076 9.83157 10.3317 10.3062C9.85572 10.781 9.20995 11.0484 8.53599 11.0491L11.0756 8.51794Z" stroke="#fff" stroke-width="1.5"/>
                        </svg> <span>Смотреть адреса проведения акции</span>
                    <div class="count">{{ $event->addresses->count() }}</div>
                </div>
                <div class="top-block__nav-company">
                    <div class="logo">
                        @empty($event->company->icon)
                            {{ $event->company->name }}
                        @else
                            <img src="{{ $event->company->icon_url }}"/>
                        @endempty
                    </div>
                    <a href="{{ route('frontend.company.show', $event->company) }}">
                        <div>Компания этой акции</div>
                        <div><img src="/images/icons/left-arrow.svg"/></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
