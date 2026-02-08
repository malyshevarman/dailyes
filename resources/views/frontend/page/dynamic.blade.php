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
                    @if($page->name == 'упс')

                        <div class="block_adv">
                            <div class="block_adv_left">
                                <div class="adv_subheader">Рекламные продукты</div>
                                <div class="adv_header">Перетяжка на главной странице
                                </div>
                                <div class="adv_desc">
                                    Размещение рекламы на Dailyes - эффективный способ привлекать аудиторию на ваш сайт.
                                    CTR банеров на сайте составляет от 0,25. То есть, минимум 25 переходов с 1000 показов обьявления.
                                </div>
                                <div class="adv_property">
                                    Версия для ПК: <span class="color">CTR 0,4%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильная версия: <span class="color">CTR 0,4%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильное приложение: <span class="color">CTR 0,4%</span>
                                </div>

                            </div>
                            <div class="block_adv_right">
                                <img src="/images/adv/adv_one.png"/>
                            </div>
                        </div>

                        <div class="block_adv">
                            <div class="block_adv_left">
                                <div class="adv_subheader">Рекламные продукты</div>
                                <div class="adv_header">Перетяжка на станице поиска акции</div>
                                <div class="adv_desc">

                                </div>
                                <div class="adv_property">
                                    Версия для ПК: <span class="color">CTR 0,4%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильная версия: <span class="color">CTR 0,3%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильное приложение: <span class="color">CTR 0,2%</span>
                                </div>

                            </div>
                            <div class="block_adv_right">
                                <img src="/images/adv/adv_one.png"/>
                            </div>
                        </div>


                        <div class="block_adv">
                            <div class="block_adv_left">
                                <div class="adv_subheader">Рекламные продукты</div>
                                <div class="adv_header">Перетяжка на станице поиска Компании</div>
                                <div class="adv_desc">

                                </div>
                                <div class="adv_property">
                                    Версия для ПК: <span class="color">CTR 0,2%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильная версия: <span class="color">CTR 0,2%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильное приложение: <span class="color">CTR 0,4%</span>
                                </div>

                            </div>
                            <div class="block_adv_right">
                                <img src="/images/adv/adv_3.png"/>
                            </div>
                        </div>


                        <div class="block_adv">
                            <div class="block_adv_left">
                                <div class="adv_subheader">Рекламные продукты</div>
                                <div class="adv_header">вертикальный рекламный баннер
                                    на странице акции (слайдер)</div>
                                <div class="adv_desc">

                                </div>
                                <div class="adv_property">
                                    Версия для ПК: <span class="color">CTR 0,1%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильная версия: <span class="color">CTR 0,1%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильное приложение: <span class="color">CTR 0,4%</span>
                                </div>

                            </div>
                            <div class="block_adv_right">
                                <img src="/images/adv/adv_4.png"/>
                            </div>
                        </div>



                        <div class="block_adv">
                            <div class="block_adv_left">
                                <div class="adv_subheader">Рекламные продукты</div>
                                <div class="adv_header">вертикальный рекламный баннер
                                    на странице акции (динамичный)</div>
                                <div class="adv_desc">

                                </div>
                                <div class="adv_property">
                                    Версия для ПК: <span class="color">CTR 0,1%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильная версия: <span class="color">CTR 0,1%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильное приложение: <span class="color">CTR 0,4%</span>
                                </div>

                            </div>
                            <div class="block_adv_right">
                                <img src="/images/adv/adv_5.png"/>
                            </div>
                        </div>



                        <div class="block_adv">
                            <div class="block_adv_left">
                                <div class="adv_subheader">Рекламные продукты</div>
                                <div class="adv_header">вертикальный рекламный баннер
                                    на странице компании (слайдер)</div>
                                <div class="adv_desc">

                                </div>
                                <div class="adv_property">
                                    Версия для ПК: <span class="color">CTR 0,1%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильная версия: <span class="color">CTR 0,1%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильное приложение: <span class="color">CTR 0,4%</span>
                                </div>

                            </div>
                            <div class="block_adv_right">
                                <img src="/images/adv/adv_6.png"/>
                            </div>
                        </div>


                        <div class="block_adv">
                            <div class="block_adv_left">
                                <div class="adv_subheader">Рекламные продукты</div>
                                <div class="adv_header">вертикальный рекламный баннер
                                    на странице компании (динамичный)</div>
                                <div class="adv_desc">

                                </div>
                                <div class="adv_property">
                                    Версия для ПК: <span class="color">CTR 0,1%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильная версия: <span class="color">CTR 0,1%</span>
                                </div>
                                <div class="adv_property">
                                    Мобильное приложение: <span class="color">CTR 0,4%</span>
                                </div>

                            </div>
                            <div class="block_adv_right">
                                <img src="/images/adv/adv_7.png"/>
                            </div>
                        </div>
                    @else
                        {!! $page->content !!}
                    @endif

                    @if ($page->name == 'Контакты')
                    <!-- <contactmap></contactmap> -->
                    <div class="contacts-map">
                        <div class="contacts-map-title">
                            <!-- <p>Служба поддержки</p>
                            <a class="support-btn" href="#contact-form">Обратиться в поддержку</a> -->
                            <p>Служба поддержки</p>
                            <span>Сообщить об ошибке:</span>
                            <a href="mailto:support@dailyes.ru">support@dailyes.ru</a>
                            <p>Для партнёров</p>
                            <span>Предложение по сотрудничеству:</span>
                            <a href="mailto:biz@dailyes.ru">biz@dailyes.ru</a>
                            <!-- <span>или позвоните по телефону</span>
                            <a href="tel:8 800 000 00 00">8 800 000 00 00</a> -->
                        </div>
                        <div class="rekvizity">
                            <div class="title">Реквизиты</div>
                            <div class="name">ИП Анисимов Юрий Вадимович</div>
                            <div class="data">
                                <table>
                                    <tr>
                                        <td>ИНН:</td>
                                        <td>332744719511</td>
                                    </tr>
                                    <tr>
                                        <td>ОГРНИП:</td>
                                        <td>316332800057853</td>
                                    </tr>
                                    <tr>
                                        <td>Адрес:</td>
                                        <td>600017, г. Владимир, ул. Мира, 15-95</td>
                                    </tr>
                                    <tr>
                                        <td>Эл. почта:</td>
                                        <td>hello@dailyes.ru</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <contactform></contactform>
                    @endif
                    @if ($page->name == 'Помощь' || $page->name == 'Добавить компанию' || $page->name == 'Добавить акцию')
                    <questionform></questionform>
                    @endif
                    @if ($page->name == 'Реклама на сайте')
                    <div class="advertising_manager">
                        <div class="advertising_manager_img">
                            <img src="../../images/pages/advertising/manager.png">
                        </div>
                        <div class="advertising_manager_title">
                            <p>О вашей компании и акциях расскажет:</p>
                            <p>Менеджер по рекламе интернет-проектов</p>
                            <p>Юрий Алексеев</p>
                            <p>e-mail: ad@dailyes.ru</p>
                        </div>
                    </div>
                    <advertisingform></advertisingform>
                    @endif
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
