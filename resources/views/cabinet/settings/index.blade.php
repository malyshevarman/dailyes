@extends('cabinet.layouts.app')
@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Настройка уведомлений</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Настройки
    </div>

    <settings-index></settings-index>


@endsection
