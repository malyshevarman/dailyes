@extends('layouts.auth')

@section('content')
    <div class="container separate__block">
        <div class="row">
            <div class="col-md-12">
                <span class="auth-panel__title">Добро пожаловать!</span>
            </div>
            <div class="col-md-12">
                <div class="auth-panel__option-sep">
                    <div class="auth-panel__option-login-sep active">Войти</div>
                    <div class="separate__href"><a href="/register">Регистрация</a></div>
                    <div class="separate__href right"><a href="/password/reset">Забыли пароль?</a></div>
                    <div class="auth-panel__option-sep-full">
                        <div class="auth-panel__option-full-login-sep active-full"></div>
                        <div class="auth-panel__option-full-register-sep"></div>
                        <div class="auth-panel__option-full-forgot-sep"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <login :formclass="'auth-form-sep'"></login>
            </div>
        </div>
    </div>
    <div class="to_up">
        <img src="/images/icons/up.svg"/>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function(){
            var loginW = $('.auth-panel__option-login-sep').width();
            $('.auth-panel__option-full-login-sep').width(loginW);
        });
    </script>
@endpush
