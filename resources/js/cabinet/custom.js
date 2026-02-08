//OWL - Carousel
var owl = $('#owl-1');
owl.owlCarousel({
    loop: true,
    margin: 15,
    nav: false,
    autoplay: true,
    center: true,
    slideSpeed: 300,
    onDragged: owl1,
    responsive: {
        0: {
            items: 1,
            center: false,
            autoplay: false,
            autoHeight: true,
            autoWidth: true
        },
        376: {
            items: 2,
            center: false
        },
        450: {
            items: 3
        },
        500: {
            items: 3
        },
        600: {
            items: 3
        },
        1000: {
            items: 4,
            center: false
        },
        1200: {
            items: 5
        }
    }
});

function owl1() {
    $('#owl-1 .owl-stage').find('.owl-item').addClass('active');
}

owl.on('changed.owl.carousel', function () {
    setTimeout(owl1, 10);
});
$('#owl-2').owlCarousel({
    loop: true,
    margin: 0,
    nav: true,
    dots: true,
    navText: ["<img src='/images/icons/arrow-white-left.svg'>", "<img src='/images/icons/arrow-white-right.svg'>"],
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});
var owll = $('#owl-3');
owll.owlCarousel({
    loop: true,
    autoplay: true,
    center: true,
    margin: 25,
    onDragged: owll,
    responsive: {
        0: {
            items: 1,
            center: true,
            autoplay: false,
            autoWidth: true
        },
        376: {
            items: 1,
            center: true,
            autoWidth: true
        },
        450: {
            items: 2,
            center: false,
            autoWidth: true
        },
        500: {
            items: 2,
            center: false,
            autoWidth: true
        },
        768: {
            items: 2,
            center: false
        },
        1000: {
            items: 3,
            center: false
        },
        1200: {
            items: 3
        }
    }
});

function owllf() {
    $('#owl-3 .owl-stage').find('.owl-item').addClass('active');
}

owll.on('changed.owl.carousel', function () {
    setTimeout(owllf, 10);
});

$('#owl-2 .owl-nav').click(function (event) {
    $(this).removeClass('disabled');
});
$('.gallery_owl').owlCarousel({
    loop: false,
    margin: 20,
    nav: true,
    slideSpeed: 300,
    navText: ["<img src='/images/icons/left.svg'>", "<img src='/images/icons/right.svg'>"],
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        992: {
            items: 3
        },
        1200: {
            items: 4
        },
        1400: {
            items: 4
        }
    }
});

$('#owl-gallery').owlCarousel({
    loop: false,
    margin: 17,
    nav: false,
    dots: false,
    slideSpeed: 300,
    navText: ["<img src='/images/icons/arrow-white-left.svg'>", "<img src='/images/icons/arrow-white-right.svg'>"],
    responsive: {
        0: {
            items: 2
        },
        600: {
            items: 2
        },
        1000: {
            items: 2
        }
    }
});

// Scroll Up
$(window).scroll(function () {
    if ($(window).scrollTop() > 600) {
        $('.to_up').show();
    } else {
        $('.to_up').hide();
    }
});

//Click function

$(document).mouseup(function (e) {
    var div = $(".search-block__filter-block");
    var close = $(".search-block__filter");

    if (!div.is(e.target)
        && div.has(e.target).length === 0) {
        if (!close.is(e.target)) {
            div.hide();
            close.removeClass('active');
        }
    }
});

$('.more_review').click(function () {
    if ($(this).hasClass('open')) {
        $(this).removeClass('open');
        $(this).text('Показать еще отзывы');
        $('.review-close').removeClass('open');
    } else {
        $(this).addClass('open');
        $(this).text('Скрыть отзывы');
        $('.review-close').addClass('open');
    }
});

$('.more_question').click(function () {
    if ($(this).hasClass('open')) {
        $(this).removeClass('open');
        $(this).text('Показать еще вопросы');
        $('.review-close').removeClass('open');
    } else {
        $(this).addClass('open');
        $(this).text('Скрыть вопросы');
        $('.review-close').addClass('open');
    }
});

$('.review-block__nav-more').click(function () {
    var block = $(this).closest('.review-block__nav').prev();
    if (block.css('height') == '105px') {
        block.css('height', 'auto');
        $(this).text('Скрыть отзыв');
    } else {
        block.css('height', '105px');
        $(this).text('Отзыв полностью');
    }
});

