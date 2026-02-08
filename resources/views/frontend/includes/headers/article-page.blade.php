@section('header-id', 'min-header-wi')

@section('header-style', "background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('$article->background_url'); background-size: cover; background-position: center center;")

@section('header-class', "resp-header full-height")

@section('title', $article->title ?? '')
@section('description', $article->description ?? '')

<div class="container mw">
    <div class="top-block">
        @include('frontend.includes.top-block-soc')
        <div class="top-block__breadcrumb">
            <ul>
                <li><a href="/">Главная</a></li>
                @foreach($page->breadcrumbs as $breadcrumb)
                    <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                @endforeach
                <li><a href="{{$page->path}}">{{ $page->name }}</a></li>
                <li>{{ $article->title }}</li>
            </ul>
        </div>
        <h1>{{ $article->title }}</h1>
        <div style="position: absolute;
                    bottom: 10%;">
            @foreach ($article->tags as $tag)
            <span style="font-family: Monsterrat-regular;
                        display: inline-block;
                        font-size: 14px;
                        line-height: 14px;
                        -webkit-box-align: center;
                        -ms-flex-align: center;
                        align-items: center;
                        color: white;
                        padding: 5px 10px;
                        margin-right: 10px;
                        border: 1px solid #fff;
                        border-radius: 13px;">
                {{$tag->name}}
            </span>
            @endforeach
            <div style="font-family: Monsterrat-regular;
                        font-size: 13px;
                        line-height: 16px;
                        color: #FFFFFF;
                        margin-top: 20px;">
                {{ $article->created_at->locale('ru')->isoFormat('D MMMM YYYY') . ' г.' }}
            </div>
        </div>
    </div>
</div>
