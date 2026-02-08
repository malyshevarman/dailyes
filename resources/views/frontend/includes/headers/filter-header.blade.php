<form id="filter_form" action="{{route(str_contains(\Request::route()->getName(), 'event') ? 'frontend.event.index' : 'frontend.company.index')}}">
    <div class="flex-box">
        <input class="search-block__input filtm" placeholder="Найти {{str_contains(\Request::route()->getName(), 'event') ? 'акцию' : 'компанию'}}" value="{{ request()->text }}"
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
                <li id="filter_2">
                    <img src="/images/icons/filter-category.svg"/> Категориям <img
                            class="search-block__filter-left-ri" src="/images/icons/filter-left.svg"/>
                </li>
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
                <div>
                    <ul style="display: flex;flex-direction: column;position: relative;overflow-y: auto;min-height: 420px;">
                        @foreach($categories->flatten()->unique('id')->values()->all() as $categoryItem)
                            <li class="filter_2-categories_item">
                                <a href="javascript:void(0);" data-filter-category-id="{{$categoryItem->id}}">{{$categoryItem->name}}</a>
                                <ul style="position: absolute;
                                    right: 0;
                                    top: 0; 
                                    display: none;
                                    flex-direction: column;"
                                    data-filter-category-tags="{{$categoryItem->id}}">
                                    @foreach($categoryItem->tags()->orderBy('order')->get() as $tag)
                                        <li>
                                            <input id="check_{{$tag->id}}" type="checkbox" name="tags[]"
                                                   value="{{$tag->id}}"
                                                   @if(!empty(request('tags')) && is_array(request('tags')) && in_array($tag->id, request('tags'))) checked @endif/>
                                            <label class="label" for="check_{{$tag->id}}"></label>
                                            <label for="check_{{$tag->id}}">{{$tag->name}}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="filter_3">
                <getposition location-name="{{request('location')['name'] ?? ''}}"></getposition>
                <div class="rangeBlock">
                    <div class="filter_3-desc">
                        <label for="adres">Отобразить акции рядом с вами и поблизости, но не дальше
                            чем:</label></div>
                    <div>
                        <div class="range-width">
                            <input id="ex21" type="text" data-slider-ticks="{{ $dataSliderTicks->keys() }}"
                                   data-slider-min="1"
                                   data-slider-max="5" data-slider-step="1"
                                   data-slider-value="{{ $dataSliderTicks->search(request('location')['range'] ?? null) }}"
                                   data-slider-tooltip="hide"/>
                            <input type="hidden" id="range" name="location[range]"
                                   value="{{ request('location')['range'] ?? null }}"/>
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
                <div class="clear_filter"><a href="/stocks"><i class="fas fa-times"></i>&nbsp;Сбросить фильтр</a></div>
                @endif
                <button type="submit" class="submit_filter">Найти</button>
            </div>
        </div>
    </div>
</form>