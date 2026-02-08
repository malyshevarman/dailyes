<div class="modal fade" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content map-content">
            <div class="map-content__header">
                <span>Акции на карте</span>
                <div class="map-content__header-close" data-dismiss="modal" aria-label="Close"><img
                            src="/images/icons/close.svg"/></div>
            </div>
            <div class="modal-body">
                <div id="map" style="width: 100%; height: 600px">
                    <addresses-map :falsezoom="true" :balloon="false" :drag="true" :addresses="{{ $event->addresses }}" :modal="true"></addresses-map>
                </div>
            </div>
        </div>
    </div>
</div>