@section('header-id', 'min-header-wi')

@section('header-style', "background: url('/images/eventsncompanies_bgr.png'); background-size: cover; background-position: center center;")

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
               <li>
                    Акции
                </li>
            </ul>
        </div>
        @if(Request::input('label_id') == 1)
            <h1>Акции сегодня в городе {{$city->name}}</h1>
        @elseif(Request::input('label_id') == 2)
            <h1>Успейте воспользоваться акциями в городе {{$city->name}}</h1>
        @elseif (Request::input('favorite'))
            <h1>Рекомендуемые акции в городе {{$city->name}}</h1>
        @elseif (Request::input('sort-raiting'))
            <h1>Акции с лучшими оценками в городе {{$city->name}}</h1>
        @elseif (Request::input('sort-views'))
            <h1>Популярные акции в городе {{$city->name}}</h1>
        @else
            <h1>
            Акции в городе {{$city->name}}
            </h1>
        @endif
        <div class="top-block__desc">
            Выберите нужные параметры поиска или напишите название акции или предложения
        </div>
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
        <div class="search-block">
            @include('frontend.includes.headers.filter-header')
        </div>
        <div class="top-block__view-map">
            <a class="d-flex"  @click="$bus.$emit('showEventsMap')"><svg style="margin-right: 8px;" width="20" height="25" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.12534 10.6221C7.54271 10.9003 8.03357 11.0489 8.5359 11.0491L7.12534 10.6221ZM7.12534 10.6221C6.70778 10.3438 6.38263 9.9485 6.1907 9.48634M7.12534 10.6221L6.1907 9.48634M6.1907 9.48634C5.99878 9.0242 5.94859 8.51578 6.0464 8.02531M6.1907 9.48634L6.0464 8.02531M6.0464 8.02531C6.14422 7.53483 6.38572 7.08402 6.74065 6.73M6.0464 8.02531L6.74065 6.73M6.74065 6.73C7.09561 6.37597 7.54809 6.13464 8.04097 6.03686M6.74065 6.73L8.04097 6.03686M8.04097 6.03686C8.53386 5.93907 9.04474 5.98928 9.50892 6.18105M8.04097 6.03686L9.50892 6.18105M9.50892 6.18105C9.97308 6.37281 10.3695 6.69741 10.6482 7.11352M9.50892 6.18105L10.6482 7.11352M10.6482 7.11352C10.9268 7.52939 11.0755 8.01807 11.0756 8.51785L10.6482 7.11352ZM9.28666 1.28936V1.24923L8.5359 1.25C6.60501 1.25197 4.75335 2.0178 3.3873 3.38008C2.02118 4.74243 1.25231 6.59006 1.25 8.51772V8.51861C1.25 9.78359 1.66062 11.14 2.23223 12.4292C2.80797 13.7278 3.57173 15.0125 4.3327 16.1484C5.8547 18.4205 7.40592 20.157 7.54016 20.3065L7.54133 20.3078C7.667 20.4471 7.82053 20.5584 7.99191 20.6346C8.16326 20.7107 8.34867 20.75 8.53611 20.75C8.72356 20.75 8.90896 20.7107 9.0803 20.6346C9.25168 20.5584 9.40521 20.4471 9.53088 20.3078L9.53205 20.3065C9.66629 20.157 11.2175 18.4205 12.7395 16.1484C13.5005 15.0125 14.2642 13.7278 14.84 12.4292C15.4116 11.14 15.8222 9.78359 15.8222 8.51861L15.8222 8.51772C15.8199 6.59027 15.0512 4.74283 13.6853 3.38052C12.4974 2.19561 10.942 1.46184 9.28666 1.28936ZM11.0756 8.51794C11.0749 9.18839 10.8076 9.83157 10.3317 10.3062C9.85572 10.781 9.20995 11.0484 8.53599 11.0491L11.0756 8.51794Z" stroke="#fff" stroke-width="1.5"/>
                        </svg>
                <div class="v-align"><span>Смотреть на карте</span></div>
            </a>
        </div>
    </div>
</div>

@section('filter-panel')
    <div class="filter-panel">
        <a class="filter-panel__close filterPanel"><img src="/images/icons/close.svg"/></a>
        <div class="filter-panel__block">
            @include('frontend.includes.headers.filter-mobile-header')
        </div>
    </div>
@endsection
