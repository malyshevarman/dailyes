<template>
    <yandex-map
        :coords="[city.lat, city.long]"
        :zoom="zoom"
        class="map"
        :controls="[]"
        @map-was-initialized="initMapHandler"
    >
    </yandex-map>
</template>

<script>
    import { yandexMap, ymapMarker } from 'vue-yandex-maps';

    export default {
        components: { yandexMap, ymapMarker },
        props: {
            balloon: {
                required: true,
                type: Boolean
            },
            drag: {
                required: true,
                type: Boolean
            },
            // addresses: {
            //     required: true,
            //     type: Array
            // },
            carousel: {
                default: false,
                type: Boolean
            },
            modal: {
                default: false,
                type: Boolean
            },
            city: {
                required: true,
                type: Object
            },
        },
        data() {
            return {
                coords: [],
                zoom: 10,
                ajaxData: [],
            }
        },
        computed: {},
        mounted() {
            // this.ajaxData = this.addresses
            // console.log(screen.width)
            // if (this.carousel) {
            //     this.$bus.$on('addressCarouselClick', (id) => {
            //         this.openBalloon(id)
            //     });
            // }
            // if (this.modal) {
            //     $('#map-modal').on('shown.bs.modal', (e) => {

            //         if (!this.modalViewed) {
            //             this.modalViewed = true
            //             // this.setBounds()
            //         }
            //     })
                this.$bus.$on('fetchMapCompaniesAddresses', (addresses) => {
                    this.fetchMapAddresses(addresses)
                });
            // }
        },
        methods: {
            fetchMapAddresses(addresses) {
                this.ajaxData = addresses
                this.setMarkers()
            },
            initMapHandler(map) {
                this.map = map

                // if (!this.drag) {
                //     if (screen.width <= "768") {
                //         map.behaviors.disable('drag');
                //     }
                // }

                // Creating a custom layout for the zoom slider.
                let ZoomLayout = ymaps.templateLayoutFactory.createClass("<div class='zoom-control'>" +
                    "<div id='zoom-in' class='zoom-control-btn'><i class='icon-plus fa fa-plus'></i></div><br>" +
                    "<div id='zoom-out' class='zoom-control-btn'><i class='icon-minus fa fa-minus'></i></div>" +
                    "</div>", {

                    /**
                     * Redefining methods of the layout, in order to perform
                     * additional steps when building and clearing the layout.
                     */
                    build: function () {
                        // Calling the "build" parent method.
                        ZoomLayout.superclass.build.call(this);

                        /**
                         * Binding handler functions to the context and storing references
                         * to them in order to unsubscribe from the event later.
                         */
                        this.zoomInCallback = ymaps.util.bind(this.zoomIn, this);
                        this.zoomOutCallback = ymaps.util.bind(this.zoomOut, this);

                        // Beginning to listen for clicks on the layout buttons.
                        $('#zoom-in').bind('click', this.zoomInCallback);
                        $('#zoom-out').bind('click', this.zoomOutCallback);
                    },

                    clear: function () {
                        // Removing click handlers.
                        $('#zoom-in').unbind('click', this.zoomInCallback);
                        $('#zoom-out').unbind('click', this.zoomOutCallback);

                        // Calling the "clear" parent method.
                        ZoomLayout.superclass.clear.call(this);
                    },

                    zoomIn: function () {
                        var map = this.getData().control.getMap();
                        map.setZoom(map.getZoom() + 1, {checkZoomRange: true});
                    },

                    zoomOut: function () {
                        var map = this.getData().control.getMap();
                        map.setZoom(map.getZoom() - 1, {checkZoomRange: true});
                    }
                }),
                zoomControl = new ymaps.control.ZoomControl({options: {layout: ZoomLayout}});

                this.map.controls.add(zoomControl, {
                    float: 'none',
                    position: {
                        top: screen.width <= 767 ? 160 : 400,
                        right: screen.width <= 767 ? 15 : 50
                    }
                });

                let GeolocationControl = ymaps.templateLayoutFactory.createClass(
                    '<div class="location-control">' +
                    '<div class="location-control-btn"><i class="fa fa-location-arrow"></i></div>' +
                    '</div>'
                ),
                geolocationControl = new ymaps.control.GeolocationControl({options: {layout: GeolocationControl}});

                this.map.controls.add(geolocationControl, {
                    float: 'none',
                    position: {
                        top: screen.width <= 767 ? 90 : 330,
                        right: screen.width <= 767 ? 15 : 50
                    }
                });

                this.setMarkers()

                // this.map.setBounds(this.map.geoObjects.getBounds(),{checkZoomRange:true, zoomMargin:9});
                
            },
            setMarkers() {
                if (this.ajaxData.length === 0) {
                    return;
                }
                this.map.geoObjects.removeAll()

                // var MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
                //     '<div class="adres-popover">' + 
                //         '<a href="#" class="close" style="color: white; text-shadow: none; z-index: 2; position: absolute; right: 5px; top: 5px;">' + 
                //         '<i class="fas fa-times" style="color:#fff;margin: 10px;"></i>' + 
                //         '</a>' +
                //         '$[[options.contentLayout]]' +
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
                //             console.log('left',-(this._$element[0].offsetWidth / 2))
                //             console.log('top', -(this._$element[0].offsetHeight))
                //             if (screen.width <= "768") {
                //                 this._$element.css({
                //                     left: -(this._$element[0].offsetWidth / 2 + 10),
                //                     top: -(this._$element[0].offsetHeight / 2),
                //                     // marginLeft: -227,
                //                     // bottom: -120,
                //                     position: 'absolute'
                //                 });
                //             } else {
                //                 this._$element.css({
                //                     left: -(this._$element[0].offsetWidth / 2 + 10),
                //                     top: -(this._$element[0].offsetHeight),
                //                     // marginLeft: -227,
                //                     // bottom: -120,
                //                     position: 'absolute'
                //                 });
                //             }
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
                //                     position.top + this._$element[0].offsetHeight
                //                 ]
                //             ]));
                //         },
                //         _isElement: function (element) {
                //             return element && element[0] && element.find('.arrow')[0];
                //         }
                //     })

                // var MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
                //     '$[properties.companies]'
                // )


                ymaps.option.presetStorage.add('map#close', {
                    iconLayout: 'default#imageWithContent',
                    iconImageHref: '/images/icons/map-point-open.svg',
                    // balloonLayout: MyBalloonLayout,
                    // balloonContentLayout: MyBalloonContentLayout,
                    iconImageOffset: [-24, -24],
                    // iconContentOffset: [15, 15],
                    iconImageSize: [22, 30],
                    balloonShadow: false,
                    openBalloonOnClick: this.balloon
                });

                ymaps.option.presetStorage.add('map#open', {
                    iconLayout: 'default#imageWithContent',
                    iconImageHref: '/images/pages/contacts/placemark.png',
                    // balloonLayout: MyBalloonLayout,
                    // balloonContentLayout: MyBalloonContentLayout,
                    iconImageOffset: [-43, -43],
                    // iconContentOffset: [15, 15],
                    // iconImageSize: [22, 30],
                    iconImageSize: [43, 43],
                    // iconImageOffset: [-24, -24],
                    balloonShadow: false,
                });

                let arrayfiltering = this.ajaxData.filter(adres => {
                        return adres.company
                    })

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
                // if (arrayfiltering.length == 0) return false
                this.placemarks = arrayfiltering.reduce(function (res, a, index, arr) {
                    // if (a.companies) {
                    //     var companies = a.companies.map((company, indexx, arrr) => {
                    //         let ress = `<div class="company-item">
                    //                         <div class="search-panel__company-block">
                    //                             <img src="${company.image_url}"/>
                    //                             <a href="/company/${company.slug}">
                    //                                 <div class="events-block__empty" style="z-index: unset;"></div>
                    //                                 <div class="animation-block"></div>
                    //                             </a>

                    //                             <a href="/company/category/${company.categories[0].slug}">
                    //                                 <div class="search-panel__company-group">
                    //                                     ${company.categories[0].name}
                    //                                 </div>
                    //                             </a>

                    //                             <div class="search-panel__company-text">
                    //                                 <div class="search-panel__company-title">${company.name}</div>
                    //                                 <div class="search-panel__company-place">${a.address}</span></div>
                    //                                 <div class="search-panel__company-badges">
                    //                                     <img src="/images/icons/thumb-up-black.svg"/>
                    //                                     <span>${company.rec}</span>
                    //                                     <img class="star" src="/images/icons/star.svg"/>
                    //                                     <span>${Math.round(company.star, 1)}</span>
                    //                                 </div>
                    //                             </div>
                    //                         </div>
                    //                     </div>`
                    //         return ress
                    //     })
                    //     companies = companies.join(' ')
                    // } else {
                    //     var companies = ''
                    // }
                    res.push(new ymaps.Placemark([a.lat, a.long], {
                        id: a.id,
                        address: a.address,
                        companies: a.companies
                    }, {
                        preset: 'map#close'
                    }))

                    return res
                }, [])

                this.clusterer = new ymaps.Clusterer({
                    preset: 'islands#blueCircleIcon',
                    groupByCoordinates: false,
                }).add(this.placemarks)


                this.map.geoObjects.add(this.clusterer)

                // this.map.geoObjects.events.add('click', function (e) {
                //     var target = e.get('target');
                //     console.log(target.properties.get('id'))
                // });
                // var activeBalloon = this.placemarks.find(pm => {
                //     console.log('pm', pm)
                //     console.log("pm.properties.get('id')", pm.properties.get('id'), (new URL(document.location)).searchParams.get('balloonid'))
                //     return pm.properties.get('id') == Number((new URL(document.location)).searchParams.get('balloonid'))
                // })
                // console.log('activeBalloon', activeBalloon === (new URL(document.location)).searchParams.get('balloonid'))
                // if (activeBalloon) {
                //     // Откроем балун на третьей метке в массиве.
                //     var objectState = clusterer.getObjectState(activeBalloon);
                //     if (objectState.isClustered) {
                //         console.log('hi2')
                //         // Если метка находится в кластере, выставим ее в качестве активного объекта.
                //         // Тогда она будет "выбрана" в открытом балуне кластера.
                //         objectState.cluster.state.set('activeObject', activeBalloon);
                //         clusterer.balloon.open(objectState.cluster);
                //     } else if (objectState.isShown) {
                //         console.log('hi')
                //         // Если метка не попала в кластер и видна на карте, откроем ее балун.
                //         activeBalloon.balloon.open();
                //     }
                // }

                this.clusterer.events.add('click', (e) => {
                    var target = e.get('target');
                    if (target.geometry && typeof target.getGeoObjects) {
                        ymaps.geoQuery(this.placemarks).setOptions('preset', 'map#close')
                        var id = target.properties.get('id')
                        // if (this.carousel) {
                            // this.$bus.$emit('mapSelectId', id)
                        // }
                        // console.log(target.properties.get('companies'))
                        if (target.properties.get('companies')) {
                            this.$bus.$emit('fetchPlacemarkCompanies', target.properties.get('companies'), target.properties.get('address'))
                        }
                        this.placemarks.forEach((placemark, i) => {


                            if (placemark.properties.get('id') === id) {
                                const url = new URL(document.location);
                                const searchParams = url.searchParams;
                                // searchParams.set('lat', placemark.geometry.getCoordinates()[0])
                                // searchParams.set('long', placemark.geometry.getCoordinates()[1])
                                if (searchParams.get('balloonid')) {
                                    searchParams.delete('balloonid');
                                }
                                searchParams.set('balloonid', id)
                                window.history.pushState({}, '', url.toString());
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
                // this.setBounds()
                // this.openBalloon((new URL(document.location)).searchParams.get('balloonid'))
                // if ((new URL(document.location)).searchParams.get('lat')) {
                //     console.log('asdasd')
                //     this.map.panTo([Number((new URL(document.location)).searchParams.get('lat')), Number((new URL(document.location)).searchParams.get('long'))])
                // }
                if ((new URL(document.location)).searchParams.get('balloonid')) {
                    this.openBalloon((new URL(document.location)).searchParams.get('balloonid'))
                }
            },
            // setBounds() {
            //     // this.map.setBounds(this.map.geoObjects.getBounds(), {checkZoomRange: true})

            //    setTimeout(() => {
            //     this.map.setBounds(this.map.geoObjects.getBounds(), {checkZoomRange: true})
            //         this.map.setZoom(this.map.getZoom() - 1)
            //     }, 1000)


            // },
            openBalloon(id) {
                // console.log(id)
                // if (this.carousel) {
                //     this.$bus.$emit('mapSelectId', id)
                // }
                this.placemarks.forEach((placemark) => {
                    // console.log(placemark.properties.get('id') === Number(id))
                    // ymaps.geoQuery(placemark).setOptions('preset', 'map#close')
                    if (placemark.properties.get('id') === Number(id)) {
                        this.$bus.$emit('fetchPlacemarkCompanies', placemark.properties.get('companies'), placemark.properties.get('address'))
                        // console.log(id)
                        ymaps.geoQuery(placemark).setOptions('preset', 'map#open')
                        // console.log(placemark.geometry.getCoordinates())
                        this.map.panTo(placemark.geometry.getCoordinates())
                            .then(function () {
                                // Откроем балун на третьей метке в массиве.
                                this.map.setCenter(placemark.geometry.getCoordinates(), 10, {checkZoomRange: true})
                                    // .then(() => {
                                        // var objectState = this.clusterer.getObjectState(placemark);
                                        // if (objectState.isClustered) {
                                            // Если метка находится в кластере, выставим ее в качестве активного объекта.
                                            // Тогда она будет "выбрана" в открытом балуне кластера.
                                            // objectState.cluster.state.set('activeObject', placemark);
                                            // this.clusterer.balloon.open(objectState.cluster);
                                        // } else if (objectState.isShown) {
                                            // Если метка не попала в кластер и видна на карте, откроем ее балун.
                                            // placemark.balloon.open();
                                        // }
                                    // })
                                // console.log('sdfsdf', this.objectManager)
                                // placemark.balloon.open()
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
