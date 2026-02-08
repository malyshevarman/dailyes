<template>
    <yandex-map
        :coords="coords"
        :zoom="zoom"
        class="map"
        @map-was-initialized="initMapHandler"
        :controls="['zoomControl']"
    />
</template>

<script>
    import yandexMap from 'vue-yandex-maps';

    export default {
        components: {
            yandexMap
        },
        props: {
            balloon: {
                required: true,
                type: Boolean
            },
            drag: {
                required: true,
                type: Boolean
            },
            addresses: {
                required: true,
                type: Array
            },
            carousel: {
                default: false,
                type: Boolean
            },
            modal: {
                default: false,
                type: Boolean
            },
            city: {
                // required: true,
                type: Object
            }
        },
        data: () => ({
            coords: ['55.584222', '37.385529'],
            zoom: 7,
            modalViewed: false
        }),
        computed: {},
        mounted() {
            // console.log(screen.width)
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

                if (this.addresses.length === 0) {
                    return;
                }


                map.behaviors.disable('scrollZoom');
                // map.behaviors.disable('multiTouch');
                if (!this.drag) {
                    if (screen.width <= "768") {
                        map.behaviors.disable('drag');
                    }
                }



                var MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
                    // '<div class="adres-popover"><a href="#" class="close" style="color: white; text-shadow: none; opacity: 0.7; position: absolute; right: 5px; top: 5px;"><i class="fas fa-times" style="color:#637F99;margin: 10px;"></i></a>' +
                    // '$[[options.contentLayout]]' +
                    // '</div>', 
                    {
                        build: function () {
                            this.constructor.superclass.build.call(this);
                            this._$element = $('.adres-popover', this.getParentElement());
                            this.applyElementOffset();
                            this._$element.find('.close')
                                .on('click', $.proxy(this.onCloseClick, this));
                        },
                        clear: function () {
                            this._$element.find('.close')
                                .off('click');
                            this.constructor.superclass.clear.call(this);
                        },
                        onSublayoutSizeChange: function () {
                            MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);
                            if (!this._isElement(this._$element)) {
                                return;
                            }
                            this.applyElementOffset();
                            this.events.fire('shapechange');
                        },
                        applyElementOffset: function () {
                            console.log('left',-(this._$element[0].offsetWidth / 2))
                            console.log('top', -(this._$element[0].offsetHeight))
                            if (screen.width <= "768") {
                                this._$element.css({
                                    left: -(this._$element[0].offsetWidth / 2 + 10),
                                    top: -(this._$element[0].offsetHeight / 2),
                                    // marginLeft: -227,
                                    // bottom: -120,
                                    position: 'absolute'
                                });
                            } else {
                                this._$element.css({
                                    left: -(this._$element[0].offsetWidth / 2 + 10),
                                    top: -(this._$element[0].offsetHeight),
                                    // marginLeft: -227,
                                    // bottom: -120,
                                    position: 'absolute'
                                });
                            }
                        },
                        onCloseClick: function (e) {
                            e.preventDefault();
                            this.events.fire('userclose');
                        },
                        getShape: function () {
                            if (!this._isElement(this._$element)) {
                                return MyBalloonLayout.superclass.getShape.call(this);
                            }
                            var position = this._$element.position();
                            return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
                                [position.left, position.top], [
                                    position.left + this._$element[0].offsetWidth,
                                    position.top + this._$element[0].offsetHeight
                                ]
                            ]));
                        },
                        _isElement: function (element) {
                            return element && element[0] && element.find('.arrow')[0];
                        }
                    })

                var MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
                    '<div class="companyname">$[properties.companyname]</div>$[properties.address]<div class="ballooncontent">$[properties.events]</div>'
                )


                ymaps.option.presetStorage.add('map#close', {
                    iconLayout: 'default#imageWithContent',
                    iconImageHref: '/images/icons/map-point-open.svg',
                    balloonLayout: MyBalloonLayout,
                    balloonContentLayout: MyBalloonContentLayout,
                    iconImageOffset: [-24, -24],
                    iconContentOffset: [15, 15],
                    iconImageSize: [22, 30],
                    balloonShadow: false,
                    openBalloonOnClick: this.balloon
                });

                ymaps.option.presetStorage.add('map#open', {
                    iconLayout: 'default#imageWithContent',
                    iconImageHref: '/images/pages/contacts/placemark.png',
                    balloonLayout: MyBalloonLayout,
                    balloonContentLayout: MyBalloonContentLayout,
                    iconImageSize: [43, 43],
                    iconImageOffset: [-43, -43],
                    balloonShadow: false,
                });

                let arrayfiltering = this.addresses.filter(adres => {
                    return adres.company
                })
                if (this.city !== undefined) {
                    arrayfiltering = arrayfiltering.filter((item) => {
                        return item.city.name == this.city.name
                    })
                }
                let lat = [];
                let long = [];
                let arrayFiltering2 = arrayfiltering;
                function itemCheck(item) {
                    if (lat.indexOf(item.lat) === -1 && long.indexOf(item.long) === -1) {
                        lat.push(item.lat)
                        long.push(item.long)
                        return true
                    }
                    return false
                }

                arrayfiltering = arrayfiltering.filter((item) => itemCheck(item))
                arrayfiltering.forEach((item,index) => {
                    item['companies'] = [];
                    arrayFiltering2.forEach((i,ind) => {
                        if (item.lat == i.lat && item.long == i.long) {
                            // i.events.forEach(it => {
                            //     if (JSON.stringify(item.events).indexOf(JSON.stringify(it)) == -1) {
                            //         item.events.push(it)
                            //     }
                            // })
                            item.companies.push(i.company)
                        }
                    })
                })


                // console.log(arrayfiltering)
                if (arrayfiltering.length == 0) return false
                this.placemarks = arrayfiltering.reduce(function (res, a, index, arr) {
                    // if (a.companies) {
                    //     var companies = a.companies.map((aa, indexx, arrr) => {
                    //         let ress = `<br><br><span style="color:#637F99;margin-right: 20px;font-size: 14px;">${indexx + 1}</span>   <span style="color:#fff;font-size:14px;">${aa.name}</span><br><a style="font-size: 14px;float:right;" href="/company/${aa.slug}">Подробнее</a><hr style="border-top: 1px solid rgba(255,255,255,0.1);width: 92%;margin-left: 30px;margin-top:30px;">`
                    //         return ress
                    //     })
                    //     companies = companies.join(' ')
                    // } else {
                    //     var companies = ''
                    // }
                    res.push(new ymaps.Placemark([a.lat, a.long], {
                        id: a.id,
                        // address: `<div style="color:#637F99;font-size:14px;">${a.address}</div><hr style="border-top: 2px solid #637F99;">`,
                        // events: companies
                    }, {
                        preset: 'map#close'
                    }))

                    return res
                }, [])

                var clusterer = new ymaps.Clusterer({
                    preset: 'islands#blueCircleIcon',
                    groupByCoordinates: false,
                }).add(this.placemarks)


                map.geoObjects.add(clusterer)

                clusterer.events.add(['click', 'balloonopen'], (e) => {
                    var target = e.get('target');
                    if (target.geometry && typeof target.getGeoObjects) {
                        ymaps.geoQuery(this.placemarks).setOptions('preset', 'map#close')
                        var id = target.properties.get('id')
                        if (this.carousel) {
                            this.$bus.$emit('mapSelectId', id)
                        }
                        $('.owl-map-points').trigger('to.owl.carousel', [$(`#address-card-${id}`).parent().index(),0,true])
                        this.placemarks.forEach((placemark, i) => {


                            if (placemark.properties.get('id') === id) {
                                ymaps.geoQuery(placemark).setOptions('preset', 'map#open')
                                this.map.panTo(placemark.geometry.getCoordinates())
                                    .then(function () {
                                    }, function (err) {
                                        alert('Произошла ошибка ' + err);
                                    }, this);
                            }
                        })
                    }
                });

                this.setBounds()
            },
            setBounds() {
                this.map.setBounds(this.map.geoObjects.getBounds(), {checkZoomRange: true})

               setTimeout(() => {
                    this.map.setZoom(this.map.getZoom() - 1)
                }, 1000)


            },
            openBalloon(id) {
                if (this.carousel) {
                    this.$bus.$emit('mapSelectId', id)
                }
                this.placemarks.forEach((placemark) => {
                    ymaps.geoQuery(placemark).setOptions('preset', 'map#close')
                    if (placemark.properties.get('id') === id) {
                        ymaps.geoQuery(placemark).setOptions('preset', 'map#open')
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
        height: 100%;
    }
</style>
