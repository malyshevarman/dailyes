@extends('frontend.layouts.app')

@section('header')
    @include('frontend.includes.headers.text-page')
@endsection


@push('after-scripts')
    <script>
        $('.news-container').infiniteScroll({
            path: '.pagination__next',
            append: '.news-item',
            button: '.view-more-button',
            // using button, disable loading on scroll
            scrollThreshold: false,
            // status: '.page-load-status',
        });
    </script>
@endpush

@section('content')
    <div class="container-fluid search-panel oh text-page">
        <div class="container minus-15">
            <div class="row">
                <div class="col-md-12">
                    <div class="news-block">
                        <div class="row news-container bootfix-row">
                            @php
                            $newskey=0;
                            @endphp

                            @foreach ($articles as $key => $article)

                                @php
                                    $newskey=$newskey+1
                                @endphp
                                <div class="col-lg-3 col-md-6 col-sm-6 news-item bootfix-col">
                                    <div class="news-item_preview">
                                        <div class="news-item_tags-block">
                                            @foreach ($article->tags as $key => $tag)
                                            @if($key < 3)
                                            <span class="news-item_tag">
                                                {{$tag->name}}
                                            </span>
                                            @endif
                                            @endforeach
                                        </div>
                                        <a href="{{'/blog/' . $article->slug}}">
                                            <img src="{{'/storage/'.$article->preview->path}}" alt="{{$article->title}}">
                                        </a>
                                    </div>
                                    <div class="news-item_title">
                                        <a href="{{'/blog/' . $article->slug}}">{{$article->title}}</a>
                                    </div>
                                    <div class="news-item_description">
                                        {{$article->description}}
                                    </div>
                                    <div class="news-item_date">
                                        {{$article->created_at->locale('ru')->isoFormat('D MMMM YYYY') . ' г.'}}
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-12 bootfix-col">
                                <div class="row d-flex justify-content-center">
                                    <div style="display:none;" class="col-lg-6 col-sm-8">
                                        {{ $articles->appends(['text' => Request::input('text'), 'date' => Request::input('date'), 'categories' => Request::input('categories'), 'location' => Request::input('location')])->links('frontend.includes.pagination', ['paginator' => $articles]) }}
                                    </div>
                                    <div class="col-lg-3 col-sm-4 show-more">
                                        @if ($articles->lastPage() != $articles->currentPage())
                                            <a href="">
                                                <div class="view-more-button">Показать еще</div>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <blogform></blogform>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
@endpush
