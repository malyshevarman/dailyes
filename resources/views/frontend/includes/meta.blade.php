<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="manifest" href="/icon/site.webmanifest">
<link rel="icon" type="image/x-icon" href="/icon/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<link rel="canonical" href="{{url()->current()}}">
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user(),
        'userCompanyCount' => !is_null(Auth::user()) ? Auth::user()->companies()->count() : ''
      ]) !!};
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

{!! SEO::generate() !!}

@stack('before-styles')
    @if (isset($page) && $page->name == 'Контакты')
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
        />
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    @endif
<link href="{{ mix('css/frontend.css') }}" rel="stylesheet"/>
<link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" rel="stylesheet" crossorigin="anonymous">
@stack('after-styles')
