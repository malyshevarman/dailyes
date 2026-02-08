<div class="container-fluid fixmobile">
    <div class="row">
        <div class="col-xs-12 mobile__nav">
            <div class="container mw">
                <div>
                    <div class="v-align">
                        <div class="mobile__nav-menu">
                            <img src="/images/icons/mobile-menu.svg"/>
                        </div>
                        @if(!isset($page) || $page->path !== "/for-business")



                        <div class="mobile__nav-city" @click="$bus.$emit('showCitySelectPanel')">
                            <span class="cityPanel">{{ $city->name }}</span>
                        </div>
                        @endif
                        <div class="mobile__nav-login">
                            @guest
                                <span class="authPanel">Войти</span>
                            @endguest
                            @auth
                                <div class="mobile__nav-profile">
                                    <div class="v-align">
                                        <div class="mobile__nav-photo">
                                            <img src="/images/avatar.svg"/>
                                        </div>
                                        <img class="icon" src="/images/icons/profile-open.svg"/>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
                @auth
                    <div class="mobile__nav-profileMenu
                            @if ( !empty(explode('/', url()->current())[3]) && explode('/', url()->current())[3] == 'cabinet')
                                cabinet
                            @else
                                front
                            @endif
                        ">
                        <ul>


                            @if ( !empty(explode('/', url()->current())[3]) && explode('/', url()->current())[3] == 'cabinet')
                                @else
                            <li><a href="{{ route('cabinet.home') }}"><div class="top-block__open-img"><img src="/images/icons/user.svg"></div>Личный кабинет</a></li>
                            @endif

                            <li><a href="{{ route('cabinet.notification.index') }}"><div class="top-block__open-img"><img src="/images/icons/notify.svg"></div>Уведомления</a></li>
                        </ul>
                        @if ( !empty(explode('/', url()->current())[3]) && explode('/', url()->current())[3] == 'cabinet')
                        <ul>
                            <li class="title" style="color: #1D86E0;">Пользователь</li>
                            <li><a href="{{ route('cabinet.profile.index') }}">Профиль</a></li>
                            <li><a href="{{ route('cabinet.favorite.index') }}">Избранное</a></li>
                            <li><a href="{{ route('cabinet.comment.index') }}">Мои отзывы</a></li>

                        </ul>
                        <ul>
                            <li class="title" style="color: #1D86E0;">Бизнес аккаунт</li>
                            <li><a href="{{ route('cabinet.company.index') }}">Компания</a></li>
                            <li><a href="{{ route('cabinet.event.index') }}">Акции</a></li>
                            <li><a href="{{ route('business.comment.index') }}">Отзывы</a></li>


                        </ul>
                        @endif
                        <ul>
                            @role('admin')
                            <li><a href="{{ route('admin.home') }}"><div class="top-block__open-img"><img src="/images/icons/user.svg"></div>Управление</a></li>
                            @endrole
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><div class="top-block__open-img"><img src="/images/icons/exit.svg"></div>Выйти</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
                <div class="mobile__nav-fix">
                    @if (!isset($page) || $page->path !== "/for-business")
                    <ul>
                        <li>
                            <div class="v-align"><a href="/">Главная</a></div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="{{ route('frontend.event.index') }}">Акции</a>
                            {{--<ul>
                                @foreach($eventsTopMenuCategories as $category)
                                <li>
                                    <a href="{{route('frontend.city.event.category.show', $category)}}">
                                        {{$category->name}}</a>
                                </li>
                                @endforeach
                            </ul>--}}
                        </li>
                        <li>
                            <a href="{{ route('frontend.company.index') }}">Компании</a>
                            {{--<ul>
                                @foreach($companiesTopMenuCategories as $category)
                                <li>
                                    <a href="{{route('frontend.city.company.category.show', $category)}}">
                                        {{$category->name}}</a>
                                </li>
                                @endforeach
                            </ul>--}}
                        </li>
                    </ul>
                    <ul>
                        <li><a href="/about">О сервисе</a></li>
                        <li><a href="/blog">Блог</a></li>
                        <li><a href="/jobs">Вакансии</a></li>
                        <li><a href="/help">Помощь</a></li>
                        <li><a href="/contacts">Контакты</a></li>
                    </ul>
                    <ul>
                        <li><a href="/add-company">Добавить компанию</a></li>
                        <li><a href="/add-stocks">Добавить акцию</a></li>
                        <li><a href="/ad">Реклама на сайте</a></li>
                        <li><a href="/for-business">Для вашего бизнеса</a></li>
                    </ul>
                    @else
                    <ul>
                        <li>
                            <div class="v-align"><a href="/">Главная</a></div>
                        </li>
                    </ul>
                    <!-- <ul>
                        <li class="for-business-btn active"><a href="#first">dailyes бизнес</a></li>
                        <li class="for-business-btn"><a href="#second">Преимущества</a></li>
                        <li class="for-business-btn"><a href="#third">личный кабинет</a></li>
                        <li class="for-business-btn"><a href="#fourth">вопросы и ответы</a></li>
                        <li class="for-business-btn"><a href="#fifth">партнеры</a></li>
                    </ul> -->
                    <ul>
                        <li><a href="/about">О сервисе</a></li>
                        <li><a href="/blog">Блог</a></li>
                        <li><a href="/jobs">Вакансии</a></li>
                        <li><a href="/help">Помощь</a></li>
                        <li><a href="/contacts">Контакты</a></li>
                    </ul>
                    <ul>
                        <li><a href="/add-company">Добавить компанию</a></li>
                        <li><a href="/add-stocks">Добавить акцию</a></li>
                        <li><a href="/ad">Реклама на сайте</a></li>
                        <li><a href="/for-business">Для вашего бизнеса</a></li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="@if( !empty(explode('/', url()->current())[3]) && explode('/', url()->current())[3] == 'cabinet') container-fluid @else container @endif top-block">
        <div class="top-block__logo">
            @if (!isset($page) || $page->path !== "/for-business")
            <a href="/"><img src="/images/logo.svg"/></a>
            <a href="/"><img src="/images/logo-mob.svg"/></a>
            @else
            <a href="/"><img src="/images/for_business_logo.svg"/></a>
            <!-- <a href="/"><img src="/images/for_business_logo.png"/></a> -->
            @endif
        </div>


        @if ( !empty(explode('/', url()->current())[3]) && explode('/', url()->current())[3] == 'cabinet')

        @else
            @if (!isset($page) || $page->path !== "/for-business")
                <div class="top-block__city">
                    <div @click="$bus.$emit('showCitySelectPanel')"><span class="current">{{ $city->name }}</span>
                    </div>
                    <city_option></city_option>
                </div>
            @endif
        @endif

        <div class="top-block__menu">
            <ul>
                @if (!isset($page) || $page->path !== "/for-business")


                    @if ( !empty(explode('/', url()->current())[3]) && explode('/', url()->current())[3] == 'cabinet')

                    @else
                        <li class="top-block__menu-events">
                            <a href="{{ route('frontend.event.index') }}">Акции</a>
                            {{--<div class="top-block__open events">
                                <div class="background">
                                    <div class="top-block__open-item">
                                        <a href="{{ route('frontend.event.index') }}"><span>Все акции</span></a>
                                    </div>
                                    @foreach($eventsTopMenuCategories as $category)
                                    <div class="top-block__open-item">
                                        <a href="{{route('frontend.city.event.category.show', $category)}}">
                                            <!-- <div class="top-block__open-img"><img src="/images/icons/user.svg"/></div> -->
                                            <span>{{$category->name}}</span></a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>--}}
                        </li>
                        <li class="top-block__menu-companies">
                            <a href="{{ route('frontend.company.index') }}">Компании</a>
                            {{--<div class="top-block__open companies">
                                    <div class="background">
                                        <div class="top-block__open-item">
                                            <a href="{{ route('frontend.company.index') }}"><span>Все компании</span></a>
                                        </div>
                                        @foreach($companiesTopMenuCategories as $category)
                                        <div class="top-block__open-item">
                                            <a href="{{route('frontend.city.company.category.show', $category)}}">
                                                <!-- <div class="top-block__open-img"><img src="/images/icons/user.svg"/></div> -->
                                                <span>{{$category->name}}</span></a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>--}}
                        </li>
                        <li><a href="/add-company"><img src="/images/plus.svg" style="margin-right: 5px;">Добавить компанию</a></li>
                    @endif

                @else
                <li class="for-business-btn active"><a href="#first">dailyes бизнес</a></li>
                <li class="for-business-btn"><a href="#second">Преимущества</a></li>
                <li class="for-business-btn"><a href="#third">личный кабинет</a></li>
                <li class="for-business-btn"><a href="#fourth">вопросы и ответы</a></li>
                <li class="for-business-btn"><a href="#fifth">партнеры</a></li>

                @endif
            </ul>
        </div>
        @guest
            <div class="top-block__button">
                <a data="1" class="authPanel">Войти</a>
            </div>
        @endguest
        @auth
            <div class="top-block__avatar">
                <div class="v-align">
                    <div class="top-block__avatar-photo">
                        <img src="/images/avatar.svg"/>
                    </div>
                    <span class="name">{{Auth::user()->name}}</span>
                    <img src="/images/icons/arrow-down-sign-to-navigate.svg"/>
                </div>
                <div class="top-block__open avatar-menu">
                    <div class="background">
                        @role('admin')
                        <div class="top-block__open-item">
                            <a href="{{ route('admin.home') }}">
                                <div class="top-block__open-img"><img src="/images/icons/user.svg"/></div>
                                <span>Управление</span></a>
                        </div>
                        @endrole
                        <div class="top-block__open-item">
                            <a href="{{ route('cabinet.home') }}">
                                <div class="top-block__open-img"><img src="/images/icons/user.svg"/></div>
                                <span>Личный кабинет</span></a>
                        </div>
                        <div class="top-block__open-item">
                            <a href="{{ route('cabinet.notification.index') }}">
                                <div class="top-block__open-img"><img src="/images/icons/notify.svg"/></div>
                                <div class="top-block__open-count">{{ Auth::user()->unreadNotifications()->count() }}</div>
                                <span>Уведомления</span></a>
                        </div>
                        <div class="top-block__open-exit">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="top-block__open-img"><img src="/images/icons/exit.svg"/></div>
                                <span>Выйти</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</div>
