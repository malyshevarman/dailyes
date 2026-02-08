<template>
    <div class="contacts-map">
        <div class="contacts-map-title">
            <!-- <p>Служба поддержки</p>
            <a class="support-btn" href="#contact-form">Обратиться в поддержку</a> -->
            <p>Служба поддержки</p>
            <span>Сообщить об ошибке:</span>
            <a href="mailto:support@dailyes.ru">support@dailyes.ru</a>
            <p>Для партнёров</p>
            <span>Предложение по сотрудничеству:</span>
            <a href="mailto:biz@dailyes.ru">biz@dailyes.ru</a>
            <!-- <span>или позвоните по телефону</span>
            <a href="tel:8 800 000 00 00">8 800 000 00 00</a> -->
        </div>
        <yandex-map
            :coords="coords"
            :zoom="zoom"
            class="map"
            @map-was-initialized="initMapHandler"
            :controls="['zoomControl']"
        >
            <ymap-marker
                :coords="coords"
                marker-id="1"
                :icon="markerIcon"
            />
        </yandex-map>
    </div>
</template>

<script>
    import yandexMap from 'vue-yandex-maps';

    export default {
        components: {
            yandexMap
        },
        // props: {
        //     addresses: {
        //         required: true,
        //         type: Array
        //     },
        //     carousel: {
        //         default: false,
        //         type: Boolean
        //     },
        //     modal: {
        //         default: false,
        //         type: Boolean
        //     }
        // },
        data: () => ({

            coords: [56.137335, 40.405772],
            markerIcon: {
              layout: 'default#imageWithContent',
              imageHref: '/images/pages/contacts/placemark.png',
              imageSize: [43, 43],
              imageOffset: [-24, -24],
              content: '',
              contentOffset: [],
              contentLayout: ''
            },
            zoom: 16
        }),
        computed: {},
        mounted() {
            if (this.carousel) {
                this.$bus.$on('addressCarouselClick', (id) => {
                    this.openBalloon(id)
                });
            }
            if (this.modal) {
                $('#map-modal').on('shown.bs.modal', (e) => {
                    if (!this.modalViewed) {
                        this.modalViewed = true
                        this.setBounds()
                    }
                })
            }
        },
        methods: {
            initMapHandler(map) {
                this.map = map

                map.behaviors.disable('scrollZoom');
                if (screen.width <= "768") {
                    map.behaviors.disable('drag');
                }
                // if (this.addresses.length === 0) {
                //     return;
                // }
                // var MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
                //     '<div class="adres-popover">' +
                //     '$[[options.contentLayout observeSize minWidth=200 maxWidth=200]]' +
                //     '</div>', {
                //         build: function () {
                //             this.constructor.superclass.build.call(this);
                //             this._$element = $('.adres-popover', this.getParentElement());
                //             this.applyElementOffset();
                //             this._$element.find('.close')
                //                 .on('click', $.proxy(this.onCloseClick, this));
                //         },
                //         clear: function () {
                //             this._$element.find('.close')
                //                 .off('click');
                //             this.constructor.superclass.clear.call(this);
                //         },
                //         onSublayoutSizeChange: function () {
                //             MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);
                //             if (!this._isElement(this._$element)) {
                //                 return;
                //             }
                //             this.applyElementOffset();
                //             this.events.fire('shapechange');
                //         },
                //         applyElementOffset: function () {
                //             this._$element.css({
                //                 marginLeft: -146,
                //                 bottom: 35,
                //                 position: 'absolute'
                //             });
                //         },
                //         onCloseClick: function (e) {
                //             e.preventDefault();
                //             this.events.fire('userclose');
                //         },
                //         getShape: function () {
                //             if (!this._isElement(this._$element)) {
                //                 return MyBalloonLayout.superclass.getShape.call(this);
                //             }
                //             var position = this._$element.position();
                //             return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
                //                 [position.left, position.top], [
                //                     position.left + this._$element[0].offsetWidth,
                //                     position.top + this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight
                //                 ]
                //             ]));
                //         },
                //         _isElement: function (element) {
                //             return element && element[0] && element.find('.arrow')[0];
                //         }
                //     })

                // var MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
                //     '$[properties.address]$[properties.events]'
                // )


                // ymaps.option.presetStorage.add('map#close', {
                //     iconLayout: 'default#imageWithContent',
                //     iconImageHref: '/storage/images/pages/contacts/placemark.png',
                //     balloonLayout: MyBalloonLayout,
                //     balloonContentLayout: MyBalloonContentLayout,
                //     iconImageOffset: [-24, -24],
                //     iconContentOffset: [15, 15],
                //     iconImageSize: [22, 30],
                //     balloonShadow: false
                // });

                // ymaps.option.presetStorage.add('map#open', {
                //     iconLayout: 'default#imageWithContent',
                //     iconImageHref: '/storage//images/pages/contacts/placemark.png',
                //     balloonLayout: MyBalloonLayout,
                //     balloonContentLayout: MyBalloonContentLayout,
                //     iconImageOffset: [-24, -24],
                //     iconContentOffset: [15, 15],
                //     iconImageSize: [22, 30],
                //     balloonShadow: false
                // });

                // let arrayfiltering = this.addresses.filter(adres => {
                //     return adres.events.length != 0
                // })


                // this.placemarks = arrayfiltering.reduce(function (res, a, index, arr) {

                //     res.push(new ymaps.Placemark([a.lat, a.long], {
                //         id: a.id,
                //         address: a.address,
                //         events: a.events ? a.events.map( (aa, indexx, arrr) => {
                //             let ress = `<br><br>${aa.name}<br><br><a style="font-size: 11px;" href="${aa.event_url}">Подробнее</a>`
                //             return ress;
                //         }) : ''
                //     }, {
                //         preset: 'map#close'
                //     }))

                //     return res;
                // }, [])

                // var clusterer = new ymaps.Clusterer({preset: 'islands#blueCircleIcon', groupByCoordinates: false,}).add(this.placemarks)


                // map.geoObjects.add(clusterer)

                // clusterer.events.add('balloonopen', (e) => {
                //     var target = e.get('target');
                //     if (target.geometry && typeof target.getGeoObjects) {
                //         ymaps.geoQuery(this.placemarks).setOptions('preset', 'map#close')
                //         var id = target.properties.get('id')
                //         if (this.carousel) {
                //             this.$bus.$emit('mapSelectId', id)
                //         }

                //         this.placemarks.forEach((placemark,i) => {



                //             if (placemark.properties.get('id') === id) {
                //                 ymaps.geoQuery(placemark).setOptions('preset', 'map#open')
                //                 this.map.panTo(placemark.geometry.getCoordinates())
                //                     .then(function () {
                //                     }, function (err) {
                //                         alert('Произошла ошибка ' + err);
                //                     }, this);
                //             }
                //         })
                //     }
                // });

                // this.setBounds()
            },
            setBounds() {
                this.map.setBounds(this.map.geoObjects.getBounds(), {checkZoomRange: true})
            },
            openBalloon(id) {
                if (this.carousel) {
                    this.$bus.$emit('mapSelectId', id)
                }
                this.placemarks.forEach((placemark) => {
                    if (placemark.properties.get('id') === id) {
                        this.map.panTo(placemark.geometry.getCoordinates())
                            .then(function () {
                                placemark.balloon.open()
                            }, function (err) {
                                alert('Произошла ошибка ' + err);
                            }, this);
                    }
                })
            }
        }
    }
</script>

<style>
    .ymap-container {
        height: 400px;
    }
</style>
