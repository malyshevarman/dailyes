<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('frontend.includes.meta')
</head>
<body class="separate">
<div id="app">
    <header>
        @include('frontend.includes.header-menu')
    </header>
    @yield('content')
    <footer>
        @guest
            @include('frontend.includes.auth-panel')
        @endguest
        <city_select></city_select>
    </footer>
</div>

<!-- Scripts -->
@stack('before-scripts')
<script src="{{ mix('js/frontend.js') }}"></script>
@stack('after-scripts')

</body>
</html>