<div class="text-block__title">
    Адреса компании на карте
</div>
<div class="row">
    <div class="col-md-12">
        <addresses-carousel :city="{{$city}}" :addresses="{{ $company->addresses }}"></addresses-carousel>
    </div>
    <div class="col-md-12 paddMap">
        <div id="mapList">
            <company-map :balloon="false" :drag="false" :addresses="{{ $company->addresses }}" :carousel="true" :city="{{$city}}"></company-map>
        </div>
    </div>
</div>