@extends('layouts.auth')

@section('content')
    <div class="container separate__block">
        <div class="row">
            <div class="col-md-12">
                <span class="auth-panel__title">Добро пожаловать!</span>
            </div>
            <div class="col-md-12">
                <div class="auth-panel__option-sep">
                    <div class="separate__href"><a href="/login">Войти</a></div>
                    <div class="separate__href reg active">Регистрация</div>
                    <div class="separate__href right"><a href="/password/reset">Забыли пароль?</a></div>
                    <div class="auth-panel__option-sep-full">
                        <div class="auth-panel__option-full-login-sep"></div>
                        <div class="auth-panel__option-full-register-sep active-full"></div>
                        <div class="auth-panel__option-full-forgot-sep"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <register :formclass="'reg-form-sep'"></register>
            </div>
        </div>
    </div>
    <div class="to_up">
        <img src="/images/icons/up.svg"/>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function () {
            var loginW = $('.separate__href.reg').width();
            var count = $('.separate__href:eq(1)').width() - 20;
            $('.auth-panel__option-full-register-sep').width(loginW);
            $('.auth-panel__option-full-register-sep').css('margin-left', count + 'px');
        });
    </script>
@endpush
