@section('header-id', 'min-header')

<div class="container mw">
    <div class="top-block">
        <div class="top-block__breadcrumb">
            <ul>
                <li><a href="{{ route('frontend.city.show') }}">Главная</a></li>
                <li>Результаты поиска</li>
            </ul>
        </div>
        <h1>Результаты поиска</h1>
        <div class="search-block">
            <form class="search-block__form" method="get" action="?">
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
    </div>
</div>
