var owl = $('#owl-1');
owl.owlCarousel({
    loop:true,
    margin:15,
    nav:false,
    autoplay: true,
    onDragged: owl1,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
});
function owl1() {
    $('#owl-1 .owl-stage').find('.owl-item').addClass('active');
}
owl.on('changed.owl.carousel', function() {
    setTimeout(owl1, 10);
});
$('#owl-2').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    dots: true,
    navText: ["<img src='./images/icons/arrow-white-left.svg'>","<img src='./images/icons/arrow-white-right.svg'>"],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});
var owll = $('#owl-3');
owll.owlCarousel({
    loop:true,
    autoplay: true,
    margin:25,
    onDragged: owll,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
});
function owllf() {
    $('#owl-3 .owl-stage').find('.owl-item').addClass('active');
}
owll.on('changed.owl.carousel', function() {
    setTimeout(owllf, 10);
});

$('#owl-2 .owl-nav').click(function(event) {
    $(this).removeClass('disabled');
});
$('.gallery_owl').owlCarousel({
    loop: false,
    margin: 10,
    nav: true,
    navText: ["<img src='./images/icons/left.svg'>","<img src='./images/icons/right.svg'>"],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
});

$(window).scroll(function() {
    if ($(window).scrollTop() > 600) {
        $('.to_up').show();
    } else {
        $('.to_up').hide();
    }
});

$('.to_up').click(function() {
    $('html, body').animate({scrollTop: 0},800);
});

function auth_panel(close){
    $('.auth-panel').fadeToggle();
    var loginW = $('.auth-panel__option-login').width()+2;
    var registerW = $('.auth-panel__option-register').width()+2;
    var forgotW = $('.auth-panel__option-forgot').width()+2;

    $('.auth-panel__option-full-login').width(loginW);
    $('.auth-panel__option-full-register').width(registerW);
    $('.auth-panel__option-full-forgot').width(forgotW);

    if(close == 1){
        $('body').css('overflow', 'hidden');
    }else{
        $('body').css('overflow', 'auto');
    }

}

function city_panel(close){
    $('.city-panel').fadeToggle();

    if(close == 1){
        $('body').css('overflow', 'hidden');
    }else{
        $('body').css('overflow', 'auto');
    }

}

function calendar(){
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
    picker.on('apply.daterangepicker', function(ev, picker) {
        $('.date-picker').val(picker.startDate.format('YYYY-MM-DD')+'_'+picker.endDate.format('YYYY-MM-DD'));
    });
    picker.data('daterangepicker').hide = function () {};
    picker.data('daterangepicker').show();
}

$('.search-block__filter').click(function(){
    $('.search-block__filter-block').toggle();
});

function city(){
    $('.top-block__city-option').toggle();
}

$('.top-block__avatar').click(function(){
    $('.top-block__open').toggle();
});

function change_range(num){
    $("#ex21").bootstrapSlider('setValue', num);
}

$('.map-point').click(function(){
    var a = $('.owl-item.active').find('.map-point');
    var n = a.index(this);
    if(n <= 3){
        if(n >= 0) {
            $('.map-point').removeClass('active');
            $(this).addClass('active');
        }
    }
    if($('.owl-item.active').find('.map-point.active').parent().index()){
        if(n <= 3){
            if(n >= 0){
                for (i = 0; i < n; i++){
                    $('.owl-carousel').trigger('next.owl.carousel');
                }
            }
        }
    }
});

$('.clear_filter').click(function(){
    $('#filter_form')[0].reset();
    $("#ex21").bootstrapSlider('setValue', 3);
    calendar();
});

$('#filter_1').click(function(){
    $('#filter_1').addClass('active');
    $('#filter_2').removeClass('active');
    $('#filter_3').removeClass('active');
    $('.filter_1').show();
    $('.filter_2').hide();
    $('.filter_3').hide();
});

$('#filter_2').click(function(){
    $('#filter_2').addClass('active');
    $('#filter_1').removeClass('active');
    $('#filter_3').removeClass('active');
    $('.filter_1').hide();
    $('.filter_2').show();
    $('.filter_3').hide();
});

$('#filter_3').click(function(){
    $('#filter_3').addClass('active');
    $('#filter_2').removeClass('active');
    $('#filter_1').removeClass('active');
    $('.filter_1').hide();
    $('.filter_2').hide();
    $('.filter_3').show();
});

$('.text-block__more').click(function(){
    var height = $(this).prev().css('max-height');
    if(height == '350px'){
        $(this).prev().css('max-height', 'initial');
        $(this).find('span').text('Скрыть текст');
    }else{
        $(this).prev().css('max-height', '350px');
        $(this).find('span').text('Читать полностью');
    }
});

$(document).ready(function() {
    owl1();
    owllf();
    $('.auth-panel__option div').click(function(){
        $('.auth-panel__option div').removeClass('active');
        $(this).addClass('active');
        var index = $(this).index();
        var count = $('.auth-panel__option-login').width() + 40;
        $('.auth-panel__option-full div').removeClass('active-full');
        $('.auth-panel__option-full div:eq('+index+')').addClass('active-full');
        if(index == 0){
            $('.auth-form').show();
            $('.reg-form').hide();
            $('.forgot-form').hide();
            $('#change').text('Добро пожаловать!');
        }
        if(index == 1){
            $('.auth-panel__option-full div:eq('+index+')').css('margin-left', count+'px');
            $('.auth-form').hide();
            $('.reg-form').show();
            $('.forgot-form').hide();
            $('#change').text('Регистрация');
        }
        if(index == 2){
            $('.auth-form').hide();
            $('.reg-form').hide();
            $('.forgot-form').show();
            $('#change').text('Восстановить пароль');
        }
    });
    $('.open-password').click(function(){
        if($('.open-password').prev('.auth-form__input').attr('type') == 'text') {
            $('.open-password').prev('.auth-form__input').attr('type', 'password');
            $(this).removeClass('active');
        }else{
            $('.open-password').prev('.auth-form__input').attr('type', 'text');
            $(this).addClass('active');
        }
    });

    $(".auth-form").validate({
        errorPlacement: function(error, element) {},
        errorClass:'error',
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
        errorPlacement: function(error, element) {},
        errorClass:'error',
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
            }
        }
    });

    $(".forgot-form").validate({
        errorPlacement: function(error, element) {},
        errorClass:'error',
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

    $('#city-seacrh').keyup(function() {
        if ($(this).val() != '') {
            $('.all-city').hide();
            $('.city-theme').hide();
            $('.group_city').hide();
            s = $(this).val();
            s = s.charAt(0).toUpperCase() + s.substr(1);
            $('li:contains("'+s+'")').show();
            t = s.charAt(0).toUpperCase();
            $('.city-theme:contains("'+t+'")').show();
            $('.city-theme:contains("'+t+'")').parent().show();
            if($('li:contains("'+s+'")').length == 0){
                $('.group_city').hide();
                $('.city-panel__not').show();
            }else{
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
});