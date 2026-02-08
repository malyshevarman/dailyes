@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li><a href="{{ route('business.comment.index') }}">Отзывы</a></li>
            <li>Ответ на отзыв</li>
        </ul>
    </div>
            <business-comment-show></business-comment-show>
        
@endsection
