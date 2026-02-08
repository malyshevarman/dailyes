{{--@section('header-id', 'min-header-wi')

@if(empty($category) && !request('selection'))
    @section('header-style', "background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/images/background.png'); background-size: cover; background-position: center center;")
@elseif (request('selection'))
    @section('header-style', "background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('$selection->background_url'); background-size: cover; background-position: center center;")
@else
    @section('header-style', "background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('$category->background_url'); background-size: cover; background-position: center center;")
@endif

@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.4.2/dist/js/jquery.suggestions.min.js"></script>
    <script>
        var sort_raiting = $('.change-sort-raiting').find('input').val();
        if (sort_raiting <= 2) {
            if (sort_raiting == 1) {
                $('.change-sort-raiting').find('.iup').show();
                $('.change-sort-raiting').addClass('active');
            }
            if (sort_raiting == 2) {
                $('.change-sort-raiting').find('.idown').show();
                $('.change-sort-raiting').find('.iup').hide();
                $('.change-sort-raiting').addClass('active');
            }
        }

        function change_range(num) {
            $("#ex21").bootstrapSlider('setValue', num);
            if (num == 1) {
                $('#range').val('100')
            }
            ;
            if (num == 2) {
                $('#range').val('500')
            }
            ;
            if (num == 3) {
                $('#range').val('1000')
            }
            ;
            if (num == 4) {
                $('#range').val('5000')
            }
            ;
            if (num == 5) {
                $('#range').val('10000')
            }
            ;
        }

        $('#ex21').bind('change', function () {
            var i = $(this).val();
            if (i == 1) {
                $('#range').val('100')
            }
            ;
            if (i == 2) {
                $('#range').val('500')
            }
            ;
            if (i == 3) {
                $('#range').val('1000')
            }
            ;
            if (i == 4) {
                $('#range').val('5000')
            }
            ;
            if (i == 5) {
                $('#range').val('10000')
            }
            ;
        });

        function change_rangemob(num) {
            $("#ex21mob").bootstrapSlider('setValue', num);
            if (num == 1) {
                $('#rangeMob').val('100')
            }
            ;
            if (num == 2) {
                $('#rangeMob').val('500')
            }
            ;
            if (num == 3) {
                $('#rangeMob').val('1000')
            }
            ;
            if (num == 4) {
                $('#rangeMob').val('5000')
            }
            ;
            if (num == 5) {
                $('#rangeMob').val('10000')
            }
            ;
        }

        $('#ex21mob').bind('change', function () {
            var i = $(this).val();
            if (i == 1) {
                $('#rangeMob').val('100')
            }
            ;
            if (i == 2) {
                $('#rangeMob').val('500')
            }
            ;
            if (i == 3) {
                $('#rangeMob').val('1000')
            }
            ;
            if (i == 4) {
                $('#rangeMob').val('5000')
            }
            ;
            if (i == 5) {
                $('#rangeMob').val('10000')
            }
            ;
        });

        var sortRaiting = $('.sort-raiting').val();
        if (sortRaiting.length > 2) {
            $('.sort-raiting').attr('name', 'sort-raiting');
            $('.change-sort-raiting').addClass('active');
            if (sortRaiting == 'asc') {
                $('.sort-raiting').data('sort', 1);
                $('.change-sort-raiting').find('.iup').show();
            }
            if (sortRaiting == 'desc') {
                $('.sort-raiting').data('sort', 2);
                $('.change-sort-raiting').find('.idown').show();
            }
        }
        var sortViews = $('.sort-views').val();
        if (sortViews.length > 2) {
            if (sortViews == 'asc') {
                $('.change-sort-views').addClass('active');
                $('.sort-views').data('sort', 1);
                $('.sort-views').attr('name', 'sort-views');
                $('.change-sort-views').find('.iup').show();
            }
            if (sortViews == 'desc') {
                $('.change-sort-views').addClass('active');
                $('.sort-views').data('sort', 2);
                $('.sort-views').attr('name', 'sort-views');
                $('.change-sort-views').find('.idown').show();
            }
        }

        $('.suggestions-addon').click(function () {
            $('.rangeBlock').hide();
        });
    </script>
@endpush

<div class="container mw">
    <div class="top-block">
        <div class="top-block__breadcrumb">
            <ul>
                <li><a href="/">Главная</a></li>
                @if(empty($category) && !request('selection'))
                    <li>
                        Акции
                    </li>
                @elseif (request('selection'))
                    <li>{{$selection->name}}</li>
                @else
                    <li>
                        <a href="{{ route('frontend.city.event.category.show') }}">Акции</a>
                    </li>
                    <li>Акции категории {{ $category->name }}</li>
                @endif
            </ul>
        </div>
        @if(request()->date) 
        <h1>Акции сегодня</h1>
        @elseif (request()->favorite)
        <h1>Рекомендуемые акции</h1>
        @elseif (Request::input('sort-raiting'))
        <h1>Акции с лучшими оценками</h1>
        @elseif (Request::input('sort-views'))
        <h1>Популярные акции</h1>
        @elseif (Request::input('selection'))
        <h1>{{$selection->name}}</h1>
        @else
        <h1>Акции @if(!empty($category))категории {{ $category->name }}@endif</h1>
        @endif
        @if (Request::input('selection'))
        <div class="top-block__desc">
            {{isset($selection->tile) ? $selection->tile->summary : $selection->slide->summary}}
        </div>
        @else
        <div class="top-block__desc">
            Выберите нужные параметры поиска или напишите название акции или предложения
        </div>
        @endif
        @php
            $sortVariants = collect([
                0 => '',
                1 => 'desc',
                2 => 'asc'
            ]);
            $dataSliderTicks = collect([
                1 => 100,
                2 => 500,
                3 => 1000,
                4 => 5000,
                5 => 10000
            ]);
        @endphp
        @if (empty(Request::input('selection')))
        <div class="search-block">
            <form id="filter_form" action="{{ route('frontend.city.event.category.show', $category) }}">
                <div class="flex-box">
                    <input class="search-block__input filtm" placeholder="Найти акцию или компанию" value="{{ request()->text }}"
                           name="text" type="text"/>
                    <button class="search-block__glass">
                        <img src="/images/icons/glass.svg"/>
                    </button>
                </div>
                <div class="search-block__filter">Фильтр<img class="search-block__filter-img"
                                                             src="/images/icons/filter-open.svg"/></div>
                <div class="search-block__filter-block">
                    <div class="search-block__filter-left">
                        <span class="search-block__filter-left-title">Фильтр по:</span>
                        <ul>
                            <li id="filter_1" class="active">
                                <img src="/images/icons/filter-date.svg"/> Дате <img
                                        class="search-block__filter-left-ri" src="/images/icons/filter-left.svg"/>
                            </li>
                            @if(empty($category))
                            <li id="filter_2">
                                <img src="/images/icons/filter-category.svg"/> Категориям <img
                                        class="search-block__filter-left-ri" src="/images/icons/filter-left.svg"/>
                            </li>
                            @endif
                            <li id="filter_3">
                                <img src="/images/icons/filter-geo.svg"/> Геолокации <img
                                        class="search-block__filter-left-ri" src="/images/icons/filter-left.svg"/>
                            </li>
                        </ul>
                        <span class="search-block__filter-left-title">Сортировать по:</span>
                        
                        <ul>
                            <li class="change-sort-raiting">
                                <input type="hidden"
                                       data-sort="{{ $sortVariants->search(request('sort-raiting') ?? 0) }}"
                                       class="sort-raiting" value="{{ request('sort-raiting') }}"/>
                                <img src="/images/icons/filter-raiting.svg"/> Рейтингу <i
                                        class="fas fa-long-arrow-alt-up iup"></i> <i
                                        class="fas fa-long-arrow-alt-down idown"></i>
                            </li>
                            <li class="change-sort-views">
                                <input type="hidden" data-sort="{{ $sortVariants->search(request('sort-views') ?? 0) }}"
                                       class="sort-views" value="{{ request('sort-views') }}"/>
                                <img src="/images/icons/filter-views.svg"/> Просмотрам <i
                                        class="fas fa-long-arrow-alt-up iup"></i> <i
                                        class="fas fa-long-arrow-alt-down idown"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="search-block__filter-right">
                        <div class="filter_1">
                            <input type="hidden" name="date" class="date-picker" value="{{ request('date') }}"/>
                            <div id="daterangepicker1-container" class="embedded-daterangepicker"></div>
                        </div>
                        <div class="filter_2" data-simplebar="init">
                            <ul>
                                @foreach($categories->flatten()->unique('id')->values()->all() as $categoryItem)
                                    <li>
                                        <input id="check_{{$categoryItem->id}}" type="checkbox" name="categories[]"
                                               value="{{$categoryItem->id}}"
                                               @if(!empty(request('categories')) && is_array(request('categories')) && in_array($categoryItem->id, request('categories'))) checked @endif/>
                                        <label class="label" for="check_{{$categoryItem->id}}"></label>
                                        <label for="check_{{$categoryItem->id}}">{{$categoryItem->name}}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="filter_3">
                            <div class="filter_3-title">Введите адрес, где вы находитесь</div>
                            <input type="text" name="location[name]" id="address" placeholder="Адрес"
                                   value="{{isset(request('location')['name']) ? request('location')['name'] : ''}}"/>
                            <div class="rangeBlock">
                                <div class="filter_3-desc">
                                    <label for="adres">Отобразить акции рядом с вами и поблизости, но не дальше
                                        чем:</label></div>
                                <div>
                                    <div class="range-width">
                                        <input id="ex21" type="text" data-slider-ticks="{{ $dataSliderTicks->keys() }}"
                                               data-slider-min="1"
                                               data-slider-max="5" data-slider-step="1"
                                               data-slider-value="{{ $dataSliderTicks->search(request('location')['range'] ?? 1000) }}"
                                               data-slider-tooltip="hide"/>
                                        <input type="hidden" id="range" name="location[range]"
                                               value="{{ request('location')['range'] ?? 1000 }}"/>
                                    </div>
                                    <div class="filter_3-range-box">
                                        <div onclick="change_range(1)"><img src="/images/icons/filter_range.svg"/><br>100м
                                        </div>
                                        <div onclick="change_range(2)"><img src="/images/icons/filter_range.svg"/><br>500м
                                        </div>
                                        <div onclick="change_range(3)"><img src="/images/icons/filter_range.svg"/><br>1км
                                        </div>
                                        <div onclick="change_range(4)"><img src="/images/icons/filter_range.svg"/><br>5км
                                        </div>
                                        <div onclick="change_range(5)"><img src="/images/icons/filter_range.svg"/><br>10км
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="search-block__filter-buttons">
                            @if (Request::input() !== [])
                            <div class="clear_filter"><i class="fas fa-times"></i>&nbsp;Сбросить фильтр</div>
                            @endif
                            <button type="submit" class="submit_filter">Найти</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif
        <div class="top-block__view-map" style="margin-top: 60px;">
            <a data-toggle="modal" data-target="#map-modal" class="d-flex"><img src="/images/icons/view-map.svg"/>
                <div class="v-align"><span>Смотреть на карте</span></div>
            </a>
        </div>
    </div>
</div>

@section('filter-panel')
    <div class="filter-panel">
        <a class="filter-panel__close filterPanel"><img src="/images/icons/close.svg"/></a>
        <div class="filter-panel__block">
            <form id="filter_form-mobile">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="filter-panel__block-title">Фильтр акций</div>
                        </div>
                        <div class="col-md-12 filter-panel__filter">
                            <div class="row">
                                <div class="col-md-4 col-6">
                                    <span>Фильтр по:</span>
                                    <ul>
                                        <li id="filterMob_1" class="active">
                                            <div class="v-align"><img src="/images/icons/filter-date.svg">Дате</div>
                                        </li>
                                        @if(empty($category))
                                        <li id="filterMob_2">
                                            <div class="v-align"><img src="/images/icons/filter-category.svg">Категориям
                                            </div>
                                        </li>
                                        @endif
                                        <li id="filterMob_3">
                                            <div class="v-align"><img src="/images/icons/filter-geo.svg">Геолокации
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4 col-6">
                                    <span>Сортировать по:</span>
                                    <ul>
                                        <li class="change-sort-raiting">
                                            <input type="hidden"
                                                   data-sort="{{ $sortVariants->search(request('sort-raiting') ?? 0) }}"
                                                   class="sort-raiting" value="{{ request('sort-raiting') }}">
                                            <img src="/images/icons/filter-raiting.svg">Рейтингу <i
                                                    class="fas fa-long-arrow-alt-up iup"></i> <i
                                                    class="fas fa-long-arrow-alt-down idown"></i>
                                        </li>
                                        <li class="change-sort-views">
                                            <input type="hidden"
                                                   data-sort="{{ $sortVariants->search(request('sort-views') ?? 0) }}"
                                                   class="sort-views" value="{{ request('sort-views') }}">
                                            <img src="/images/icons/filter-views.svg">Просмотрам <i
                                                    class="fas fa-long-arrow-alt-up iup"></i> <i
                                                    class="fas fa-long-arrow-alt-down idown"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mobfilter_1">
                                <input type="hidden" name="date" class="date-picker-mobile"
                                       value="{{ request('date') }}"/>
                                <div id="daterangepicker1-container-mobile" class="embedded-daterangepicker"></div>
                            </div>
                            <div class="mobfilter_2">
                                <ul>
                                    @foreach($categories->flatten()->unique('id')->values()->all() as $categoryItem)
                                        <li><input id="check-mob_{{$categoryItem->id}}" type="checkbox"
                                                   name="categories[]"
                                                   value="{{$categoryItem->id}}"
                                                   @if(!empty(request('categories')) && is_array(request('categories')) && in_array($categoryItem->id, request('categories'))) checked @endif>
                                            <label class="label"
                                                   for="check-mob_{{$categoryItem->id}}"></label>
                                            <label for="check-mob_{{$categoryItem->id}}">{{$categoryItem->name}}</label></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mobfilter_3">
                                <div class="mobfilter_3-title">Введите адрес, где вы находитесь</div>
                                <input id="addressMob" type="text" name="location[name]" placeholder="Адрес" value="{{isset(request('location')['name']) ?? request('location')['name']}}"/>
                                <div class="rangeBlock">
                                <div class="mobfilter_3-desc"><label for="adresmob">Отобразить
                                        акции рядом с вами и поблизости, но не дальше чем:</label></div>
                                    <div class="range-width">
                                        <input id="ex21mob" type="text" data-slider-ticks="{{ $dataSliderTicks->keys() }}"
                                               data-slider-min="1" data-slider-max="5" data-slider-step="1"
                                               data-slider-value="{{ $dataSliderTicks->search(request('location')['range'] ?? 1000) }}" data-slider-tooltip="hide"/>
                                        <input type="hidden" id="rangeMob" name="location[range]"
                                               value="{{ request('location')['range'] ?? 1000 }}"/>
                                    </div>
                                    <div class="mobfilter_3-range-box">
                                        <div onclick="change_rangemob(1)"><img
                                                    src="/images/icons/filter_range.svg"/><br>100м
                                        </div>
                                        <div onclick="change_rangemob(2)"><img
                                                    src="/images/icons/filter_range.svg"/><br>500м
                                        </div>
                                        <div onclick="change_rangemob(3)"><img
                                                    src="/images/icons/filter_range.svg"/><br>1км
                                        </div>
                                        <div onclick="change_rangemob(4)"><img
                                                    src="/images/icons/filter_range.svg"/><br>5км
                                        </div>
                                        <div onclick="change_rangemob(5)"><img
                                                    src="/images/icons/filter_range.svg"/><br>10км
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row filter-panel__nav">
                                <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                                    <div class="v-align"><span class="clear_filterm"><i class="fas fa-times"></i>&nbsp;Сбросить фильтр</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                                    <button type="submit">Найти</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
--}}