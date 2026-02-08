<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('frontend.includes.meta')
</head>
<body class="not-found">
<div class="parent">
    <div class="block">
        <div class="not-found__title">
            404
        </div>
        <div class="not-found__desc">
            Страница, которую вы ищите, не существует или она была удалена<br>
            Рекомендуем вам вернуться на главную страницу.
        </div>
        <div class="not-found__button">
            <a href="/" class="h-align"><span class="not-found__button-place v-align">Главная страница <img
                            src="/images/icons/left-arrow.png"></span></a>
        </div>
    </div>
</div>
</body>
</html>