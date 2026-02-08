@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Акции</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Акции
    </div>
    <div class="lk-body__trigger">
        <div>
            <div class="lk-body__trigger-url-nohref @if(count(request()->input()) <= 0) active @endif "><a href="{{ route('cabinet.event.index') }}">Активные</a></div>
            <div class="lk-body__trigger-url-nohref @if((boolean) request()->query('moderation')) active @endif "><a href="{{ route('cabinet.event.index', ['moderation' => true]) }}">На модерации</a></div>
            <div class="lk-body__trigger-url-nohref @if((boolean) request()->query('waiting-for-action')) active @endif "><a href="{{ route('cabinet.event.index', ['waiting-for-action' => true]) }}">Ждут действия</a></div>
            <div class="lk-body__trigger-url-nohref @if((boolean) request()->query('completed')) active @endif "><a href="{{ route('cabinet.event.index', ['completed' => true]) }}">Завершенные</a></div>
            <div class="lk-body__trigger-url-nohref @if((boolean) request()->query('rejected')) active @endif "><a href="{{ route('cabinet.event.index', ['rejected' => true]) }}">Отклоненные</a></div>
        </div>
    </div>
    @if($events->count() == 0 )

        <div class="lk-body__nav">
            <a href="{{ route('cabinet.event.create') }}">
                <div class="lk-body__nav-button v-align"><img src="/images/icons/round-add-button.svg"/>Добавить
                    акцию
                </div>
            </a>
        </div>
        <div style="margin-left: 40px;"><a href="/placement-rules" style="text-decoration: none;font-size: 13px;" @click.prevent="$bus.$emit('showrules')">Правила размещения</a></div>
        <div class="lk-body__text">


            <div class="info_block">
                <div>


                    @if ((boolean) request()->query('moderation'))


                        В данный момент, <br>
                        у вас нет акций, находящихся на модерации


                    @elseif ((boolean) request()->query('rejected'))




                        В данный момент, <br>
                     у вас нет акций, отклонённых модератором

                    @elseif ((boolean) request()->query('completed'))

                        В данный момент, <br>
                        у вас нет завершённых акций

                     @elseif ((boolean) request()->query('waiting-for-action'))

                        В данный момент, <br>
                        у вас нет неактивных акций

                    @else

                        В данный момент, <br>
                        у вас нет активных акций
                    @endif




                </div>
            </div>


        </div>

    @else
        <div class="lk-body__nav">
            <a href="{{ route('cabinet.event.create') }}">
                <div class="lk-body__nav-button v-align"><img src="/images/icons/round-add-button.svg"/>Добавить
                    акцию
                </div>
            </a>
        </div>
        <div style="margin-left: 40px;"><a href="/placement-rules" style="text-decoration: none;font-size: 13px;" @click.prevent="$bus.$emit('showrules')">Правила размещения</a></div>
        <div class="lk-body__row">
            <div class="container-fluid">
                <div class="trigger_events">
                    <div class="row">
                        @foreach($events as $event)
                        <div class="col-xl-3 col-lg-4 col-md-6">

                            <div style="margin-bottom: 80px;">
                                {{--<div class="cabinetbanner">
                                    <div class="textone">Хотите увеличить просмотры?</div>
                                    <div class="textxtwo">Выделите акцию в поиске</div>
                                    <div class="line"><a href="{{ route('cabinet.banner.index') }}">Подключить</a><div>Экономия 50%</div></div>
                                </div>--}}

                                <div class="lk-body__row-img" style="@if((boolean) request()->query('completed') || 
                                                                        (boolean) request()->query('moderation') || 
                                                                        (boolean) request()->query('waiting-for-action'))background-color: rgba(255,255,255,.2);@endif">
                                    @if ((boolean) request()->query('moderation') || 
                                    (boolean) request()->query('completed') || 
                                    (boolean) request()->query('waiting-for-action'))
                                    <div class="events-block__empty d-flex justify-content-center align-items-center">
                                        @if ((boolean) request()->query('moderation'))
                                        <span class="events-block__moderation-status">
                                        Акция проверяется<br> модератором
                                        </span>
                                        @elseif ((boolean) request()->query('completed'))

                                            @if ($event->status !== 'after')
                                                <!-- <span class="events-block__moderation-status">
                                                Акция остановлена
                                                </span> -->
                                            @else
                                                <span class="events-block__moderation-status">
                                                Акция завершена
                                                </span>
                                            @endif
                                        @elseif ((boolean) request()->query('waiting-for-action'))
                                                <span class="events-block__moderation-status">
                                                Акция остановлена
                                                </span>
                                        @endif
                                    </div>
                                    @else
                                    <a href="{{ route('frontend.event.show', $event) }}">
                                        <div class="events-block__empty"></div>
                                    </a>
                                    @endif
                                <img src="{{ $event->image_url }}"/>
                                    {{--@if($event->favorite)
                                        <div class="events-block__cool">
                                            <img src="/images/icons/success.svg"/> Выбор редакции
                                        </div>
                                    @endif--}}
                                    <div class="events-block__badges">
                                        @foreach($event->labels as $label)
                                            <div class="events-block__badges-group">
                                                <div class="miw"><img src="{{ $label->icon_url }}"/></div>
                                                {{ $label->name }}
                                            </div>
                                        @endforeach
                                        
                                    </div>
                                    <div class="search-panel__company-text">
                                        <div class="search-panel__company-badges">
                                            @if ((boolean) request()->query('completed'))
                                                <a title="Редактировать" href="{{ route('cabinet.event.edit', $event) }}">
                                                    <i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a title="Статистика" href="{{ route('cabinet.event.stat', $event) }}">
                                                    <i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-chart-line"></i>
                                                </a>
                                            @elseif ((boolean) request()->query('moderation') || 
                                            (boolean) request()->query('rejected'))
                                            <a title="Редактировать" href="{{ route('cabinet.event.edit', $event) }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-pencil-alt"></i> </a>
                                            @elseif ((boolean) request()->query('waiting-for-action'))
                                            <a title="Опубликовать" href="{{ route('api.cabinet.event.status', $event->id) }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-toggle-on"></i></a>
                                            <a title="Редактировать" href="{{ route('cabinet.event.edit', $event) }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-pencil-alt"></i> </a>
                                            <a title="Статистика" href="{{ route('cabinet.event.stat', $event) }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-chart-line"></i></a>
                                            @elseif (!(boolean) request()->query('completed') && 
                                            !(boolean) request()->query('moderation') && 
                                            !(boolean) request()->query('rejected') && 
                                            !(boolean) request()->query('waiting-for-action'))
                                            <a title="Снять с публикации" onclick="return confirm('Вы уверены что хотите снять с публикации?');" href="{{ route('api.cabinet.event.status', $event->id) }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-toggle-on"></i></a>
                                            <a title="Редактировать" href="{{ route('cabinet.event.edit', $event) }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-pencil-alt"></i> </a>
                                            <a title="Статистика" href="{{ route('cabinet.event.stat', $event) }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-chart-line"></i></a>
                                            {{--<a title="Увеличить просмотры" href="{{ route('cabinet.banner.index') }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-arrow-up"></i></a>--}}
                                            @endif
                                        </div>
                                    </div>
                                    <!-- <bookmark :event="{{ json_encode($event->only('slug')) }}"
                                              :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false) }}"></bookmark> -->
                                </div>
                                <div class="lk-body__row-title">
                                    <a href="{{ route('cabinet.event.edit', $event) }}">{{ $event->name }}</a>
                                </div>
                                @if($event->tags->count() > 0)
                                    <span class="lk-body__row-badge">
                                        {{ $event->tags[0]->name }}
                                    </span>
                                @endif
                                <div class="lk-body__row-text">
                                    <span>{{ $event->company->name }}</span>
                                </div>
                                <div class="events-block__text-desc">
                                    @if($event->status == 'active')
                                        Дата окончания: {{is_null($event->end) ? "бессрочная" : $event->end->locale('ru')->isoFormat('D MMMM YYYY') }}
                                    @elseif($event->status == 'before')
                                        Дата начала: {{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                                    @elseif($event->status == 'after')
                                        Завершено
                                    @endif
                                </div>
                                <div class="events-block__text-icons v-align">
                                    <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                                    <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                                    <img src="/images/icons/eye.svg"/> {{ $event->views }}
                                </div>

                            </div>
                        </div>
                        @endforeach
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="pagination-panel">
                                @if((boolean) request()->query('completed'))
                                    {{ $events->appends(['completed' => 1])->links('frontend.includes.pagination', ['paginator' => $events]) }}
                                @elseif ((boolean) request()->query('moderation'))
                                    {{ $events->appends(['moderation' => 1])->links('frontend.includes.pagination', ['paginator' => $events]) }}
                                @elseif ((boolean) request()->query('rejected'))
                                    {{ $events->appends(['rejected' => 1])->links('frontend.includes.pagination', ['paginator' => $events]) }}
                                @elseif ((boolean) request()->query('waiting-for-action'))
                                    {{ $events->appends(['waiting-for-action' => 1])->links('frontend.includes.pagination', ['paginator' => $events]) }}
                                @else
                                    {{ $events->links('frontend.includes.pagination', ['paginator' => $events]) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
