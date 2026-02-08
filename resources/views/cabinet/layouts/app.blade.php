<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('cabinet.includes.meta')
</head>
<body>
<div id="app">
    <header id="lk">
        @include('frontend.includes.header-menu')
    </header>
    <div class="d-flex" id="wrapper">


        <div id="sidebar-wrapper">
            <a href="/" class="left_panel_logo"><img src="/images/logo.svg"></a>
            @if(is_null(\Auth::user()->city))
            <ul>
                <li class="title">Пользователь</li>
                <li class="{{strrpos(Route::currentRouteName(), 'cabinet.profile') >-1 ? 'active':'' }}"><a href="{{ route('cabinet.profile.index') }}"><img src="/images/icons/lk/user.svg" /> Профиль</a></li>
            </ul>
            @else
            <ul>
                <!-- <li><a href="{{ route('cabinet.home') }}"><img src="/images/icons/lk/home.svg" /> Главная</a></li> -->
                <li class="{{strrpos(Route::currentRouteName(), 'cabinet.notification') >-1 ? 'active':'' }}"
                    style="position: relative;"><a href="{{ route('cabinet.notification.index') }}"><img src="/images/icons/lk/notify.svg" />
                        <div class="open-count">{{ Auth::user()->unreadNotifications()->count() }}</div>
                        Уведомления
                    </a>
                </li>
                <!-- <li class="{{strrpos(Route::currentRouteName(), 'cabinet.settings') >-1 ? 'active':'' }}"
                    style="position: relative;"><a href="{{ route('cabinet.settings.index') }}"><img src="/images/icons/lk/settings.svg" />
                        Настройки
                    </a>
                </li> -->
            </ul>
            <ul>
                <li class="title">Пользователь</li>
                <li class="{{strrpos(Route::currentRouteName(), 'cabinet.profile') >-1 ? 'active':'' }}"><a href="{{ route('cabinet.profile.index') }}"><img src="/images/icons/lk/user.svg" /> Профиль</a></li>
                <li class="{{strrpos(Route::currentRouteName(), 'cabinet.favorite') >-1 ? 'active':'' }}"><a href="{{ route('cabinet.favorite.index') }}"><img src="/images/icons/lk/bookmark.svg" /> Избранное</a></li>
                <li class="{{strrpos(Route::currentRouteName(), 'cabinet.comment') >-1 ? 'active':'' }}"><a href="{{ route('cabinet.comment.index') }}"><img src="/images/icons/lk/chat.svg" /> Мои отзывы</a></li>
             <!--   <li class="{{strrpos(Route::currentRouteName(), 'cabinet.question') >-1 ? 'active':'' }}"><a href="{{ route('cabinet.question.index') }}"><img src="/images/icons/lk/chat.svg" /> Мои вопросы</a></li>
           -->

            </ul>
            @if(\Auth::user()->companies()->count() > 0)
                <ul>
                    <li class="title">Бизнес аккаунт</li>
                    <li class="{{ strrpos(Route::currentRouteName(), 'cabinet.company') >-1 ? 'active':'' }}"><a  href="{{ route('cabinet.company.index') }}"><img src="/images/icons/lk/company.svg" /> Компания</a></li>
                    @if(\Auth::user()->companies[0]->published && !\Auth::user()->companies[0]->rejected && \Auth::user()->companies[0]->active)
                    <li class="{{strrpos(Route::currentRouteName(), 'cabinet.event') >-1 ? 'active':'' }}" ><a href="{{ route('cabinet.event.index') }}"><img src="/images/icons/lk/event.svg" /> Акции</a></li>

                    <li class="{{ strrpos(Route::currentRouteName(), 'business.comment') >-1 ? 'active':'' }}"><a  href="{{ route('business.comment.index') }}"><img src="/images/icons/lk/chat.svg" /> Отзывы</a></li>
                    @endif
                <!-- <li class="{{ strrpos(Route::currentRouteName(), 'cabinet.question') >-1 ? 'active':'' }}"><a  href="{{ route('business.question.index') }}"><img src="/images/icons/lk/chat.svg" /> Вопросы</a></li>
                     <li><a href="{{ route('cabinet.invoice.index') }}"><img src="/images/icons/lk/ruble.svg" /> Финансы</a></li>
                    <li><a href="{{ route('cabinet.banner.index') }}"><img src="/images/icons/lk/hank.svg" /> Реклама</a></li> -->
                </ul>
            @else
                <ul>
                    <li class="title">Бизнес аккаунт</li>
                    <li class="{{ strrpos(Route::currentRouteName(), 'cabinet.company') >-1 ? 'active':'' }}"><a  href="{{ route('cabinet.company.create') }}"><img src="/images/icons/lk/company.svg" /> Добавить компанию</a></li>
                </ul>
            @endif
            <ul>
                @role('admin')
                <li><a href="{{ route('admin.home') }}"><span class="top-block__open-img"><img src="/images/icons/user.svg"></span>Управление</a></li>
                @endrole
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="top-block__open-img"><img src="/images/icons/exit.svg"></span>Выйти</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
            @endif
        </div>
        <div id="page-content-wrapper" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div class="container-fluid">
                <div class="lk-body">
                    @yield('content')
                </div>
            </div>
            <!-- <div class="to_up">
                <img src="/images/icons/up.svg" />
            </div> -->
            <footer>
                <div class="container-fluid">
                    <div class="row">
                        @include('frontend.includes.footer-menu')
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <rulesplacement></rulesplacement>
    <city_select></city_select>
</div>

<!-- Scripts -->
@stack('before-scripts')
<script src="{{ mix('js/cabinet.js') }}"></script>
@stack('after-scripts')

<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user()
      ]) !!};
</script>

</body>
</html>
