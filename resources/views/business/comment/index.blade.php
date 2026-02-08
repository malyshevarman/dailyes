@extends('cabinet.layouts.app')
@push('after-scripts')
    <script>
        $('.bodyevents').infiniteScroll({
            path: '.trigger_events .pagination__next',
            append: '.eventitem',
            button: '.trigger_events .view-more-button',
            // using button, disable loading on scroll
            scrollThreshold: false,
            // status: '.page-load-status',
        });

        $('.bodycompany').infiniteScroll({
            path: '.trigger_company .pagination__next',
            append: '.companytitem',
            button: '.trigger_company .view-more-button',
            // using button, disable loading on scroll
            scrollThreshold: false,
            // status: '.page-load-status',
        });
    </script>
@endpush
@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Отзывы</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Отзывы
    </div>


    <div class="lk-body__trigger">
        <div data="1" class="lk-body__trigger-url active">Акции<span>{{ $events->count() }}</span></div>
        <div data="2" class="lk-body__trigger-url">Компании<span>{{ $companies->count() }}</span></div>
    </div>




    <div class="trigger_events">

        @if($events->count() == 0)

            <!-- <div class="col-md-12"> -->
                <div class="lk-body__text">
                    <div class="info_block">
                        <div>

                            В данный момент, <br>
                            список отзывов пуст
                        </div>
                    </div>
                </div>
            <!-- </div> -->
@else
            <div class="lk-body__table" style="overflow: auto">
                <table class="text">
                    <tbody>
                    <tr>
                        <td>Дата</td>
                        <td>Акция</td>
                        <td>Отзыв</td>
                    </tr>
                    @foreach($events as $event)
                        @foreach($event->comments as $comment)
                            @php
                                $date_reviews = $comment->created_at;
                                $text_reviewslength=$comment->text;
                                $text_reviews = mb_strimwidth($comment->text, 0, 30, "...");
                            @endphp

                        @endforeach

                        <tr class="non companytitem">
                            <td class="cols">{{date('Y-m-d', strtotime($date_reviews))}}</td>
                            <td class="cols"><a href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a></td>
                            <td class="cols"><span title="{{$text_reviewslength}}"><a href="{{route('business.comment.show', $comment)}}">{{$text_reviews}}</a></span></td>
                        </tr>



                    @endforeach

                    </tbody>
                </table>
            </div>
        @endif



    </div>


    <div class="trigger_company">

        @if($companies->count() == 0)

            <!-- <div class="col-md-12"> -->
                <div class="lk-body__text">
                    <div class="info_block">
                        <div>

                            В данный момент, <br>
                            список отзывов пуст
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        @else

    <div class="lk-body__table" style="overflow: auto">
        <table class="text">
            <tbody>
            <tr>
                <td>Дата</td>
                <td>Компания</td>
                <td>Отзыв</td>
            </tr>
            @foreach($companies as $company)
                @foreach($company->comments as $comment)
                    @php
                        $date_company=$comment->created_at;
$text_reviewslength=$comment->text;
$text_company = mb_strimwidth($comment->text, 0, 30, "...");
                    @endphp
                    <!--  <tr>
                         <td><a style="color:#727272;font-weight: normal;font-size:14px;" href="{{ route('cabinet.comment.show', $comment) }}">{{ $comment->text }}</a></td>

                            <td style="color:#727272;font-weight: normal;font-size:14px;width:250px;">{{ $comment->created_at }}</td>
                        </tr> -->
                @endforeach
                <tr class="non companytitem">
                    <td class="cols">{{date('Y-m-d', strtotime($date_company))}}</td>
                    <td class="cols"><a href="{{ route('frontend.company.show', $company) }}">{{ $company->name }}</a></td>
                    <td class="cols"><span title="{{$text_reviewslength}}"><a href="{{route('business.comment.show', $comment)}}">{{$text_company}}</a></span></td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
        @endif
    </div>



@endsection
