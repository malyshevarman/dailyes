@section('header-class', "full-height")


<div class="container mw">
    <div class="top-block">
        <div class="title-text">
            <h1>Выгодные предложения, акции и скидки в городе {{$city->name}}</h1>
            <div class="title-text__small">
                Мы поможем вам сэкономить средства и найти лучший вариант
            </div>
        </div>
        @include('frontend.includes.top-block-soc')
        <div class="search-block">
            <form class="search-block__form" method="get" action="{{ route('frontend.city.search.index') }}">
                <div class="search-block__form-table">
                    <input
                            name="text"
                            value="{{ request()->text }}"
                            class="search-block__input"
                            placeholder="Найти акцию или компанию"
                            type="text"
                    >
                </div>
                <button
                        class="search-block__glass"
                >
                    <img src="/images/icons/glass.svg">
                </button>
            </form>
        </div>
        @include('frontend.includes.soc-mobile')
    </div>
    <div class="search-block__info-block">
        <div class="row">
            <div class="col-md-4">
                <img src="/images/icons/coin.svg"/>
                <div class="search-block__info-title">
                    Поможем сэкономить
                    <div class="desc">
                        До 90% возможных трат, более<br>чем в 1000 заведениях вашего города
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <img src="/images/icons/notify-white.svg"/>
                <div class="search-block__info-title">
                    Мгновенное оповещение
                    <div class="desc">
                        Оповестим в личном кабинете о новой акции из выбранной категории
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <img src="/images/icons/info.svg"/>
                <div class="search-block__info-title">
                    Проверенная информация
                    <div class="desc">
                        Мы проверяем информацию каждой акции на нашем портале
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