$('.question-block__nav-more').click(function () {
    var block = $(this).closest('.question-block__nav').prev();
    if (block.css('height') == '105px') {
        block.css('height', 'auto');
        $(this).text('Скрыть отзыв');
    } else {
        block.css('height', '105px');
        $(this).text('Отзыв полностью');
    }
});

$('.chart_active').click(function () {
    $(this).addClass('active');
    $('.chart_ended').removeClass('active');
    $('.toggle_active').show();
    $('.toggle_ended').hide();
});

$('.chart_ended').click(function () {
    $(this).addClass('active');
    $('.chart_active').removeClass('active');
    $('.toggle_active').hide();
    $('.toggle_ended').show();
});

$('.to_up').click(function () {
    $('html, body').animate({scrollTop: 0}, 800);
});

$('.authPanel').click(function () {
    $('.auth-panel').fadeToggle();
    var loginW = $('.auth-panel__option-login').width() + 2;
    var registerW = $('.auth-panel__option-register').width() + 2;
    var forgotW = $('.auth-panel__option-forgot').width() + 2;

    $('.auth-panel__option-full-login').width(loginW);
    $('.auth-panel__option-full-register').width(registerW);
    $('.auth-panel__option-full-forgot').width(forgotW);

    if ($('.mobile__nav-fix').is(':visible')) {
        $('.mobile__nav-fix').hide();
    }

    if ($(this).attr('data') == 1) {
        $('body').css('overflow', 'hidden');
    } else {
        $('body').css('overflow', 'auto');
    }

});

$('.auth-form__soc-mob-forgot').click(function () {
    $('.forgot-form').show();
    $('.auth-form').hide();
});

$('.cityPanel').click(function () {
    $('.current-city').hide();
    $('.mobile__nav-profileMenu').hide();
    $('.city-panel').fadeToggle();

    $('.mobile__nav-profile').find('.icon').removeClass('active');

    if ($('.mobile__nav-fix').is(':visible')) {
        $('.mobile__nav-fix').hide();
    }

    if ($(this).attr('data') == 1) {
        $('body').css('overflow', 'hidden');
    } else {
        $('body').css('overflow', 'auto');
    }

});

$('.search-block__filter').click(function () {
    if (screen.width <= 1000) {
        $('.filter-panel').show();
    } else {
        if ($('.search-block__filter-block').is(':visible')) {
            $('.search-block__filter-block').hide();
            $('.search-block__filter').removeClass('active');
        } else {
            $('.search-block__filter-block').show();
            $('.search-block__filter').addClass('active');
        }
    }
});

$('.filterPanel').click(function () {
    $('.filter-panel').hide();
});

$('.top-block__city .current').click(function () {
    $('.top-block__city-option').toggle();
});

$('.close_button').click(function () {
    $('.top-block__city-option').toggle();
});

$('.top-block__avatar').click(function () {
    $('.top-block__open').toggle();
    $(this).toggleClass('active');
});

$('.map-point').click(function () {
    var a = $('.owl-item.active').find('.map-point');
    var n = a.index(this);
    if (n <= 3) {
        if (n >= 0) {
            $('.map-point').removeClass('active');
            $(this).addClass('active');
        }
    }
    if ($('.owl-item.active').find('.map-point.active').parent().index()) {
        if (n <= 3) {
            if (n >= 0) {
                for (i = 0; i < n; i++) {
                    $('.owl-map-points').trigger('next.owl.carousel');
                }
            }
        }
    }
});

$('.write_review').click(function () {
    if ($(this).hasClass('open')) {
        $('.onwrite-review').hide();
        $(this).removeClass('open');
    } else {
        $('.onwrite-review').show();
        $(this).addClass('open');
    }
});

$('.write_questions').click(function () {
    if ($(this).hasClass('open')) {
        $('.onwrite-quest').hide();
        $(this).removeClass('open');
    } else {
        $('.onwrite-quest').show();
        $(this).addClass('open');
    }
});

$('.mobile__nav-menu').click(function () {
    $('.mobile__nav-fix').toggle();
    $('.mobile__nav-profile').toggle();
    $('.mobile__nav-fix').css('display') == 'block' ? $('body').css('overflow', 'hidden') : $('body').css('overflow', 'visible');
});

$('.mobile__nav-profile').click(function () {
    $('.mobile__nav-profileMenu').toggle();
    $('.mobile__nav-menu').toggle();
    $('.mobile__nav-profileMenu').css('display') == 'block' ? $('body').css('overflow', 'hidden') : $('body').css('overflow', 'visible');
});

