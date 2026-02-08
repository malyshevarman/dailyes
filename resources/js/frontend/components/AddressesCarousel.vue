<template>
    <div>

        <div class="owl-carousel owl-map-points" v-if="sortaddresses.length > 0">

            <template v-for="address in sortaddresses">
                <div
                    :id="`address-card-${address.id}`"
                    class="map-point"
                    :class="{'active': active === address.id}"
                    @click="$bus.$emit('addressCarouselClick', address.id)"
                >
                    <div class="map-point__top"/>
                    <div class="map-point__adres">
                        {{ address.city.name + ','}}<br>
                        {{address.address }}
                    </div>
                    <template v-if="address.work!=null">
                        <div class="map-point__time">
                            Круглосуточно
                        </div>
                    </template>

                    <template v-if="address.work==null">

                        <div class="map-point__time">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button style="padding-left: 0;" :class="activedn == 'mon' ? 'active': ''" @click="activedn = 'mon'">ПН</button>
                                <button :class="activedn == 'tue' ? 'active': ''" @click="activedn = 'tue'">ВТ</button>
                                <button :class="activedn == 'wed' ? 'active': ''" @click="activedn = 'wed'">СР</button>
                                <button :class="activedn == 'thu' ? 'active': ''" @click="activedn = 'thu'">ЧТ</button>
                                <button :class="activedn == 'fri' ? 'active': ''" @click="activedn = 'fri'">ПТ</button>
                                <button :class="activedn == 'sat' ? 'active': ''" @click="activedn = 'sat'">СБ</button>
                                <button :class="activedn == 'sun' ? 'active': ''" @click="activedn = 'sun'">ВС</button>
                            </div>

                            <template v-if="activedn == 'mon'">
                                <div>
                                {{address.mon == '00:00-00:00' ? 'Выходной' : address.mon}}
                                </div>
                            </template>
                            <template v-if="activedn == 'tue'">
                                <div>
                                {{address.tues == '00:00-00:00' ? 'Выходной' : address.tues}}
                                </div>
                            </template>
                            <template v-if="activedn == 'wed'">
                                <div>
                                {{address.wed == '00:00-00:00' ? 'Выходной' : address.wed}}
                                </div>
                            </template>
                            <template v-if="activedn == 'thu'">
                                <div>
                                {{address.thurs == '00:00-00:00' ? 'Выходной' : address.thurs}}
                                </div>
                            </template>
                            <template v-if="activedn == 'fri'">
                                <div>
                                {{address.fri == '00:00-00:00' ? 'Выходной' : address.fri}}
                                </div>
                            </template>
                            <template v-if="activedn == 'sat'">
                                <div>
                                {{address.sat == '00:00-00:00' ? 'Выходной' : address.sat}}
                                </div>
                            </template>
                            <template v-if="activedn == 'sun'">
                                <div>
                                {{address.sun == '00:00-00:00' ? 'Выходной' : address.sun}}
                                </div>
                            </template>
                        </div>
                    </template>

                    <div class="map-point__phone">
                        <a :href="`tel:${address.phone}`">{{ address.phone }}</a><br>
                        <a v-if="address.phone2 !=null" :href="`tel:${address.phone2}`">{{ address.phone2 }}</a>
                    </div>
                    <!-- <div class="map-point__phone" v-if="address.phone2 !=null">
                        <a :href="`tel:${address.phone2}`">{{ address.phone2 }}</a>
                    </div> -->
                    <div class="map-point__site">
                        <a target="_blank" :href="address.site">{{ address.site }}</a>
                    </div>
                </div>
            </template>


        </div>
    </div>
</template>

<script>

    export default {
        props: [
            'addresses',
            'city'
        ],
        data: () => ({
            active: null,
            activedn: 'mon',
            // nearCity: {}
        }),
        // created() {
        //     axios.get(`/api/frontend/city/near`)
        //         .then(response => {
        //             this.nearCity = response.data

        //         })
        //         .catch(error => {
        //             this.$toasted.global.error('City does not exist!')
        //         })


        // },


        computed: {
            sortaddresses: function () {
                if (this.addresses.length > 0) {
                    return this.addresses.filter((a) => {
                        return a.city.name == this.city.name
                    })
                } else {
                    return []
                }
            }
        },
        mounted() {
            console.log(this.addresses)

            let date = new Date()
            this.activedn = this.getWeekDay(date)


            var owl = $('.owl-carousel');
            owl.owlCarousel({
                margin: 50,
                nav: true,
                navText: ["<img src='/images/icons/left.svg'>", "<img src='/images/icons/right.svg'>"],
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 3
                    },
                    1000: {
                        items: 3
                    }
                }
            });

            owl.on('change.owl.carousel', function (e) {
                var totalPageNumber = e.page.count;
                var currentPageNumber = e.page.index + 1;
                if (currentPageNumber === totalPageNumber - 1) {
                    $('.map-shadow').hide();
                } else {
                    $('.map-shadow').show();
                }
            });

            this.$bus.$on('mapSelectId', (id) => {
                this.active = id
            });


        },
        methods: {
            getNearCity() {

            },
            getWeekDay(date) {
                let days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat']
                return days[date.getDay()]
            },
        }
    }
</script>

<style scoped lang="scss">
    .btn-group {
        button {
            background: none;
            border: 0;
            padding: 0 3px;
        }
    }

    .active {
        color: #0056b3;
    }
</style>
