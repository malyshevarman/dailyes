<div class="text-block__title">
    Акция на карте
</div>
<div class="row">
    <div class="col-md-12">
        <addresses-carousel :addresses="{{ $event->addresses }}" :city="{{$city}}"></addresses-carousel>
    </div>
    <div class="col-md-12 paddMap">
        <div id="mapList">
            <addresses-map :balloon="false" :drag="false" :addresses="{{ $event->addresses }}" :carousel="true"  :city="{{$city}}"></addresses-map>
        </div>
    </div>
</div>