$('.current-city__close').click(function () {
    $('.current-city').hide();
});

$('.closeReview').click(function () {
    $('.onwrite-review').hide();
    $('.write_review').removeClass('open');
});

$('.closeQuest').click(function () {
    $('.onwrite-quest').hide();
    $('.write_questions').removeClass('open');
});

$('.reviews-nav__reviews').click(function () {
    $('.reviews-rating').show();
    $('.calc-block').show();
    $('.write_review').show();
    $('.review').show();
    $('.more_review').show();
    $('.questions-block').hide();
    $('.write_questions').removeClass('open');
    $('.onwrite-quest').hide();
    $('.more_question').hide();
    var sticky = new Sticky('.selector');
});

$('.reviews-nav__questions').click(function () {
    $('.reviews-rating').hide();
    $('.calc-block').hide();
    $('.write_review').hide();
    $('.review').hide();
    $('.more_review').hide();
    $('.more_question').hide();
    $('.questions-block').show();
    $('.onwrite-review').hide();
    $('.write_review').removeClass('open');
    var sticky = new Sticky('.selector');
});

$('.openComments').click(function () {
    $(this).closest('.review-block').next().toggle();
});

$('.openQuestion').click(function () {
    $(this).closest('.question-block').next().toggle();
});

$('.question-block__comments-hide').click(function () {
    $(this).closest('.question-block__comments').hide();
});

$('.review-block__comments-hide').click(function () {
    $(this).closest('.review-block__comments').hide();
});

$('.reviews-nav__reviews').click(function () {
    $(this).addClass('active');
    $('.reviews-nav__questions').removeClass('active');
});

$('.reviews-nav__questions').click(function () {
    $(this).addClass('active');
    $('.reviews-nav__reviews').removeClass('active');
});

$('.clear_filter').click(function () {
    $('#filter_form')[0].reset();
    $("#ex21").bootstrapSlider('setValue', 3);
    $('.change-sort-raiting').removeClass('active');
    $('.change-sort-views').removeClass('active');
    $('.change-sort-views').find('i').hide();
    $('.change-sort-raiting').find('i').hide();
    $('.sort-raiting').val(0);
    $('.sort-views').val(0);
    calendar();
});

$('.clear_filterm').click(function () {
    $('#filter_form-mobile')[0].reset();
    $("#ex21mob").bootstrapSlider('setValue', 3);
    $('.change-sort-raiting').removeClass('active');
    $('.change-sort-views').removeClass('active');
    $('.change-sort-views').find('i').hide();
    $('.change-sort-raiting').find('i').hide();
    $('.sort-raiting').val(0);
    $('.sort-views').val(0);
    calendarMobile();
    $('.drp-calendar.left').append('<th class="next available"><span></span></th>');
});

$('#filter_1').click(function () {
    $('#filter_1').addClass('active');
    $('#filter_2').removeClass('active');
    $('#filter_3').removeClass('active');
    $('.filter_1').show();
    $('.filter_2').hide();
    $('.filter_3').hide();
});

$('#filter_2').click(function () {
    $('#filter_2').addClass('active');
    $('#filter_1').removeClass('active');
    $('#filter_3').removeClass('active');
    $('.filter_1').hide();
    $('.filter_2').show();
    $('.filter_3').hide();
});

$('#filter_3').click(function () {
    $('#filter_3').addClass('active');
    $('#filter_2').removeClass('active');
    $('#filter_1').removeClass('active');
    $('.filter_1').hide();
    $('.filter_2').hide();
    $('.filter_3').show();
});

$('#filterMob_1').click(function () {
    $('#filterMob_1').addClass('active');
    $('#filterMob_2').removeClass('active');
    $('#filterMob_3').removeClass('active');
    $('.mobfilter_1').show();
    $('.mobfilter_2').hide();
    $('.mobfilter_3').hide();
});

$('#filterMob_2').click(function () {
    $('#filterMob_2').addClass('active');
    $('#filterMob_1').removeClass('active');
    $('#filterMob_3').removeClass('active');
    $('.mobfilter_1').hide();
    $('.mobfilter_2').show();
    $('.mobfilter_3').hide();
});

