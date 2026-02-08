<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta name="yandex-verification" content="c2561e50f68ab926" />
    <meta name="google-site-verification" content="JheI-KUr_2HHL5tfvkXvBmOHVm_U_JpzBF_PmlY-XvY" />
    @include('frontend.includes.meta')
</head>
<body class="page">
<div id="app" class="oh">
    @if (!isset($page) || $page->path !== "/for-business")

        <header class="header">
            <div class="container">
                <div class="header__row">
                    <a class="logo" href="#" aria-label="Dayilies">
                    </a>

                    <nav class="header__menu" aria-label="Главное меню">
                        <a class="header__link" href="#">Акции</a>
                        <a class="header__link" href="#">Компании</a>
                        <a class="header__link" href="#">Рейтинг <span class="icon icon--chev"></span></a>

                    </nav>

                    <div class="header__right">
                        <a href="#" class="header__user-name"
                           @click.prevent="$bus.$emit('showCitySelectPanel')">{{$city->name}}</a>
                            <a href="#" class="header__avatar" aria-hidden="true"></a>
                    </div>
                </div>
            </div>

            <div class="subnav">
                <div class="container">
                    <div class="subnav__row">
                        <button class="subnav__item subnav__item--dd" type="button">Авто <span
                                class="icon icon--chev"></span></button>
                        <button class="subnav__item subnav__item--dd" type="button">Еда <span
                                class="icon icon--chev"></span></button>
                        <button class="subnav__item subnav__item--dd" type="button">Здоровье <span
                                class="icon icon--chev"></span></button>
                        <button class="subnav__item subnav__item--dd" type="button">Красота <span
                                class="icon icon--chev"></span></button>
                        <button class="subnav__item subnav__item--dd" type="button">Обучение <span
                                class="icon icon--chev"></span></button>
                        <button class="subnav__item subnav__item--dd" type="button">Покупки <span
                                class="icon icon--chev"></span></button>
                        <button class="subnav__item subnav__item--dd" type="button">Развлечения <span
                                class="icon icon--chev"></span></button>
                        <button class="subnav__item subnav__item--dd" type="button">Спорт <span
                                class="icon icon--chev"></span></button>
                        <button class="subnav__item subnav__item--dd" type="button">Услуги <span
                                class="icon icon--chev"></span></button>
                        <button class="subnav__item subnav__item--dd" type="button">Прочее <span
                                class="icon icon--chev"></span></button>
                    </div>
                </div>
            </div>
        </header>



        <main class="main">
        <section class="hero">
            <div class="container">
                @if(\Request::route()->getName() == 'frontend.city.show')
                <h1 class="hero__title">Выгодные предложения, акции и скидки в вашем городе</h1>
                <p class="hero__subtitle">Мы поможем вам сэкономить средства и найти лучшее предложение</p>
                @endif
                <div class="search">
                    <div class="search__field">
                        <span class="icon icon--search"></span>
                        <input class="search__input" type="text" placeholder="Поиск акций" />
                    </div>

                    <button class="btn btn--primary search__btn" type="button" aria-label="Найти">
                        <span class="icon icon--search-white"></span>
                    </button>

                    <button class="btn btn--soft search__map" type="button">
                        <span class="icon icon--map"></span>
                        <span>Смотреть на карте</span>
                        <span class="icon icon--chev"></span>
                    </button>
                </div>

                <div class="calendar">
                    <div class="calendar__left">
                        <div class="calendar__month">
                            <span class="calendar__month-name">Февраль</span>
                        </div>

                        <div class="calendar__days">
                            <button class="day" type="button"><span class="day__dow">пн</span><span class="day__num">09</span></button>
                            <button class="day" type="button"><span class="day__dow">вт</span><span class="day__num">10</span></button>
                            <button class="day" type="button"><span class="day__dow">ср</span><span class="day__num">11</span></button>
                            <button class="day" type="button"><span class="day__dow">чт</span><span class="day__num">12</span></button>
                            <button class="day" type="button"><span class="day__dow">пт</span><span class="day__num">13</span></button>
                            <button class="day day--active" type="button"><span class="day__dow">сб</span><span class="day__num">14</span></button>
                            <button class="day" type="button"><span class="day__dow">вс</span><span class="day__num">15</span></button>

                            <button class="day" type="button"><span class="day__dow">пн</span><span class="day__num">16</span></button>
                            <button class="day" type="button"><span class="day__dow">вт</span><span class="day__num">17</span></button>
                            <button class="day" type="button"><span class="day__dow">ср</span><span class="day__num">18</span></button>
                            <button class="day" type="button"><span class="day__dow">чт</span><span class="day__num">19</span></button>
                            <button class="day" type="button"><span class="day__dow">пт</span><span class="day__num">20</span></button>
                            <button class="day" type="button"><span class="day__dow">сб</span><span class="day__num">21</span></button>
                            <button class="day" type="button"><span class="day__dow">вс</span><span class="day__num">22</span></button>
                        </div>
                    </div>

                    <div class="calendar__right">
                        <button class="calendar__arrow" type="button" aria-label="Влево">‹</button>
                        <button class="calendar__arrow" type="button" aria-label="Вправо">›</button>
                    </div>
                </div>

                <div class="tabs">
                    <div class="tabs__left">
                        <button class="tab tab--active" type="button">Все</button>
                        <button class="tab" type="button">Новые</button>
                        <button class="tab" type="button">Заканчивающиеся</button>
                        <button class="tab" type="button">Рекомендуем</button>
                        <button class="tab" type="button">Лучшие оценки</button>
                        <button class="tab" type="button">Популярные</button>
                        <button class="tab" type="button">Скоро</button>
                    </div>

                    <button class="btn btn--primary btn--sm" type="button">Смотреть все</button>
                </div>
            </div>
        </section>


            @yield('content')
            @if(\Request::route()->getName() == 'frontend.city.show')
                    @include('frontend.includes.seo.main_page')
            @endif

        </main>

        @include('frontend.includes.app-block')

        <footer class="footer">
            <div class="container">
                <div class="footer__top">
                    <div class="footer__brand">
                        <a class="logo logo--footer" href="#"></a>
                        <div class="footer__desc">Акции и предложения<br>в вашем городе</div>
                    </div>

                    <div class="footer__cols">
                        <div class="footer__col">
                            <div class="footer__head">Dayilies</div>
                            <a class="footer__link" href="#">Акции</a>
                            <a class="footer__link" href="#">Компании</a>
                            <a class="footer__link" href="#">Рейтинг</a>
                            <a class="footer__link" href="#">О сервисе</a>
                            <a class="footer__link" href="#">Помощь</a>
                        </div>

                        <div class="footer__col">
                            <div class="footer__head">Реклама на сайте</div>
                            <a class="footer__link" href="#">Для вашего бизнеса</a>
                            <a class="footer__link" href="#">Блог</a>
                            <a class="footer__link" href="#">Контакты</a>
                        </div>
                        @include('frontend.includes.subscribe')

                    </div>
                </div>

                <div class="footer__bottom">
                    <div class="footer__copy">© 2025 Dayilies</div>
                    <div class="footer__made">ENJOY TOUCH</div>
                </div>
            </div>
        </footer>

    @else
    @yield('content')
    @endif


    @if(!env('APP_DEBUG'))

    <coockie></coockie>
    @endif

        <city_select></city_select>

<modal :message="{{json_encode(session('message'))}}"></modal>



@stack('before-scripts')
<script src="{{ mix('js/frontend.js') }}"></script>
@stack('after-scripts')

@if(!env('APP_DEBUG'))
<script src="https://yastatic.net/share2/share.js" async="async"></script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(65409580, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/65409580" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
@endif
</body>
</html>
