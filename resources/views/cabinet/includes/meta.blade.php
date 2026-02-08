<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="apple-touch-icon" sizes="76x76" href="/icon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
<link rel="manifest" href="/icon/site.webmanifest">
<link rel="mask-icon" href="/icon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<title>@yield('title', config('app.name'))</title>
<meta name="description" content="@yield('description', '')">

@stack('before-styles')
<link href="{{ mix('css/cabinet.css') }}" rel="stylesheet"/>
<link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" rel="stylesheet" crossorigin="anonymous">
@stack('after-styles')
