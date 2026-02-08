@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Профиль</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Профиль
    </div>
    <div class="lk-body__profile">
        <div class="v-align">
           <!-- <div class="cabinet-avatar"><img src="{{ auth()->user()->avatar_url }}"/></div> -->
            <div class="lk-body__profile-name">
                {{ auth()->user()->name }}
                <span>{{ auth()->user()->email }}</span>
            </div>
        </div>
    </div>
    <div class="lk-body__nav">
        <ul>
            <li class="v-align"><a href="{{ route('cabinet.profile.profile') }}"><img src="/images/icons/lk/edit.svg"/> Редактировать профиль</a></li>
            <li class="v-align"><a href="{{ route('cabinet.profile.password') }}"><img src="/images/icons/lk/password.svg"/> Сменить пароль</a></li>
            <li class="v-align"><a href="{{ route('cabinet.settings.index') }}"><img src="/images/icons/lk/settings.svg" /> Настройки уведомлений</a></li>
             <li class="v-align"><deleteprodile></deleteprodile></li>


            {{--<li class="v-align">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout').submit();"><img src="/images/icons/lk/exit.svg"/> Выйти
                </a>
                <form id="logout" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </li>
            --}}
        </ul>
    </div>
@endsection