$('#filterMob_3').click(function () {
    $('#filterMob_3').addClass('active');
    $('#filterMob_2').removeClass('active');
    $('#filterMob_1').removeClass('active');
    $('.mobfilter_1').hide();
    $('.mobfilter_2').hide();
    $('.mobfilter_3').show();
});

$('.text-block__more').click(function () {
    var height = $(this).prev().css('max-height');
    if (height == '350px') {
        $(this).prev().css('max-height', 'initial');
        $(this).find('span').text('Скрыть текст');
    } else {
        $(this).prev().css('max-height', '350px');
        $(this).find('span').text('Читать полностью');
    }
});

$('.change-sort-raiting').click(function () {
    var sort = $(this).find('input').val();
    if (sort <= 2) {
        sort++;
        if (sort == 1) {
            $(this).find('.iup').show();
        }
        if (sort == 2) {
            $(this).find('.idown').show();
            $(this).find('.iup').hide();
        }
        $(this).find('input').val(sort);
        $(this).addClass('active');
    }
    if (sort == 3) {
        $(this).removeClass('active');
        $(this).find('input').val(0);
        $(this).find('.idown').hide();
    }
});

$('.change-sort-views').click(function () {
    var sort = $(this).find('input').val();
    if (sort <= 2) {
        sort++;
        if (sort == 1) {
            $(this).find('.iup').show();
        }
        if (sort == 2) {
            $(this).find('.idown').show();
            $(this).find('.iup').hide();
        }
        $(this).find('input').val(sort);
        $(this).addClass('active');
    }
    if (sort == 3) {
        $(this).removeClass('active');
        $(this).find('input').val(0);
        $(this).find('.idown').hide();
    }
});

$('.lk-body__trigger-url').click(function () {
    var data = $(this).attr('data');
    $('.lk-body__trigger-url').removeClass('active');
    $(this).addClass('active');
    if (data == 1) {
        $('.trigger_events').show();
        $('.trigger_company').hide();
    } else {
        $('.trigger_events').hide();
        $('.trigger_company').show();
    }
});

$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

// Calendar

function calendar() {
    var picker = $('.date-picker').daterangepicker({
        autoApply: true,
        parentEl: "#daterangepicker1-container",
        locale: {
            format: 'Y/MM/DD',
            "applyLabel": "Принять",
            "separator": "_",
            "cancelLabel": "Отменить",
            "fromLabel": "От",
            "toLabel": "До",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "ПН",
                "ВТ",
                "СР",
                "ЧТ",
                "ПТ",
                "СБ",
                "ВС"
            ],
            "monthNames": [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ]
        }
    });
    picker.on('apply.daterangepicker', function (ev, picker) {
        $('.date-picker').val(picker.startDate.format('YYYY-MM-DD') + '_' + picker.endDate.format('YYYY-MM-DD'));
    });
    if ($('.daterangepicker').length) {
        picker.data('daterangepicker').hide = function () {
        };
        picker.data('daterangepicker').show();
    }
}

function calendarMobile() {
    var picker = $('.date-picker-mobile').daterangepicker({
        autoApply: true,
        parentEl: "#daterangepicker1-container-mobile",
        locale: {
            format: 'Y/MM/DD',
            "applyLabel": "Принять",
            "separator": "_",
            "cancelLabel": "Отменить",
            "fromLabel": "От",
            "toLabel": "До",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "ПН",
                "ВТ",
                "СР",
                "ЧТ",
                "ПТ",
                "СБ",
                "ВС"
            ],
            "monthNames": [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ]
        }
    });
    picker.on('apply.daterangepicker', function (ev, picker) {
        $('.date-picker').val(picker.startDate.format('YYYY-MM-DD') + '_' + picker.endDate.format('YYYY-MM-DD'));
    });
    if ($('.daterangepicker').length) {
        picker.data('daterangepicker').hide = function () {
        };
        picker.data('daterangepicker').show();
    }
}

//Range

function change_range(num) {
    $("#ex21").bootstrapSlider('setValue', num);
}

function change_rangemob(num) {
    $("#ex21mob").bootstrapSlider('setValue', num);
}

