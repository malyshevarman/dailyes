@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Реклама</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Увеличить просмотры
    </div>
    <div class="lk-body__services-container">
        <div class="lk-body__desc">
            Каждый день, десятки тысяч людей на Dailyes ищут скидки, акции и самые разные предложения от компаний в своём городе. Чтобы находить ещё больше клиентов среди пользователей, мы предлагаем воспользоваться нашим профессиональным инструментом и подключить одну или сразу несколько доступных к выбору услуг
        </div>
        <div class="lk-body__services">
            <div>
                <div class="lk-body__services-title">
                    <img src="/images/icons/lk/Vector.svg" />Поднять акцию
                    <div class="lk-body__services-economy">
                        Экономия 50%
                    </div>
                </div>
                <div class="lk-body__services-nav-price">
                    <strike>200 ₽</strike>
                    <div class="v-align">100 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
            <div>
                <div class="lk-body__services-desc">
                    Акция, разово, поднимется в самое начало ленты, тем самым будет замечено максимальным охватом аудитории
                </div>
                <div class="lk-body__services-nav">
                    <button>Подключить</button>
                </div>
            </div>
            <div class="lk-body__services-mobile" style="display: none;">
                <div class="lk-body__services-nav lk-mobile">
                    <button>Подключить</button>
                </div>
                <div class="lk-body__services-nav-price lk-mobile">
                    <strike>200 ₽</strike>
                    <div class="v-align">100 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
        </div>
        <div class="lk-body__services">
            <div>
                <div class="lk-body__services-title">
                    <img src="/images/icons/lk/sun.svg" />Выделить акцию
                    <div class="lk-body__services-economy">
                        Экономия 50%
                    </div>
                </div>
                <div class="lk-body__services-nav-price">
                    <strike>300 ₽</strike>
                    <div class="v-align">150 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
            <div>
                <div class="lk-body__services-desc">
                    Акция будет отмечена синей рамкой в ленте, в течении 7 дней. Это позволит выделиться на фоне стандартных предложений и тем самым набрать до 10 раз больше просмотров
                </div>
                <div class="lk-body__services-nav">
                    <button>Подключить</button>
                </div>
            </div>
            <div class="lk-body__services-mobile" style="display: none;">
                <div class="lk-body__services-nav lk-mobile">
                    <button>Подключить</button>
                </div>
                <div class="lk-body__services-nav-price lk-mobile">
                    <strike>300 ₽</strike>
                    <div class="v-align">150 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
        </div>
        <div class="lk-body__services">
            <div>
                <div class="lk-body__services-title">
                    <img src="/images/icons/lk/fas.fa-hand-point-right.svg" />Указать на акцию
                    <div class="lk-body__services-economy">
                        Экономия 50%
                    </div>
                </div>
                <div class="lk-body__services-nav-price">
                    <strike>400 ₽</strike>
                    <div class="v-align">200 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
            <div>
                <div class="lk-body__services-desc">
                    Акция будет отмечена специальной иконкой “Выбор редакции” в течении 7 дней. Также она попадёт в специальный раздел “Мы рекомендуем”. Это позволит обратить дополнительное внимание на ваше предложение всех пользователей сайта
                </div>
                <div class="lk-body__services-nav">
                    <button>Подключить</button>
                </div>
            </div>
            <div class="lk-body__services-mobile" style="display: none;">
                <div class="lk-body__services-nav lk-mobile">
                    <button>Подключить</button>
                </div>
                <div class="lk-body__services-nav-price lk-mobile">
                    <strike>400 ₽</strike>
                    <div class="v-align">200 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
        </div>
        <div class="lk-body__services">
            <div>
                <div class="lk-body__services-title">
                    <img src="/images/icons/lk/pin1.svg" />Закрепить акцию
                    <div class="lk-body__services-economy">
                        Экономия 50%
                    </div>
                </div>
                <div class="lk-body__services-nav-price">
                    <strike>500 ₽</strike>
                    <div class="v-align">250 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
            <div>
                <div class="lk-body__services-desc">
                    Акция будет закреплена в течении 7 дней на первых позициях категории, к которой относится. Это позволит увеличить до 20 раз количество просмотров
                </div>
                <div class="lk-body__services-nav">
                    <button>Подключить</button>
                </div>
            </div>
            <div class="lk-body__services-mobile" style="display: none;">
                <div class="lk-body__services-nav lk-mobile">
                    <button>Подключить</button>
                </div>
                <div class="lk-body__services-nav-price lk-mobile">
                    <strike>500 ₽</strike>
                    <div class="v-align">250 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
        </div>
        <div class="lk-body__services">
            <div>
                <div class="lk-body__services-title">
                    <img src="/images/icons/lk/fas.fa-gem.svg" />Премиум размещение
                    <div class="lk-body__services-economy">
                        Экономия 50%
                    </div>
                </div>
                <div class="lk-body__services-nav-price">
                    <strike>1000 ₽</strike>
                    <div class="v-align">500 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
            <div>
                <div class="lk-body__services-desc">
                    К акции, разово, будет применён пакет по продвижению, который включает в себя следующие услуги: <br> - Выделить акцию (на 7 дней); <br> - Указать на акцию (на 7 дней); <br> - Закрепить акцию (на 7 дней). <br> При подключении пакета, количество просмотров увеличится до 50 раз
                </div>
                <div class="lk-body__services-nav">
                    <button>Подключить</button>
                </div>
            </div>
            <div class="lk-body__services-mobile" style="display: none;">
                <div class="lk-body__services-nav lk-mobile">
                    <button>Подключить</button>
                </div>
                <div class="lk-body__services-nav-price lk-mobile">
                    <strike>1000 ₽</strike>
                    <div class="v-align">500 <img src="/images/icons/ruble-currency-sign.svg" /></div>
                </div>
            </div>
        </div>
    </div>
    <a href="/rules" style="margin-top:30px;">Оферта на оказание услуг</a>
@endsection
