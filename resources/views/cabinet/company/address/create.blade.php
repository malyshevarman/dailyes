@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li><a href="{{ route('cabinet.company.index') }}">Компании</a></li>
            <li>Редактировать компанию</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Редактировать адрес компании
    </div>
    <div class="lk-body__row">
        <div class="container-fluid">
            <company-addresses-form></company-addresses-form>
        </div>
    </div>
@endsection
