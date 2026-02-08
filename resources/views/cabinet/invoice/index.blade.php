@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Финансы</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Финансы
    </div>
    <div class="lk-body__table" style="overflow: auto">
        <table class="text">
            <tbody>
            <tr>
                <td>Дата</td>
                <td>Платеж</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
