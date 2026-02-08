@section('header-id', 'min-header')

@section('header-class', "text")

@section('title', $page->title ?? '')
@section('description', $page->description ?? '')

<div class="container mw">
    <div class="top-block">
        <div class="top-block__breadcrumb">
            <ul>
                <li><a href="/">Главная</a></li>
                {{--@foreach($page->breadcrumbs as $breadcrumb)
                                                    <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                                                @endforeach--}}
                <li>{{ $page->name }}</li>
            </ul>
        </div>
        <h1>{{ $page->h1 }}</h1>
        <div class="top-block__desc">
            @if($page->h1 =='О сервисе')
                Dailyes – это сервис с ежедневными акциями и предложениями в г. {{$city->name}} и других городах России
                @else
                {!! nl2br(e($page->summary)) !!}
                @endif

        </div>
    </div>
</div>
