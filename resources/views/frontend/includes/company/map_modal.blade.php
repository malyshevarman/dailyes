<div class="modal fade" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content map-content">
            <div class="map-content__header">
                <span>Адреса компании на карте</span>
                <div class="map-content__header-close" data-dismiss="modal" aria-label="Close"><img
                            src="/images/icons/close.svg"/></div>
            </div>
            <div class="modal-body">
                <div id="map" style="width: 100%; height: 600px">
                    <company-map :balloon="false" :drag="true" :addresses="{{ $company->addresses }}" :modal="true"></company-map>
                </div>
            </div>
        </div>
    </div>
</div>