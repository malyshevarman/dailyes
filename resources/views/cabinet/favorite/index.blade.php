@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Избранное</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Избранное
    </div>
    <div class="lk-body__trigger">
        <div data="1" class="lk-body__trigger-url active">Акции<span>{{ $events->count() }}</span></div>
        <div data="2" class="lk-body__trigger-url">Компании<span>{{ $companies->count() }}</span></div>
    </div>
    <div class="lk-body__row">
        <div class="container-fluid">
            <div class="trigger_events">
                <div class="row">


                    @if($events->count() == 0)

                    <div class="col-md-12">
                        <div class="lk-body__text">
                            <div class="info_block">
                                <div>

                                    В данный момент, <br>
                                    список избранных акций пуст
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif

                    @foreach($events as $event)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="lk-body__row-img">
                                <a href="{{ route('frontend.event.show', $event) }}">
                                    <div class="events-block__empty"></div>
                                </a>
                                <img src="{{ $event->image_url }}"/>
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
                            <div class="lk-body__row-title">
                                <a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a>
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
                                <span>
                                    @if($event->status == 'active')
                                        Дата окончания: {{$event->end != null ? $event->end->locale('ru')->isoFormat('D MMMM YYYY') : 'Бессрочная'}}
                                    @elseif($event->status == 'before')
                                        Дата начала: {{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                                    @elseif($event->status == 'after')
                                        Завершено
                                    @endif
                                </span>
                            </div>
                            <div class="lk-body__row-icons">
                                <div class="v-align">
                                    <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                                    <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                                    <img src="/images/icons/eye.svg"/> {{ $event->views }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="pagination-panel">
                                {{ $events->links('frontend.includes.pagination', ['paginator' => $events]) }}
                            </div>
                        </div>

                </div>
            </div>
            <div class="trigger_company">
                <div class="row">


                    @if($companies->count() == 0)

                        <div class="col-md-12">
                            <div class="lk-body__text">
                                <div class="info_block">
                                    <div>

                                        В данный момент, <br>
                                        список избранных компаний пуст
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif

                    @foreach($companies as $company)
                        <div class="col-lg-3 col-md-6 col-sm-6 ">
                            <div class="search-panel__company-block">
                                <div class="search-panel__company-block-img"
                                     style="background-image: url('{{ $company->image_url }}');"></div>
                                <a href="{{ route('frontend.company.show', $company) }}">
                                    <div class="events-block__empty"></div>
                                </a>
                                @if($company->tags->count() > 0)
                                    <div class="search-panel__company-group">{{ $company->tags[0]->name }}</div>
                                @endif
                                <company-bookmark :company="{{ json_encode($company->only('slug')) }}"
                                          :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_companies->contains('id', $company->id) : false) }}"></company-bookmark>
                                <div class="search-panel__company-text">
                                    <div class="search-panel__company-title">{{ $company->name }}</div>
                                    <div class="search-panel__company-place">{{ $company->addresses->count() > 0 ? $company->addresses[0]->address : '' }} {{ $company->addresses->count() > 1 ? ' и еще ' . ($company->addresses->count() - 1) : '' }}
                                    </div>
                                    <div class="search-panel__company-badges">
                                        <img src="/images/icons/thumb-up-black.svg">
                                        <span>{{ $company->rec }}</span>
                                        <img class="star" src="/images/icons/star.svg">
                                        <span>{{ round($company->star, 1) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="pagination-panel">
                                {{ $companies->links('frontend.includes.pagination', ['paginator' => $companies]) }}
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
