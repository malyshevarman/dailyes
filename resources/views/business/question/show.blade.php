@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li><a href="{{ route('business.comment.index') }}">Вопросы бизнесов</a></li>
            <li>Ответ на вопрос</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Ответ на вопрос
    </div>
    <div class="lk-body__row">
        <div class="container-fluid">
            <business-question-show></business-question-show>
        </div>
    </div>
@endsection
