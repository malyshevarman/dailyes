$('#owl-banner-main').owlCarousel({
    loop: $('#owl-banner-main').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

// $('.contacts-block_list_slider').owlCarousel({
//     loop: 0,
//     margin: 0,
//     nav: true,
//     autoplay: false,
//     autoplayTimeout: 30000,
//     center: false,
//     slideSpeed: 300,
//     mouseDrag:true,
//     responsive: {
//         0: {
//             items: 1,
//         },
//         760: {
//             items: 2,
//         },
//         1024: {
//             items: 4,
//         }
//     }
// });


$('#owl-banner-main-mobile').owlCarousel({
    loop: $('#owl-banner-main-mobile').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});




$('#owl-event-list-1').owlCarousel({
    loop: $('#owl-event-list-1').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-event-list-2').owlCarousel({
    loop: $('#owl-event-list-2').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-event-list-3').owlCarousel({
    loop: $('#owl-event-list-3').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-event-list-1-mobile').owlCarousel({
    loop: $('#owl-event-list-1-mobile').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-event-list-2-mobile').owlCarousel({
    loop: $('#owl-event-list-2-mobile').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-event-list-3-mobile').owlCarousel({
    loop: $('#owl-event-list-3-mobile').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-company-list-1').owlCarousel({
    loop: $('#owl-company-list-1').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-company-list-2').owlCarousel({
    loop: $('#owl-company-list-2').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-company-list-3').owlCarousel({
    loop: $('#owl-company-list-3').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-company-list-1-mobile').owlCarousel({
    loop: $('#owl-company-list-1-mobile').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-company-list-2-mobile').owlCarousel({
    loop: $('#owl-company-list-2-mobile').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

$('#owl-company-list-3-mobile').owlCarousel({
    loop: $('#owl-company-list-3-mobile').find('a').length > 1,
    margin: 0,
    nav: false,
    autoplay: true,
    autoplayTimeout: 30000,
    center: false,
    slideSpeed: 300,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
        }
    }
});

if ($('#owl-card-1').length) {
    $('#owl-card-1').trigger('destroy.owl.carousel');
    $('#owl-card-1').owlCarousel({
        loop: $('#owl-card-1').find('a').length > 1,
        margin: 0,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 30000,
        center: true,
        slideSpeed: 300,
        mouseDrag:false,
        touchDrag : false,
        responsive: {
            0: {
                items: 1,
            },
            500: {
                items: 1,
            },
            768: {
                items: 1,
            }
        }
    });
}

if ($('#owl-card-2').length) {
    $('#owl-card-2').trigger('destroy.owl.carousel');
    $('#owl-card-2').owlCarousel({
        loop: $('#owl-card-2').find('a').length > 1,
        margin: 0,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 30000,
        center: false,
        slideSpeed: 300,
        mouseDrag:false,
        touchDrag : false,
        responsive: {
            0: {
                items: 1,
            }
        }
    });
}

if ($('#owl-card-3').length) {
    $('#owl-card-3').trigger('destroy.owl.carousel');
    $('#owl-card-3').owlCarousel({
        loop: $('#owl-card-3').find('a').length > 1,
        margin: 0,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 30000,
        center: false,
        slideSpeed: 300,
        mouseDrag:false,
        touchDrag : false,
        responsive: {
            0: {
                items: 1,
            }
        }
    });
}

if ($('#owl-card-4').length) {
    $('#owl-card-4').trigger('destroy.owl.carousel');
    $('#owl-card-4').owlCarousel({
        loop: $('#owl-card-4').find('a').length > 1,
        margin: 0,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 30000,
        center: false,
        slideSpeed: 300,
        mouseDrag:false,
        touchDrag : false,
        responsive: {
            0: {
                items: 1,
            }
        }
    });
}


if ($('#owl-card-1-mobile').length) {
    $('#owl-card-1-mobile').trigger('destroy.owl.carousel');
    $('#owl-card-1-mobile').owlCarousel({
        loop: $('#owl-card-1-mobile').find('a').length > 1,
        margin: 0,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 30000,
        center: true,
        slideSpeed: 300,
        mouseDrag:false,
        touchDrag : false,
        responsive: {
            0: {
                items: 1,
            },
            500: {
                items: 1,
            },
            768: {
                items: 1,
            }
        }
    });
}

if ($('#owl-card-2-mobile').length) {
    $('#owl-card-2-mobile').trigger('destroy.owl.carousel');
    $('#owl-card-2-mobile').owlCarousel({
        loop: $('#owl-card-2-mobile').find('a').length > 1,
        margin: 0,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 30000,
        center: false,
        slideSpeed: 300,
        mouseDrag:false,
        touchDrag : false,
        responsive: {
            0: {
                items: 1,
            }
        }
    });
}

if ($('#owl-card-3-mobile').length) {
    $('#owl-card-3-mobile').trigger('destroy.owl.carousel');
    $('#owl-card-3-mobile').owlCarousel({
        loop: $('#owl-card-3-mobile').find('a').length > 1,
        margin: 0,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 30000,
        center: false,
        slideSpeed: 300,
        mouseDrag:false,
        touchDrag : false,
        responsive: {
            0: {
                items: 1,
            }
        }
    });
}

if ($('#owl-card-4-mobile').length) {
    $('#owl-card-4-mobile').trigger('destroy.owl.carousel');
    $('#owl-card-4-mobile').owlCarousel({
        loop: $('#owl-card-4-mobile').find('a').length > 1,
        margin: 0,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 30000,
        center: false,
        slideSpeed: 300,
        mouseDrag:false,
        touchDrag : false,
        responsive: {
            0: {
                items: 1,
            }
        }
    });
}

//OWL - Carousel
var owl = $('#owl-1');
var owlCol = $('#owl-1').find('a').length;
var cond = true;
if (owlCol < 6) {
    cond = false;
}
owl.owlCarousel({
    loop: cond,
    margin: 15,
    // nav: true,
    slideSpeed: 300,
    mouseDrag:true,
    // autoWidth: true,
    // navText: ["<img src='/images/icons/left.svg'>", "<img src='/images/icons/right.svg'>"],
    responsive: {
        0: {
            items: 1,
            stagePadding: 20,
            autoWidth: true,
        },
        600: {
            items: 3
        },
        992: {
            items: 3
        },
        1200: {
            items: 5
        },
        1400: {
            items: 5
        }
    }
});

// function owl1() {
//     $('#owl-1 .owl-stage').find('.owl-item').addClass('active');
// }

// owl.on('changed.owl.carousel', function () {
//     setTimeout(owl1, 10);
// });
$('#owl-2').owlCarousel({
    loop: true,
    margin: 0,
    // nav: false,
    // autoplay: true,
    dots: true,
    mouseDrag:false,
    // navText: ["<img src='/images/icons/arrow-white-left.svg'>", "<img src='/images/icons/arrow-white-right.svg'>"],
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
var owlColl = $('#owl-3').find('a').length;
var condd = true;
if (owlColl < 4) {
    condd = false;
}
owll.owlCarousel({
    loop: condd,
    autoplay: true,
    center: condd,
    margin: 15,
    // onDragged: owll,
    mouseDrag:false,
    responsive: {
        0: {
            items: 1,
            center: false,
            autoplay: false,
            // loop: false,
            autoWidth: true,
        },
        // 376: {
        //     items: 1,
        //     center: true,
        //     // autoWidth: true,
        // },
        // 450: {
        //     items: 2,
        //     center: false,
        //     // autoWidth: true,
        // },
        500: {
            items: 2,
            center: false,
            loop: false
            // autoWidth: true,
        },
        768: {
            items: 2,
            center: false,
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


// function owllf() {
//     $('#owl-3 .owl-stage').find('.owl-item').addClass('active');
// }

// owll.on('changed.owl.carousel', function () {
//     setTimeout(owllf, 10);
// });

$('#owl-2 .owl-nav').click(function (event) {
    $(this).removeClass('disabled');
});

if ($('.gallery_owl_selection').length) {
    $('.gallery_owl_selection').owlCarousel('destroy');
    $('.gallery_owl_selection').owlCarousel({
        loop: false,
        margin: 20,
        // nav: true,
        slideSpeed: 300,
        mouseDrag:false,
        // navText: ["<img src='/images/icons/left.svg'>", "<img src='/images/icons/right.svg'>"],
        responsive: {
            0: {
                items: 1,
                nav: false,
                stagePadding: 20,
            },
            600: {
                items: 2
            },
            992: {
                items: 2
            },
            1200: {
                items: 2
            },
            1400: {
                items: 2
            }
        }
    });
}

if ($('.gallery_owl').length) {
    $('.gallery_owl').owlCarousel('destroy');
    $('.gallery_owl').owlCarousel({
        loop: false,
        margin: 20,
        // nav: true,
        slideSpeed: 300,
        mouseDrag:false,
        // navText: ["<img src='/images/icons/left.svg'>", "<img src='/images/icons/right.svg'>"],
        responsive: {
            0: {
                items: 1,
                stagePadding: 20,
                autoWidth: true,
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
}

if ($('.gallery_owl_company').length) {
    $('.gallery_owl_company').owlCarousel('destroy');
    $('.gallery_owl_company').owlCarousel({
        loop: false,
        margin: 20,
        // nav: true,
        slideSpeed: 300,
        mouseDrag:false,
        // navText: ["<img src='/images/icons/left.svg'>", "<img src='/images/icons/right.svg'>"],
        responsive: {
            0: {
                items: 1,
                stagePadding: 20,
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
}

$('#owl-gallery').owlCarousel({
    loop: false,
    margin: 17,
    nav: false,
    dots: true,
    slideSpeed: 300,
    mouseDrag:false,touchDrag:false,
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

// $('.review-block__nav-more').click(function () {
//     var block = $(this).closest('.review-block__nav').prev();
//     if (block.css('height') == '105px') {
//         block.css('height', 'auto');
//         $(this).text('Скрыть отзыв');
//     } else {
//         block.css('height', '105px');
//         $(this).text('Отзыв полностью');
//     }
// });

// $('.question-block__nav-more').click(function () {
//     var block = $(this).closest('.question-block__nav').prev();
//     if (block.css('height') == '105px') {
//         block.css('height', 'auto');
//         $(this).text('Скрыть отзыв');
//     } else {
//         block.css('height', '105px');
//         $(this).text('Отзыв полностью');
//     }
// });

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

$('.add-event_new-clients_btns_btn').click(function (e) {
    if (Laravel.user !== null) {
        $(this).attr("href","/cabinet/event/create");
    } else {
        e.preventDefault();
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
    }
});

$('.add-company_block_add-btn-block_btns_btn').click(function (e) {
    if (Laravel.user !== null) {
        if (Laravel.userCompanyCount < 1) {
            $(this).attr("href","/cabinet/company/create");
        } else {
            $(this).attr("href","/cabinet/company");
        }
    } else {
        e.preventDefault();
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
    }
});

$('.authPanel').click(function (e) {
    e.preventDefault();
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


        if ($(".search-block__filter-block").is(":visible")) {
            $('html, body').animate({
                scrollTop: $(".search-block").offset().top
            }, 500);
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

$('.top-block__avatar').click(
    function () {
        $('.avatar-menu').toggle();
        $(this).toggleClass('active');
        $('.modal_layout').toggleClass('active');
});
// $('.top-block__menu-events').click(
//     function(e) {
//         // e.preventDefault();
//         // $(this).toggleClass('active');
//         $('.events').toggle();
//         $('.modal_layout').toggleClass('active');
//     }
// );

// $('.top-block__menu-companies').click(
//     function(e) {
//         // e.preventDefault();
//         // $(this).toggleClass('active');
//         $('.companies').toggle();
//         $('.modal_layout').toggleClass('active');
//     }
// );

$('.modal_layout').click(function () {
    if ($(this).hasClass('active')) {
        // console.log('hi')
        $('.top-block__open').hide();
        $('.top-block__avatar').removeClass('active');
        $(this).removeClass('active');
    }
});

$('.write_review').click(function (e) {
    e.preventDefault();
    if (Laravel.user !== null) {
        if ($(this).hasClass('open')) {
            $('.onwrite-review').hide();
            $(this).removeClass('open');
        } else {
            $('.onwrite-review').show();
            $(this).addClass('open');
        }
    } else {
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
    $('.calc-block-review').show();
    $('.calc-block-question').hide();
    $('.write_review').show();
    $('.review').show();
    if ($('.review-close').length) {
        if ($('.review').length > 3) {
            $('.more_review').show();
        }
    }
    $('.questions-block').hide();
    $('.write_questions').removeClass('open');
    $('.onwrite-quest').hide();
    $('.more_question').hide();
    var sticky = new Sticky('.selector');
});

$('.reviews-nav__questions').click(function () {
    $('.reviews-rating').hide();
    $('.calc-block-review').hide();
    $('.calc-block-question').show();
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
    $('#filter_form').trigger('reset');
    $("#ex21").bootstrapSlider('setValue', 3);
    $('.change-sort-raiting').removeClass('active');
    $('.change-sort-views').removeClass('active');
    $('.change-sort-views').find('i').hide();
    $('.change-sort-raiting').find('i').hide();
    $('.sort-raiting').removeAttr('value');
    $('.sort-raiting').removeAttr('name');
    $('.sort-views').removeAttr('value');
    $('.sort-views').removeAttr('name');
    $('.date-picker').removeAttr('value');
    $('.simplebar-resize-wrapper ul li input').removeAttr('checked');
    $('.filter_3 .suggestions-input').removeAttr('value');
    calendar();
    $('#filter_form').submit();
});

$('.clear_filterm').click(function () {
    $('#filter_form-mobile')[0].reset();
    $("#ex21mob").bootstrapSlider('setValue', 3);
    $('.change-sort-raiting').removeClass('active');
    $('.change-sort-views').removeClass('active');
    $('.change-sort-views').find('i').hide();
    $('.change-sort-raiting').find('i').hide();
    $('.sort-raiting').removeAttr('value');
    $('.sort-raiting').removeAttr('name');
    $('.sort-views').removeAttr('value');
    $('.sort-views').removeAttr('name');
    $('.date-picker-mobile').removeAttr('value');
    $('.mobfilter_2 ul li input').removeAttr('checked');
    $('.mobfilter_3 .suggestions-input').removeAttr('value');
    calendarMobile();
    $('.drp-calendar.left').append('<th class="next available"><span></span></th>');
    $('#filter_form-mobile').submit();
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
    if (height == '250px') {
        $(this).prev().css('max-height', 'initial');
        $(this).find('span').text('Скрыть текст');
    } else {
        $(this).prev().css('max-height', '250px');
        $(this).find('span').text('Читать полностью');
    }
});

$('.change-sort-raiting').click(function () {
    var sort = $(this).find('input').data('sort');
    if (sort <= 2) {
        sort++;
        if (sort == 1) {
            $(this).find('.idown').show();
            $(this).find('.iup').hide();
            $(this).find('input').val('desc');
            $(this).find('input').attr('name', 'sort-raiting');
        }
        if (sort == 2) {
            $(this).find('.iup').show();
            $(this).find('input').val('asc');
        }
        $(this).find('input').data('sort', sort);
        $(this).addClass('active');
    }
    if (sort == 3) {
        $(this).removeClass('active');
        $(this).find('input').data('sort', 0);
        $(this).find('.idown').hide();
        $(this).find('input').removeAttr('value');
        $(this).find('input').removeAttr('name');
    }
    if ($('.change-sort-views').hasClass('active')) {
        $('.change-sort-views').removeClass('active');
        $('.change-sort-views').find('input').data('sort', 0);
        $('.change-sort-views').find('.idown').hide();
        $('.change-sort-views').find('.iup').hide();
        $('.sort-views').removeAttr('value');
        $('.sort-views').removeAttr('name');
    }
});

$('.change-sort-views').click(function () {
    var sort = $(this).find('input').data('sort');
    if (sort <= 2) {
        sort++;
        if (sort == 1) {
            $(this).find('.idown').show();
            $(this).find('.iup').hide();
            $(this).find('input').val('desc');
            $(this).find('input').attr('name', 'sort-views');
        }
        if (sort == 2) {
            $(this).find('.iup').show();
            $(this).find('input').val('asc');
        }
        $(this).find('input').data('sort', sort);
        $(this).addClass('active');
    }
    if (sort == 3) {
        $(this).removeClass('active');
        $(this).find('input').data('sort', 0);
        $(this).find('.idown').hide();
        $(this).find('input').removeAttr('value');
        $(this).find('input').removeAttr('name');
    }
    if ($('.change-sort-raiting').hasClass('active')) {
        $('.change-sort-raiting').removeClass('active');
        $('.change-sort-raiting').find('input').data('sort', 0);
        $('.change-sort-raiting').find('.idown').hide();
        $('.change-sort-raiting').find('.iup').hide();
        $('.sort-raiting').removeAttr('value');
        $('.sort-raiting').removeAttr('name');
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
    if ($('.date-picker').val() !== undefined) {
        var full_date = $('.date-picker').val().split('_');

        if (full_date.length == 2) {
            var start = full_date[0];
            var end = full_date[1];
        } else {
            var start = false;
            var end = false;
        }
    } else {
        return false;
    }
    var picker = $('.date-picker').daterangepicker({
        startDate: start,
        endDate: end,
        autoApply: true,
        autoUpdateInput: false,
        parentEl: "#daterangepicker1-container",
        locale: {
            format: 'Y-MM-DD',
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
    if ($('.date-picker-mobile').val() !== undefined) {
        var full_date = $('.date-picker-mobile').val().split('_');

        if (full_date.length == 2) {
            var start = full_date[0];
            var end = full_date[1];
        } else {
            var start = false;
            var end = false;
        }

        var picker = $('.date-picker-mobile').daterangepicker({
            autoApply: true,
            autoUpdateInput: false,
            startDate: start,
            endDate: end,
            parentEl: "#daterangepicker1-container-mobile",
            locale: {
                format: 'Y-MM-DD',
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
            $('.date-picker-mobile').val(picker.startDate.format('YYYY-MM-DD') + '_' + picker.endDate.format('YYYY-MM-DD'));
        });
        if ($('.daterangepicker').length) {
            picker.data('daterangepicker').hide = function () {
            };
            picker.data('daterangepicker').show();
        }
    }
}

//Range

function change_range(num) {
    $("#ex21").bootstrapSlider('setValue', num);
    if (num == 1) {
        $('#range').val('100')
    }
    ;
    if (num == 2) {
        $('#range').val('500')
    }
    ;
    if (num == 3) {
        $('#range').val('1000')
    }
    ;
    if (num == 4) {
        $('#range').val('5000')
    }
    ;
    if (num == 5) {
        $('#range').val('10000')
    }
    ;
}

$('#ex21').bind('change', function () {
    var i = $(this).val();
    if (i == 1) {
        $('#range').val('100')
    }
    ;
    if (i == 2) {
        $('#range').val('500')
    }
    ;
    if (i == 3) {
        $('#range').val('1000')
    }
    ;
    if (i == 4) {
        $('#range').val('5000')
    }
    ;
    if (i == 5) {
        $('#range').val('10000')
    }
    ;
});

function change_rangemob(num) {
    $("#ex21mob").bootstrapSlider('setValue', num);
    if (num == 1) {
        $('#range').val('100')
    }
    ;
    if (num == 2) {
        $('#range').val('500')
    }
    ;
    if (num == 3) {
        $('#range').val('1000')
    }
    ;
    if (num == 4) {
        $('#range').val('5000')
    }
    ;
    if (num == 5) {
        $('#range').val('10000')
    }
    ;
}

$('#ex21mob').bind('change', function () {
    var i = $(this).val();
    if (i == 1) {
        $('#range').val('100')
    }
    ;
    if (i == 2) {
        $('#range').val('500')
    }
    ;
    if (i == 3) {
        $('#range').val('1000')
    }
    ;
    if (i == 4) {
        $('#range').val('5000')
    }
    ;
    if (i == 5) {
        $('#range').val('10000')
    }
    console.log($('#range').val());
});


// Document Ready
$(document).ready(function () {
    // owl1();
    // owllf();
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

    $.validator.setDefaults({
        ignore: []
    });

    $(".reg-form").validate({
        ignore: ':hidden:not(:checkbox)',
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
        },
        errorPlacement: function (error, element) {
            if (element.is(":checkbox")) {
                element.closest('label').append(error);
            } else {
                error.insertAfter(element);
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

    // if (screen.width == 768) {
        // $('.subscribe-block__search-politic').remove().insertAfter('.subscribe-block__text');
    // }

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

    // if ($('.filter_2').length != 0) {
    //     new SimpleBar($('.filter_2')[0]);
    // }

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
        var height = $('.text-block__text').height();
        if (height > 250) {
            $('.text-block__text').css('max-height', '250px');
            $('.text-block__more').show();
        } else {
            $('.text-block__text').css('max-height', 'initial');
            $('.text-block__more').hide();
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

    if ($('#range').val() != '') {
        if ($('#range').val() == 100) {
            $("#ex21").bootstrapSlider('setValue', 1);
        }
        ;
        if ($('#range').val() == 500) {
            $("#ex21").bootstrapSlider('setValue', 2);
        }
        ;
        if ($('#range').val() == 1000) {
            $("#ex21").bootstrapSlider('setValue', 3);
        }
        ;
        if ($('#range').val() == 5000) {
            $("#ex21").bootstrapSlider('setValue', 4);
        }
        ;
        if ($('#range').val() == 10000) {
            $("#ex21").bootstrapSlider('setValue', 5);
        }
        ;
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
        // $('.subscribe-block__search-politic').remove().insertAfter('.subscribe-block__text');
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
        if ($('.search-block__filter-block') !== undefined && $('.search-block__filter-block').is(':visible')) {
            $('.search-block__filter-block').hide();
        }
    } else {
        $('.search-block__input').attr('placeholder', 'Найти акцию или компанию');
        // $('.subscribe-block__search-politic').remove().insertAfter('.subscribe-block__search');
        if ($('.service_gallery').length > 0) {
            $('.owl-carousel').trigger('destroy.owl.carousel');
            $('.service_gallery').removeClass('owl-carousel');
        }
        $('.search-block__filter').html('Фильтр<img class="search-block__filter-img" src="/images/icons/filter-open.svg">');
        if ($('.filter-panel') !== undefined && $('.filter-panel').is(':visible')) {
            $('.filter-panel').hide();
        }
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

$('.events-block__badges-sad').click(function () {
    $('.report-panel').show();
});

$('.reportPanel').click(function () {
    $('.report-panel').hide();
});

$('.owner-panel .reportPanel').click(function () {
    $('.owner-panel').hide();
});

$('.owner-company').click(function() {
   $('.owner-panel').show();
})

// $('.call-form-verify-company-owner').click(function() {
//     $(this).hide();
//     $('.form-verify-company-owner').show();
// })

// $('.owner-panel__close-form').click(function(e) {
//     e.preventDefault();
//     $('.form-verify-company-owner').hide();
//     $('.call-form-verify-company-owner').show();
// })

//Find blocks

var findComp = $('.search-panel__company').find('.col-lg-4').length;
var findEvent = $('.search-panel__row .events-block').find('.col-lg-4').length;

if (findComp > 4) {
    $('.search-panel__row-more.company').css('display', 'block');
}

if (findEvent > 8) {
    $('.search-panel__row-more.event').css('display', 'block');
}

$('.click-clendar').click(function () {
    $('.search-block__filter').click();
    $('#filter_1').click();
});

$(document).ready(function () {
    if ($("#address").val() != undefined) {
        $("#address").suggestions({
            token: "b60a5d705c75dc99139b5cac21a85cd7d8edbac0",
            type: "ADDRESS",
            onSelect: function (suggestion) {
                $('.rangeBlock').show();
            }
        });
    }

    if ($("#addressMob").val() != undefined) {
        $("#addressMob").suggestions({
            token: "b60a5d705c75dc99139b5cac21a85cd7d8edbac0",
            type: "ADDRESS",
            onSelect: function (suggestion) {
                $('.rangeBlock').show();
            }
        });
    }

    $('#address').on('input keyup', function () {
        var val = $(this).val();
        if (val == '') {
            $('.rangeBlock').hide();
        }
    });

    $('#addressMob').on('input keyup', function () {
        var val = $(this).val();
        if (val == '') {
            $('.rangeBlock').hide();
        }
    });

    $('.suggestions-addon').click(function () {
        $('.rangeBlock').hide();
    });

    if ($('#address').val()) {
        $('.rangeBlock').show();
    }

    var sort_raiting = $('.change-sort-raiting').find('input').data('sort');
    if (sort_raiting <= 2) {
        if (sort_raiting == 1) {
            $('.change-sort-raiting').find('.iup').show();
            $('.change-sort-raiting').addClass('active');
            $('.change-sort-raiting').find('input').val('asc');
        }
        if (sort_raiting == 2) {
            $('.change-sort-raiting').find('.idown').show();
            $('.change-sort-raiting').find('.iup').hide();
            $('.change-sort-raiting').addClass('active');
            $('.change-sort-raiting').find('input').val('desc');
        }
    }

    var sort_views = $('.change-sort-views').find('input').data('sort');
    if (sort_views <= 2) {
        if (sort_views == 1) {
            $('.change-sort-views').find('.iup').show();
            $('.change-sort-views').addClass('active');
            $('.change-sort-raiting').find('input').val('asc');
        }
        if (sort_views == 2) {
            $('.change-sort-views').find('.idown').show();
            $('.change-sort-views').find('.iup').hide();
            $('.change-sort-views').addClass('active');
            $('.change-sort-raiting').find('input').val('desc');
        }
    }
});
$('.click-clendar').click(function () {
    $('.search-block__filter-left').hide();
    $('.search-block__filter-buttons').hide();
    $('.search-block__filter-right').css('margin-left', '0px');
    $('.search-block__filter-block').css({'min-width': '0px', 'min-height': '0px'});
    $('.date-picker').on('apply.daterangepicker', function (ev, picker) {
        var start = picker.startDate.format('YYYY-MM-DD');
        var end = picker.endDate.format('YYYY-MM-DD');
        $('.date-picker').val(start + '_' + end);
        $('.submit_filter').click();
    });
});

$('.search-block__filter').click(function () {
    $('.search-block__filter-left').show();
    $('.search-block__filter-buttons').show();
    $('.search-block__filter-right').css('margin-left', '30px');
    $('.search-block__filter-block').css({'min-width': '965px', 'min-height': '540px'});
    $('.date-picker').off('apply.daterangepicker');
    calendar();
});

$('#respform').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: window.location.href+"/report",
        type: "POST",
        data: $('#respform').serialize(),
        success: function(response) {
            $('#respform').hide();
            $('.message-resp').show();
            $('.report-panel__title').text('Мы получили ваше сообщение');
        },error: function(){
            document.location.href = '/login';
        }
    });
});

$('.review-block__comments-list-reply span').click(function() {
    $(this).hide();
    $('#review-answer-form').show();
})

$('#review-answer-form .closeReview').click(function() {
    $('#review-answer-form').hide();
    $('.review-block__comments-list-reply span').show();
})
$('[data-filter-category-id]').first().addClass('active')
$('[data-filter-category-tags]').first().show()
$('.filter_2-categories_item a').click(this, function() {
    let categoryId = $(this).attr('data-filter-category-id')
    $('[data-filter-category-tags]').hide()
    $('.filter_2-categories_item a').removeClass('active')
    $(this).addClass('active')
    // console.log('categoryId' , categoryId)
    // console.log($(`ul[data-filter-category-tags='${categoryId}']`).text())
    $("ul[data-filter-category-tags='" + categoryId +"']").show()
})

$('.mobfilter_2-categories_item a').click(this, function() {
    let categoryId = $(this).attr('data-filter-category-id')
    $('[data-filter-category-tags]').hide()
    // console.log('categoryId' , categoryId)
    // console.log($(`ul[data-filter-category-tags='${categoryId}']`).text())
    $("ul[data-filter-category-tags='" + categoryId +"']").show()
})

let swiper = new Swiper('.contacts-block_list_slider', {
  autoplay: {
    delay: 30000,
  },
  mousewheelControl: true,
  autoHeight: false,
  // loop: true,

  pagination: {
    el: '.swiper-pagination',
    type: 'progressbar',
  },

  spaceBetween: 20,
  breakpoints: {
    1: {
      slidesPerView: 1.2,
    },
    701: {
      slidesPerView: 2,
    },
    769: {
      slidesPerView: 4,
    }

  },
});


let navPrev = $('.swiper-nav div[data-id="left"]');
let navNext = $('.swiper-nav div[data-id="right"]');

navPrev.on('click', function (e) {
  e.preventDefault();
  swiper.slidePrev();
});

navNext.on('click', function (e) {
  e.preventDefault();
  swiper.slideNext();
});