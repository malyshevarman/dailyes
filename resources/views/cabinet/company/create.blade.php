@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li><a href="{{ route('cabinet.company.index') }}">Компании</a></li>
            <li>Добавить компанию</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Добавить новую компанию
    </div>
    <div class="lk-body__row">
        <div class="container-fluid">
            <companies-form></companies-form>
        </div>
    </div>
@endsection
