@extends('frontend.layouts.app')

@section('title', $page->title ?? '')
@section('description', $page->description ?? '')

@section('content')
<div class="for-business-menu">
	@include('frontend.includes.header-menu')
</div>
{!! $page->content !!}

<div class="for-business-footer">
	<div class="for-business-footer_left">
        <a href="../../../cabinet/dashboard"><span class="icon-plus"><img src="../../images/plus.svg"></span>Добавить компанию</a>

	</div>
	<div class="for-business-footer_right">
		<a href="mailto:hello@dailyes.ru">biz@dailyes.ru</a>
		@ {{date('Y')}} Портал акций вашего города <br>
		Все права защищены
	</div>
</div>
@guest
    @include('frontend.includes.auth-panel')
@endguest
@endsection

@push('after-scripts')
    <script>
        // window.onload = function(){
            if($('.block')) {
                $('.block-button').on('click', this, function() {
                    $('.block').toggle();

                    console.log('===');
                    $(this).closest('.block').show();
                    $(this).closest('.block').find('.block-answer').slideToggle(400);
                    setTimeout(() => {
                        $(this).closest('.block').find('.block-answer').css('display') == 'block' ? $(this).closest('.block').find('.block-question').css('border-bottom', 'none') : $(this).closest('.block').find('.block-question').css('border-bottom', '1px solid #3598db');
                        $(this).closest('.block').find('.block-answer').css('display') == 'block' ? $(this).closest('.block').find('.block-button').css('transform', 'rotate(45deg)') : $(this).closest('.block').find('.block-button').css('transform', 'rotate(0deg)');
                    }, 450);
                })
            }

            btns = $('.for-business-btn');
            blocks = $('.block-for-business');

            btns.on('click', this, function (e) {
                e.preventDefault();
                $('.mobile__nav-fix').hide();
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
        // }
        $('.for-business-footer_left a').click(function (e) {
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
    </script>
@endpush
<style type="text/css">
	#app,
	body {
		background: url('../../images/pages/for_business/forbusinessbgr.png');
        background-repeat: no-repeat;
        background-size: cover;
		overflow: hidden;
	}
</style>
