@php
$page = (object) array('name' => 'Карта сайта', 'h1' => 'Карта сайта', 'summary' => '', 'path' => '/sitemap', 'title' => 'Карта сайта');
@endphp

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
                    <div class="sitemap_page" style="margin-top: 50px;display: flex;justify-content: space-between;">
                        <ul>
                            <h4>Основные разделы</h4>
                            <li>
                                <a href="/about">О сервисе</a>
                            </li>
                            <li>
                                <a href="/about">Блог</a>
                            </li>
                            <li>
                                <a href="/jobs">Вакансии</a>
                            </li>
                            <li>
                                <a href="/help">Помощь</a>
                            </li>
                            <li>
                                <a href="/contacts">Контакты</a>
                            </li>
                            <li>
                                <a href="/add-company">Добавить компанию</a>
                            </li>
                            <li>
                                <a href="/add-stocks">Добавить акцию</a>
                            </li>
                            <li>
                                <a href="/ad">Реклама на сайте</a>
                            </li>
                            <li>
                                <a href="/for-business">Для вашего бизнеса</a>
                            </li>
                            <li>
                                <a href="/company">Список компаний</a>
                            </li>
                            <li>
                                <a href="/stocks">Список акций</a>
                            </li>
                        </ul>
                        <ul>
                            <!-- CompanyCategories -->
                            <h4>Категории компаний</h4>
                            @foreach(\App\CategoriesTag::whereHas('companies', function($q) {
                                $q->active()
                                ->whereHas('addresses', function ($q) {
                                    $q->where('city_id', city()->id);
                                });
                            })->get()->sortBy('name') as $tag)
                                <li>
                                    <a href="{{route('frontend.city.company.tag.show', $tag)}}">{{$tag->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <ul>
                            <!-- EventCategories -->
                            <h4>Категории акций</h4>
                            @foreach(\App\CategoriesTag::whereHas('events', function($q) {
                                $q->active()
                                ->whereHas('addresses', function ($q) {
                                    $q->where('city_id', city()->id);
                                });
                            })->get()->sortBy('name') as $tag)
                                <li>
                                    <a href="{{route('frontend.city.company.tag.show', $tag)}}">{{$tag->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        //Гармошки на странице ПОМОЩЬ
        if($('.block')) {
            $('.block-button').on('click', this, function() {
                $('.block-answer').hide();
                $('.block-button').css('transform', 'rotate(0deg)');
                $('.block-question').css('border-bottom', '1px solid #3598db');

                $(this).closest('.block').find('.block-answer').toggle();
                if ($(this).closest('.block').find('.block-answer').css('display') == 'block') {
                    $(this).closest('.block').find('.block-button').css('transform', 'rotate(45deg)');
                    $(this).closest('.block').find('.block-question').css('border-bottom', 'none');
                } else {
                    $(this).closest('.block').find('.block-button').css('transform', 'rotate(0deg)');
                    $(this).closest('.block').find('.block-question').css('border-bottom', '1px solid #3598db');
                }
            })
        }
        window.onload = function() {
            $('.block-button').each(function(index, item) {
                if($(item).closest('.block').find('.block-answer').css('display') == 'block') {
                    $(item).closest('.block').find('.block-button').css('transform', 'rotate(45deg)');
                    $(item).closest('.block').find('.block-question').css('border-bottom', 'none');
                } else {
                    $(item).closest('.block').find('.block-button').css('transform', 'rotate(0deg)');
                    $(item).closest('.block').find('.block-question').css('border-bottom', '1px solid #3598db');
                }
            })
        }
        //Навигация на странице реклама на сайте
        btns = $('.advertising_nav div ul li');
        blocks = $('.advertising_tab');

        btns.on('click', this, function (e) {
            // console.log($(this).index())
            e.preventDefault();
            btns.each(function (i, elem) {
                if ($(elem).hasClass('active')) {
                    $(elem).removeClass('active');
                }
            });
            $(this).addClass('active');
            that = $(this);
            blocks.each(function (i, elem) {
                if (that.index() == i) {
                    blocks.fadeOut(400);
                    $(elem).fadeIn('fast');
                }
            })
        });
        //Смена баннера на картинку при наведении на странице реклама на сайте
        // function createHoverImage() {
        //   document.querySelectorAll('[data-hover-src]').forEach((img) => {
        //     const src = img.getAttribute('src');
        //     const srcH = img.getAttribute('data-hover-src');

        //     img.addEventListener('mouseover', () => {img.src = srcH;})
        //     img.addEventListener('mouseout', () => {img.src = src;})
        //   });
        // }

        // createHoverImage();
        //Кнопка обратиться в поддержку на странице контакты
        $('.support-btn').on('click', this, function (e) {
            e.preventDefault()

            const blockID = $(this).attr('href').substr(1)

            document.getElementById(blockID).scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            })
        });
    </script>
@endpush
