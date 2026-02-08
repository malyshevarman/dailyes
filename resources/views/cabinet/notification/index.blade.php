@extends('cabinet.layouts.app')
@push('after-scripts')
    <script>
        $('.notifi_container').infiniteScroll({
            path: '.pagination__next',
            append: '.notifi_item',
            button: '.view-more-button',
            // using button, disable loading on scroll
            scrollThreshold: false,
            // status: '.page-load-status',
        });
         
        // window.onload = function()
        // {
        //     // 500 - период с который будет мигать надпись
        //     let newNotifications = document.querySelectorAll('.new_notification');
        //     newNotifications.forEach(not => {
        //         console.log($(not))
        //         not.animate({'background': "rgba(24, 144, 255, 0.3)"}, 2000);
        //         // setTimeout(() => {
        //         //     $(not).animate({'background': "#fff"}, 500);
        //         // }, 500)
        //     })
        // }

    </script>
@endpush
@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Уведомления</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Уведомления
    </div>



    @if($notifications->count() == 0)


            <div class="lk-body__text">
                <div class="info_block">
                    <div>

                        В данный момент, <br>
                        список уведомлений пуст
                    </div>
                </div>
            </div>

    @else
        <div class="lk-body__table" style="overflow: auto">
            <table class="text notifi_container">
                <tbody>
                <tr>
                    <td>Дата</td>
                    <td>Уведомление</td>
                </tr>
                @foreach($notifications as $notify)
                    <tr class="{{is_null($notify->read_at) ? 'notifi_item new_notification' : 'notifi_item'}}">
                        <td>{{ date('d.m.Y', strtotime($notify->created_at)) }}</td>
                        <td>{!! $notify->data['text'] !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>




            <div class=" d-flex justify-content-center">
                <div style="display:none;" class="col-lg-6 col-sm-8">
                    {{ $notifications->appends(['text' => Request::input('text'), 'date' => Request::input('date'), 'categories' => Request::input('categories'), 'location' => Request::input('location')])->links('frontend.includes.pagination', ['paginator' => $notifications]) }}
                </div>
                <div class="col-lg-3 col-sm-4 show-more">
                    @if ($notifications->lastPage() != $notifications->currentPage())
                        <a href="">
                            <div class="view-more-button">Показать еще</div>
                        </a>
                    @endif
                </div>
            </div>



        </div>
        @endif



@endsection
