@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li><a href="{{ route('cabinet.event.index') }}">Акции</a></li>
            <li>Редактировать акцию</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Редактировать акцию
    </div>
    <div class="lk-body__row">
        <a href="{{ route('cabinet.event.stat', $event) }}"><div class="lk-body__nav-button v-align"><img src="/images/icons/stat-chart-white.svg" />Статистика</div></a>
    </div>
    <div class="lk-body__row">
        <div class="container-fluid">
            <events-form></events-form>
        </div>
    </div>
@endsection
