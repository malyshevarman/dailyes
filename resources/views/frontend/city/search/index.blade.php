@extends('frontend.layouts.app')

@section('header')
    @include('frontend.includes.headers.search')
@endsection

@push('after-scripts')
@endpush

@section('title', 'Результаты поиска')
@section('description', 'Результаты поиска')

@section('content')
    <!-- <div class="oh container-fluid"> -->
        <!-- <div class="container minus-15"> -->
            <!-- <div class="row"> -->
                <!-- <div class="col-md-12"> -->
                    @if (($events->count() == 0) && ($companies->count() == 0))
                    <div class="oh container-fluid">
                        <div class="container minus-15">
                            <div class="search-panel__title">
                                <div class="info_block ">
                                    <div>К сожалению, по вашему запросу ничего не найдено</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($events->count() > 0)
                    <div class="oh container-fluid">
                        <div class="container minus-15">
                            <div class="search-panel__title">
                                Найдено акций: <span>{{ $eventsCount }}</span>
                            </div>
                            <div class="title-more__container">
                                <div class="title-more__view">
                                    <a
                                        href="{{ route('frontend.event.index') }}">Показать
                                    еще</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="oh container-fluid">
                            <div class="container minus-15">
                                <div class="search-panel__row events-block">
                                    <!-- <div class="row bootfix-row"> -->
                                        <div class="owl-carousel events-block gallery_owl">
                                        @foreach($events as $event)
                                        <div class="row">
                                        <div class="oh container-fluid">
                                            <div class="events-block__image">
                                                <a href="{{ route('frontend.event.show', $event) }}"><img
                                                            src="{{ $event->image_url }}" alt="{{$event->name}}"/><div class="animation-block"></div></a>
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
                                                <bookmark :event="{{ json_encode($event->only('slug')) }}" :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_events->contains('id', $event->id) : false) }}"></bookmark>
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
                                            <div class="events-block__text-icons v-align">
                                                <img src="/images/icons/thumb-up-blue.svg"/> {{ $event->rec }}%
                                                <img src="/images/icons/star-blue.svg"/> {{ round($event->star, 1) }}
                                                <img src="/images/icons/eye.svg"/> {{ $event->views }}
                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
                                        </div>
                                        <div class="col-md-12 text-center bootfix-col">
                                            <a class="search-panel__row-more event">Еще результаты по акциям <img src="/images/icons/more-arrow.svg" /><img src="/images/icons/more-arrow-blue.svg" /></a>
                                        </div>
                                        <div class="container">
                                            <div class="col-md-12 bnp">
                                            <a class="show-more-button-mob" href="{{ route('frontend.event.index') }}">
                                                <button>Показать еще</button>
                                            </a>
                                        </div>
                                        </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($companies->count() > 0)
                    <div class="oh container-fluid">
                        <div class="container minus-15">
                            <div class="search-panel__title">
                                Найдено компаний: <span>{{ $companiesCount }}</span>
                            </div>
                            <div class="title-more__container">
                                    <div class="title-more__view"><a
                                                href="{{ route('frontend.company.index') }}">Показать
                                            еще</a></div>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="oh container-fluid">
                            <div class="container minus-15">
                                <div class="search-panel__row company-block">
                                    <!-- <div class="row bootfix-row"> -->
                                        <div class="owl-carousel events-block gallery_owl_company">
                                        @foreach($companies as $company)
                                        <div class="row">
                                        <div class="oh container-fluid">
                                            <div class="search-panel__company-block">
                                                <img src="{{ $company->image_url }}" alt="{{$company->name}}"/>
                                                <a href="{{ route('frontend.company.show', $company) }}">
                                                    <div class="events-block__empty"></div>
                                                    <div class="animation-block"></div>
                                                </a>
                                                @if($company->tags->count() > 0)
                                                    <a href="{{ route('frontend.city.company.tag.show', $company->tags[0]) }}"
                                                        class="events-block__group-a">
                                                        <div class="search-panel__company-group">{{ $company->tags[0]->name }}</div>
                                                    </a>
                                                @endif
                                                <company-bookmark :company="{{ json_encode($company->only('slug')) }}" :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_companies->contains('id', $company->id) : false) }}"></company-bookmark>
                                                @php
                                                foreach ($company->addresses as $company_address)
                                                    if ($company_address->city_id == $city->id) {
                                                        $current_address = $company_address->address;
                                                    }
                                                @endphp
                                                <div class="search-panel__company-text">
                                                    <div class="search-panel__company-title">{{ $company->name }}</div>
                                                    <div class="search-panel__company-place">{{ $company->addresses->count() > 0 ? (isset($current_address) ? $current_address : $company->addresses[0]->address) : '' }}{{ $company->addresses->count() > 1 ? ' и еще ' : ''}} <span>{{ $company->addresses->count() > 1 ? ($company->addresses->count() - 1). ' ' . pular($company->addresses->count(), ['адрес', 'адреса', 'адресов']) : '' }}</span></div>
                                                    <div class="search-panel__company-badges">
                                                        <img style="display:inline-block;width:12px;" src="/images/icons/thumb-up-black.svg" /> <span>{{ $company->rec }}</span>
                                                        <img style="display:inline-block;width:12px;" class="star" src="/images/icons/star.svg" /> <span>{{ round($company->star, 1) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
                                        </div>
                                        <div class="col-md-12 text-center bootfix-col">
                                            <a class="search-panel__row-more company">Еще результаты по акциям <img src="/images/icons/more-arrow.svg" /><img src="/images/icons/more-arrow-blue.svg" /></a>
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
                    </div>
                    @endif
                <!-- </div> -->
                <div class="oh container-fluid">
        <div class="container minus-15">
                <div class="container seoblock">
                        @include('frontend.includes.seo.search_page')
                </div>
            </div>
        </div>
            <!-- </div> -->
        <!-- </div> -->
    <!-- </div> -->
@endsection
