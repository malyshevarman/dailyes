@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li><a href="{{ route('cabinet.company.index') }}">Акции</a></li>
            <li>Добавить акцию</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Добавить новую акцию
    </div>
    <div class="lk-body__row">
        <div class="container-fluid">
            <events-form></events-form>
        </div>
    </div>
@endsection
