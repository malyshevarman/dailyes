@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Вопросы</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Вопросы
    </div>
    <div class="lk-body__table" style="overflow: auto">
        <table class="text">
            <tbody>
            <tr>
                <td>Текст</td>
                <td>Дата</td>
            </tr>
            @foreach($events as $event)
                <tr class="non">
                    <td class="cols" colspan="3"><b>Акция</b> <a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a></td>
                </tr>
                @foreach($event->questions as $question)
                    <tr>
                        <td><a style="color:#727272;font-weight: normal;font-size:14px;" href="{{ route('business.question.show', $question) }}">{{ $question->text }}</a></td>
                        <td style="color:#727272;font-weight: normal;font-size:14px;width:250px;">{{ $question->created_at }}</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