// Document Ready
$(document).ready(function () {
    owl1();
    owllf();
    $('.auth-panel__option div').click(function () {
        $('.auth-panel__option div').removeClass('active');
        $(this).addClass('active');
        var index = $(this).index();
        var count = $('.auth-panel__option-login').width() + 40;
        $('.auth-panel__option-full div').removeClass('active-full');
        $('.auth-panel__option-full div:eq(' + index + ')').addClass('active-full');
        if (index == 0) {
            $('.auth-form').show();
            $('.reg-form').hide();
            $('.forgot-form').hide();
            $('#change').text('Добро пожаловать!');
        }
        if (index == 1) {
            $('.auth-panel__option-full div:eq(' + index + ')').css('margin-left', count + 'px');
            $('.auth-form').hide();
            $('.reg-form').show();
            $('.forgot-form').hide();
            $('#change').text('Регистрация');
        }
        if (index == 2) {
            $('.auth-form').hide();
            $('.reg-form').hide();
            $('.forgot-form').show();
            $('#change').text('Восстановить пароль');
        }
    });
    $('.open-password').click(function () {
        if ($('.open-password').prev('.auth-form__input').attr('type') == 'text') {
            $('.open-password').prev('.auth-form__input').attr('type', 'password');
            $(this).removeClass('active');
        } else {
            $('.open-password').prev('.auth-form__input').attr('type', 'text');
            $(this).addClass('active');
        }
    });

    if ($('.review-close').length) {
        if ($('.review').length < 3) {
            $('.more_review').hide();
        }
    }

    if ($('.question-close').length) {
        if ($('.question').length < 3) {
            $('.more_question').hide();
        }
    }

    $(".auth-form").validate({
        errorPlacement: function (error, element) {
        },
        errorClass: 'error',
        rules: {
            email: {
                email: true,
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                email: '',
                required: ''
            },
            password: {
                required: ''
            }
        }
    });

    $(".reg-form").validate({
        errorPlacement: function (error, element) {
        },
        errorClass: 'error',
        rules: {
            name: {
                required: true
            },
            email: {
                email: true,
                required: true
            },
            password: {
                required: true
            },
            agree: {
                required: true
            }
        },
        messages: {
            name: {
                required: ''
            },
            email: {
                email: '',
                required: ''
            },
            password: {
                required: ''
            },
            agree: {
                required: ''
            }
        }
    });

    $(".forgot-form").validate({
        errorPlacement: function (error, element) {
        },
        errorClass: 'error',
        rules: {
            email: {
                email: true,
                required: true
            }
        },
        messages: {
            email: {
                email: '',
                required: ''
            }
        }
    });

    $('#city-seacrh').keyup(function () {
        if ($(this).val() != '') {
            $('.all-city').hide();
            $('.city-theme').hide();
            $('.group_city').hide();
            s = $(this).val();
            s = s.charAt(0).toUpperCase() + s.substr(1);
            $('.city-panel__list').find('li:contains("' + s + '")').show();
            t = s.charAt(0).toUpperCase();
            $('.city-theme:contains("' + t + '")').show();
            $('.city-theme:contains("' + t + '")').parent().show();
            if ($('.city-panel__list').find('li:contains("' + s + '")').length == 0) {
                $('.group_city').hide();
                $('.city-panel__not').show();
            } else {
                $('.city-panel__not').hide();
            }
        } else {
            $('.all-city').show();
            $('.city-theme').show();
            $('.group_city').show();
            $('.city-panel__not').hide();
        }
    });

    $('#city-mobseacrh').keyup(function () {
        if ($(this).val() != '') {
            $('.all-city').hide();
            $('.city-theme').hide();
            $('.group_city').hide();
            s = $(this).val();
            s = s.charAt(0).toUpperCase() + s.substr(1);
            $('.city-panel__list').find('li:contains("' + s + '")').show();
            t = s.charAt(0).toUpperCase();
            $('.city-theme:contains("' + t + '")').show();
            $('.city-theme:contains("' + t + '")').parent().show();
            if ($('.city-panel__list').find('li:contains("' + s + '")').length == 0) {
                $('.group_city').hide();
                $('.city-panel__not').show();
            } else {
                $('.city-panel__not').hide();
            }
        } else {
            $('.all-city').show();
            $('.city-theme').show();
            $('.group_city').show();
            $('.city-panel__not').hide();
        }
    });

    calendar();

    $('#ex21').bootstrapSlider();

    $('#ex21mob').bootstrapSlider();

    if (screen.width == 768) {
        $('.subscribe-block__search-politic').remove().insertAfter('.subscribe-block__text');
    }

    if (screen.width <= 768) {
        if ($('.service_gallery').length > 0) {
            $('.service_gallery').addClass('owl-carousel');
            $('.service_gallery').owlCarousel({
                margin: 10,
                nav: false,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    400: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    1000: {
                        items: 3
                    }
                }
            });
        }
        $('.search-block__filter').html('<img src="/images/icons/settings.svg" />');
    }

    if (screen.width <= 767) {
        $('.search-block__input').attr('placeholder', 'Поиск');
    }
    if (screen.width <= 1000) {
        calendarMobile();
        $('.drp-calendar.left').append('<th class="next available"><span></span></th>');
    }

    if ($('.filter_2').length != 0) {
        new SimpleBar($('.filter_2')[0]);
    }

    if ($('.owl-map-points').length != 0) {
        ymaps.load(function () {
            $('.target-0').click();
            if (screen.width == 768) {
                $('.owl-map-points').find('.owl-nav').append('<img class="map-shadow" src="/images/map-contact-shadow.png" />');
            }
        });
    }

    if ($('.text-global-block').length != 0) {
        $('.review-block__text').each(function () {
            if ($(this).text().length >= 425) {
                $(this).closest('.review-block').find('.review-block__nav-more').show();
            }
        });
        $('.question-block__text').each(function () {
            if ($(this).text().length >= 425) {
                $(this).closest('.question').find('.question-block__nav-more').show();
            }
        });
        var text = $('.text-block__text').text();
        if (text.length >= 900) {
            $('.text-block__more').show();
        }
    }

    var iev = 0;
    var ieold = (/MSIE (\d+\.\d+);/.test(navigator.userAgent));
    var trident = !!navigator.userAgent.match(/Trident\/7.0/);
    var rv = navigator.userAgent.indexOf("rv:11.0");

    if (ieold) iev = new Number(RegExp.$1);
    if (navigator.appVersion.indexOf("MSIE 10") != -1) iev = 10;
    if (trident && rv != -1) iev = 11;

    if (iev == '11') {
        if ($('.top-block__nav').length != 0) {
            $('.top-block__nav').find('.v-align').addClass('ie-fix');
        }
    }

    if ($('#filter_form').length != 0) {
        if ($('#filter_1').length == 0) {
            $('#filter_2').click();
        }
    }

    if ($('.reviews-rating__progress-place').length != 0) {
        function rewidth() {
            var width = [];
            $(".reviews-rating__progress").find('.reviews-rating__progress-place').each(function (indx, element) {
                width.push($(element).width());
            });
            var min = Math.min.apply(null, width);
            $('.reviews-rating__progress-place').css('width', min);
        }

        setTimeout(rewidth, 100);
    }
});

