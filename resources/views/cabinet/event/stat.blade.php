@extends('cabinet.layouts.app')

@push('before-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/ru.js"></script>


@endpush

@section('content')

    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li><a href="{{ route('cabinet.event.index') }}">Акции</a></li>
            <li>{{ $event->name }}</li>
        </ul>
    </div>
    <div class="row">
       <div class="col-lg-9 col-md-12 col-sm-12">
           <div class="lk-body__title">
               Статистика просмотров
           </div>
        <!--    <div class="lk-body__stats">
               <span>{{ $event->views_weekly->sum('count') }}</span> просмотров за неделю
           </div>
           -->
           <div class="lk-body__graph">
               <div class="row">
                   <div class="col-md-12">

                       <events-stat></events-stat>


                   </div>
                   <div class="col-xl-12 col-lg-12">
                       <div class="lk-calc-block">
                           <div class="lk-calc-block-text">
                            Просмотры считаются за счёт количества появлений вашей акции в ленте, когда ее увидели другие пользователи. <br>
                            Чем чаще она встречается в ленте, тем больше пользователей видят ее.
                           </div>
                       </div>
                   </div>

               </div>
           </div>

       </div>
       {{--<div  class="statistic_rightside">

           <h4>Увеличить просмотры</h4>

           <div class="text">
               Примените услуги, что бы увеличить колиечство просмотров акции
           </div>
<div class="list_banner">
           <div class="blockstatbanner">
               <div class="title"><img src="/images/icons/lk/sun.svg" /> Выделить акцию</div>
               <div class="sales">-50%</div>
               <!-- <div class="desc"></div> -->
               <div class="foot">
                   <a href="{{ route('cabinet.banner.index') }}">Подключить</a>
                   <div class="price">
                       <div class="old">500 р</div>
                       <div class="new">1100 р</div>
                   </div>
               </div>
           </div>


           <div class="blockstatbanner">
               <div class="title"><img src="/images/icons/lk/fas.fa-hand-point-right.svg" /> Указать на акцию</div>
               <div class="sales">-50%</div>
               <!-- <div class="desc"></div> -->
               <div class="foot">
                   <a href="{{ route('cabinet.banner.index') }}">Подключить</a>
                   <div class="price">
                       <div class="old">500 р</div>
                       <div class="new">1100 р</div>
                   </div>
               </div>
           </div>

           <div class="blockstatbanner">
               <div class="title"><img src="/images/icons/lk/Vector.svg" /> Поднять акцию</div>
               <div class="sales">-50%</div>
               <!-- <div class="desc"></div> -->
               <div class="foot">
                   <a href="{{ route('cabinet.banner.index') }}">Подключить</a>
                   <div class="price">
                       <div class="old">500 р</div>
                       <div class="new">1100 р</div>
                   </div>
               </div>
           </div>

           <div class="blockstatbanner">
               <div class="title"><img src="/images/icons/lk/pin1.svg" /> Закрепить акцию</div>
               <div class="sales">-50%</div>
               <!-- <div class="desc"></div> -->
               <div class="foot">
                   <a href="{{ route('cabinet.banner.index') }}">Подключить</a>
                   <div class="price">
                       <div class="old">500 р</div>
                       <div class="new">1100 р</div>
                   </div>
               </div>
           </div>

           <div class="blockstatbanner">
               <div class="title"><img src="/images/icons/lk/fas.fa-gem.svg" /> Премиум размещение</div>
               <div class="sales">-50%</div>
               <!-- <div class="desc"></div> -->
               <div class="foot">
                   <a href="{{ route('cabinet.banner.index') }}">Подключить</a>
                   <div class="price">
                       <div class="old">500 р</div>
                       <div class="new">1100 р</div>
                   </div>
               </div>
           </div>
</div>

       </div>--}}
    </div>
@endsection
