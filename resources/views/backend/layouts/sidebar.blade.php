<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/admin/dashboard">
                    <i class="nav-icon icon-speedometer"></i> Панель управления
                </a>
            </li>
            <li class="nav-title">Настройки</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Пользователи</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users">
                            <i class="nav-icon icon-people"></i> Список юзеров
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/roles">
                            <i class="nav-icon icon-key"></i> Роли
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/category">
                    <i class="nav-icon icon-key"></i> Категории
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/tags">
                    <i class="nav-icon icon-key"></i> Теги категорий
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Акции <sup>{{\App\Event::where('rejected', 0)
                                                                                ->where('published', 0)->count()}}</sup>
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/event">
                            <i class="nav-icon icon-key"></i> Список акций
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="/admin/event/category">
                            <i class="nav-icon icon-key"></i> Категории акций
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/event/label">
                            <i class="nav-icon icon-key"></i> Лейблы акций
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Компании <sup>{{\App\Company::where('rejected', 0)
                                                                                ->where('published', 0)->count()}}</sup>
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/company">
                            <i class="nav-icon icon-key"></i> Список компаний
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="/admin/company/category">
                            <i class="nav-icon icon-key"></i> Категории компаний
                        </a>
                    </li> -->
                </ul>
            </li>
            <!-- <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Сборки</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/selection">
                            <i class="nav-icon icon-key"></i> Сборки
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/slide">
                            <i class="nav-icon icon-key"></i> Рейтинги
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/tile">
                            <i class="nav-icon icon-key"></i> Плитки
                        </a>
                    </li>
            <!--     </ul>
            </li> -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Баннеры</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/banner">
                            <i class="nav-icon icon-key"></i> Список баннеров
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/banner/place">
                            <i class="nav-icon icon-key"></i> Места баннеров
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Отзывы</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/comment">
                            <i class="nav-icon icon-key"></i> Список отзывов <sup>{{\App\Comment::where('is_moderated', 0)->count()}}</sup>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/comment/answer">
                            <i class="nav-icon icon-key"></i> Список ответов
                        </a>
                    </li>
                </ul>
            </li>
            <!-- <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Вопросы</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/question">
                            <i class="nav-icon icon-key"></i> Список вопросов
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/question/answer">
                            <i class="nav-icon icon-key"></i> Список ответов
                        </a>
                    </li>
                </ul>
            </li> -->
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Жалобы <sup>{{\App\Report::where('is_moderated', 0)->count()}}</sup></a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/report">
                            <i class="nav-icon icon-key"></i> Список жалоб
                        </a>
                    </li>
                </ul>
            </li>
            <!-- <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-puzzle"></i> Жалобы</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/report">
                            <i class="nav-icon icon-key"></i> Акции
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/report/company">
                            <i class="nav-icon icon-key"></i> Компании
                        </a>
                    </li>
                </ul>
            </li> -->

            <li class="nav-item">
                <a class="nav-link" href="/admin/city">
                    <i class="nav-icon icon-key"></i> Города
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/page">
                    <i class="nav-icon icon-key"></i> Страницы
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/subscriber">
                    <i class="nav-icon icon-key"></i> Подписчики
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/article">
                    <i class="nav-icon icon-key"></i> Список новостей
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/newsletter">
                    <i class="nav-icon icon-key"></i> Список рассылок
                </a>
            </li>
        </ul>
    </nav>
    <sidebar></sidebar>
</div>