//Style Mobile Function

if ((navigator.userAgent.indexOf("MSIE") != -1) || (!!document.documentMode == true)) {
    $('.subscribe-block__form-table').css('display', 'block');
    $('.search-block__form-table').css('display', 'block');
    $('.city-mh').find('form').css('position', 'relative');
    $('.city-mh').find('button').css('position', 'absolute');
}

$(window).resize(function () {
    if (screen.width <= 768) {
        $('.search-block__input').attr('placeholder', 'Поиск');
        $('.subscribe-block__search-politic').remove().insertAfter('.subscribe-block__text');
        if ($('.service_gallery').length > 0) {
            $('.service_gallery').addClass('owl-carousel');
            $('.owl-carousel').owlCarousel({
                margin: 10,
                nav: false,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    500: {
                        items: 3
                    },
                    1000: {
                        items: 3
                    }
                }
            });
        }
        $('.search-block__filter').html('<img src="/images/icons/settings.svg" />');
    } else {
        $('.search-block__input').attr('placeholder', 'Найти акцию или компанию');
        $('.subscribe-block__search-politic').remove().insertAfter('.subscribe-block__search');
        if ($('.service_gallery').length > 0) {
            $('.owl-carousel').trigger('destroy.owl.carousel');
            $('.service_gallery').removeClass('owl-carousel');
        }
        $('.search-block__filter').html('Фильтр<img class="search-block__filter-img" src="/images/icons/filter-open.svg">');
    }
});

$(".search-block__input").focus(function () {
    $('.search-block__glass').css('background', '#1376CB');
});

$(".search-block__input").focusout(function () {
    $('.search-block__glass').css('background', '#1D86E0');
});

$(".subscribe-block__search-input").focus(function () {
    $('.subscribe-block__search-button').css('background', '#1376CB');
});

$(".subscribe-block__search-input").focusout(function () {
    $('.subscribe-block__search-button').css('background', '#1D86E0');
});
