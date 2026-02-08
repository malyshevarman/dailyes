@extends('layouts.auth')

@section('content')
    <div class="container separate__block">
        <div class="row">
            <div class="col-md-12">
                <span class="auth-panel__title">Введите новый пароль!</span>
            </div>
            <div class="col-md-12">
                <div class="auth-panel__option-sep">
                    <div class="separate__href"><a href="/login">Войти</a></div>
                    <div class="separate__href reg"><a href="/register">Регистрация</a></div>
                    <div class="separate__href right"><a href="/password/reset">Забыли пароль?</a></div>
                    <div class="auth-panel__option-sep-full">
                        <div class="auth-panel__option-full-login-sep"></div>
                        <div class="auth-panel__option-full-register-sep"></div>
                        <div class="auth-panel__option-full-forgot-sep active-full"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <reset :formclass="'reg-form-sep'"></reset>
            </div>
        </div>
    </div>
    <div class="to_up">
        <img src="/images/icons/up.svg"/>
    </div>
@endsection
