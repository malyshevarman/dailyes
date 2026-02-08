<form id="filter_form-mobile" action="{{route(str_contains(\Request::route()->getName(), 'event') ? 'frontend.event.index' : 'frontend.company.index')}}">
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
                                        <li id="filterMob_2">
                                            <div class="v-align"><img src="/images/icons/filter-category.svg">Категориям
                                            </div>
                                        </li>
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
                                <div>
                                    <ul style="display: flex;flex-direction: column;position: relative;">
                                        @foreach($categories->flatten()->unique('id')->values()->all() as $categoryItem)
                                            <li class="mobfilter_2-categories_item">
                                                <a href="javascript:void(0);" data-filter-category-id="{{$categoryItem->id}}">{{$categoryItem->name}}</a>
                                                <ul style="margin-top:20px;display: none;"
                                                    data-filter-category-tags="{{$categoryItem->id}}">
                                                    @foreach($categoryItem->tags()->orderBy('order')->get() as $tag)
                                                        <li>
                                                            <input id="mob_check_{{$tag->id}}" type="checkbox" name="tags[]"
                                                                   value="{{$tag->id}}"
                                                                   @if(!empty(request('tags')) && is_array(request('tags')) && in_array($tag->id, request('tags'))) checked @endif/>
                                                            <label class="label" for="mob_check_{{$tag->id}}"></label>
                                                            <label for="mob_check_{{$tag->id}}">{{$tag->name}}</label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="mobfilter_3">
                                <getpositionmob location-name="{{request('location')['name'] ?? ''}}"></getpositionmob>
                                <div class="rangeBlock">
                                <div class="mobfilter_3-desc"><label for="adresmob">Отобразить
                                        акции рядом с вами и поблизости, но не дальше чем:</label></div>
                                    <div class="range-width">
                                        <input id="ex21mob" type="text" data-slider-ticks="{{ $dataSliderTicks->keys() }}"
                                               data-slider-min="1" data-slider-max="5" data-slider-step="1"
                                               data-slider-value="{{ $dataSliderTicks->search(request('location')['range'] ?? null) }}" data-slider-tooltip="hide"/>
                                        <input type="hidden" id="rangeMob" name="location[range]"
                                               value="{{ request('location')['range'] ?? null }}"/>
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
                                    <div class="v-align"><span class="clear_filterm"><a href="/stocks"><i class="fas fa-times"></i>&nbsp;Сбросить фильтр</a></span>
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