@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li><a href="{{ route('cabinet.comment.index') }}">Мои отзывы</a></li>
            <li>Ответ на отзыв</li>
        </ul>
    </div>
    <cabinet-comment-show></cabinet-comment-show>
        
@endsection
