<template>
    <a-form layout="vertical">
        <br>
        <a-row>
            <a-col :xs="{span: 24}" :lg="{span: 12}">
                <a-form-item>
                  <a-select
                          show-search
                          :value="value"
                          placeholder="Начните вводить адрес и выберите подходящий"
                          style="width: 100%"
                          :default-active-first-option="false"
                          :show-arrow="false"
                          :filter-option="false"
                          :not-found-content="null"
                          @search="handleSearchAddress"
                          @change="handleChangeAddress"
                          @focus="holdSelectedValue"
                  >
                    <a-select-option
                            v-for="d in data"
                            :key="d.unrestricted_value"
                    >
                      {{ d.unrestricted_value }}
                    </a-select-option>
                  </a-select>
                  <!-- <a-auto-complete
                    v-model="value"
                    style="width: 100%"
                    placeholder="Начните вводить адрес и выберите подходящий"
                    @select="handleChangeAddress"
                    @search="handleSearchAddress"
                    @change="handleChangeAddress"
                  >
                  <template slot="dataSource">
                    <a-select-option
                            v-for="d in data"
                            :key="d.unrestricted_value"
                    >
                      {{ d.unrestricted_value }}
                    </a-select-option>
                  </template>
                </a-auto-complete> -->
                </a-form-item>

                <a-form-item
                    v-if="address.lat && address.long"
                >
                    <yandex-map
                        :coords="[address.lat, address.long]"
                        style="height: 300px; width: 100%;"
                        @click="onClick"
                        :controls="['zoomControl']"
                    >
                        <ymap-marker
                                marker-id="1"
                                :icon="markerIcon"
                                :coords="[address.lat, address.long]"
                        />
                    </yandex-map>
                </a-form-item>
            </a-col>
            <a-col :xs="{ span: 24, offset: 0 }" :lg="{ span: 8, offset: 2 }">
                <template v-if="address.lat && address.long">
                    <a-form-item
                        label="Отображаемый адрес"
                        :validate-status="errors.address ? 'error' : ''"
                    >
                        <a-input
                            v-model="address.address"
                            placeholder="Адрес"
                            readOnly
                        />
                    </a-form-item>
                    <a-form-item
                        v-if="citySelect"
                        label="Город"
                    >
                        <a-select
                            show-search
                            placeholder="Выберите город"
                            option-filter-prop="children"
                            style="width: 100%"
                            :filter-option="filterOption"
                            @change="handleChange"
                        >
                            <template v-for="city in cities">
                                <a-select-option :value="city.name">
                                    {{ city.name }}
                                </a-select-option>
                            </template>
                        </a-select>
                    </a-form-item>

                    <a-form-item
                        label="Телефон"
                        :validate-status="errors.phone ? 'error' : ''"
                    >
                        <a-input
                            @change="editphone(address.phone, 'phone')"
                            v-model="address.phone"
                            placeholder="+7 (000) 000-00-00"
                            v-mask="maskactive"

                        />
                        <!-- <a
                          @click.prevent="deletePhone('phone')"
                          style="float:right;"
                        >
                          <a-icon type="delete" />
                        </a> -->
                    </a-form-item>
                    <a-button style="padding-left:0;" type="link" @click="isvisible=!isvisible" v-if="!isvisible">+ добавить телефон
                    </a-button>
                    <a-form-item
                        label=""
                        :validate-status="errors.phone2 ? 'error' : ''"
                        v-if="isvisible"
                    >
                        <a-input
                            @change="editphone(address.phone2, 'phone2')"
                            v-model="address.phone2"
                            placeholder="+7 (000) 000-00-00"
                            v-mask="maskactivetwo"
                        />
                        <a
                          @click.prevent="deletePhone('phone2')"
                          style="position: absolute;
                            right: 5px;"
                        >
                          <a-icon type="delete" />
                        </a>
                    </a-form-item>

                    <a-form-item
                        label="Сайт"
                        :validate-status="errors.site ? 'error' : ''"
                    >
                        <a-input
                            v-model="address.site"
                            placeholder="Сайт"
                        />
                    </a-form-item>

                    <a-form-item
                        label="Режим работы"
                        :validate-status="errors.days ? 'error' : ''"
                    >
                        <a-checkbox :checked="address.work" @change="onChange" style="margin-bottom: 5px;">Круглосуточно</a-checkbox>

                        <template v-if="address.work==null || address.work==false">
                            <a-button-group style="margin-bottom: 10px;min-width: 350px;display: flex;">

                                <a-button
                                     class="day-btn"
                                    :class="[activedn == 'mon' ? 'active': '', address.mon != null ? 'notnull':'']"
                                    @click="activedn = 'mon'">ПН
                                </a-button>
                                <a-button
                                     class="day-btn"
                                    :class="[activedn == 'tue' ? 'active': '', address.tues != null ? 'notnull':'']"
                                    @click="activedn = 'tue'">ВТ
                                </a-button>
                                <a-button
                                     class="day-btn"
                                    :class="[activedn == 'wed' ? 'active': '', address.wed != null ? 'notnull':'']"
                                    @click="activedn = 'wed'">СР
                                </a-button>
                                <a-button
                                     class="day-btn"
                                    :class="[activedn == 'thu' ? 'active': '', address.thurs != null ? 'notnull':'']"
                                    @click="activedn = 'thu'">ЧТ
                                </a-button>
                                <a-button
                                     class="day-btn"
                                    :class="[activedn == 'fri' ? 'active': '', address.fri != null ? 'notnull':'']"
                                    @click="activedn = 'fri'">ПТ
                                </a-button>
                                <a-button
                                     class="day-btn"
                                    :class="[activedn == 'sat' ? 'active': '', address.sat != null ? 'notnull':'']"
                                    @click="activedn = 'sat'">СБ
                                </a-button>
                                <a-button
                                     class="day-btn"
                                    :class="[activedn == 'sun' ? 'active': '', address.sun != null ? 'notnull':'']"
                                    @click="activedn = 'sun'">ВС
                                </a-button>

                            </a-button-group>

                            <template v-if="activedn == 'mon'">
                                <div class="components-input" style="    display: flex;    align-items: center;">
                                    <a-input v-model="address.mon" v-mask="'##:##-##:##'" placeholder="00:00-00:00"/>
                                </div>
                            </template>
                            <template v-if="activedn == 'tue'">
                                <div class="components-input" style="    display: flex;    align-items: center;">
                                    <a-input v-model="address.tues" v-mask="'##:##-##:##'" placeholder="00:00-00:00"/>
                                </div>
                            </template>
                            <template v-if="activedn == 'wed'">
                                <div class="components-input" style="    display: flex;    align-items: center;">
                                    <a-input v-model="address.wed" v-mask="'##:##-##:##'" placeholder="00:00-00:00"/>
                                </div>
                            </template>
                            <template v-if="activedn == 'thu'">
                                <div class="components-input" style="    display: flex;    align-items: center;">
                                    <a-input v-model="address.thurs" v-mask="'##:##-##:##'" placeholder="00:00-00:00"/>
                                </div>
                            </template>
                            <template v-if="activedn == 'fri'">
                                <div class="components-input" style="    display: flex;    align-items: center;">
                                    <a-input v-model="address.fri" v-mask="'##:##-##:##'" placeholder="00:00-00:00"/>
                                </div>
                            </template>
                            <template v-if="activedn == 'sat'">
                                <div class="components-input" style="    display: flex;    align-items: center;">
                                    <a-input v-model="address.sat" v-mask="'##:##-##:##'" placeholder="00:00-00:00"/>
                                </div>
                            </template>
                            <template v-if="activedn == 'sun'">
                                <div class="components-input" style="    display: flex;    align-items: center;">
                                    <a-input v-model="address.sun" v-mask="'##:##-##:##'" placeholder="00:00-00:00"/>
                                </div>
                            </template>

                        </template>

                    </a-form-item>

                </template>
            </a-col>
        </a-row>
    </a-form>
</template>
<script>
    import jsonp from 'fetch-jsonp';
    import querystring from 'querystring';

    let timeout;
    let currentValue;

    let str = window.location.pathname
    let res = str.split("/")

    function fetch(value, callback) {
        if (timeout) {
            clearTimeout(timeout);
            timeout = null;
        }
        currentValue = value;

        function fake() {
            axios({
                method: 'post',
                url: 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',
                data: {
                    'query': value,
                    'count': 20
                },
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Token 7a5550df271aa8ea1b11dd2749f09f3951eccc3e'
                }
            }).then(response => {
                if (currentValue === value) {
                    callback(response.data.suggestions);
                }
            });
        }

        timeout = setTimeout(fake, 300);
    }

    function fetch2(value, callback) {
        if (timeout) {
            clearTimeout(timeout);
            timeout = null;
        }
        currentValue = value;

        function fake() {
            axios({
                method: 'post',
                url: 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address',
                data: {
                    'lat': value[0],
                    'lon': value[1]
                },
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Token 7a5550df271aa8ea1b11dd2749f09f3951eccc3e'
                }
            }).then(response => {
                if (currentValue === value) {
                    callback(response.data.suggestions);
                }
            });
        }

        timeout = setTimeout(fake, 300);
    }

    function getCoords(value, callback) {
        const str = querystring.encode({
            apikey: "f679a5dd-9081-411e-abf2-ac4a32c74e0c",
            geocode: value,
            format: "json"
        });
        jsonp(`https://geocode-maps.yandex.ru/1.x/?${str}`)
            .then(response => response.json())
            .then((d) => {
                callback(d.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' '))
            });
    }

    function clearObject(value) {
        for (const prop of Object.getOwnPropertyNames(value)) {
            value[prop] = null;
        }
    }

    export default {
        props: {
            address: {
                type: Object,
                default: null,
            }
        },
        data() {
            return {
                maskactive: '+7 (###) ###-##-##',
                maskactivetwo: '+7 (###) ###-##-##',
                maskone: '+7 (###) ###-##-##',
                masktwo: '8 (###) ###-##-##',
                maskthree: '+# (###) ###-##-##',
                isvisible: false,
                dni: null,
                activedn: 'mon',
                krug: false,

                cities: [], // список всех городов для селекта
                data: [], // список адресов из dadata
                value: undefined, // текущий адрес dadata
                citySelect: false, // виден ли выпадающий список городов
                errors: {},
                loading: false,
                alert: false,
                markerIcon: {
                    layout: 'default#imageWithContent',
                    imageHref: '/images/icons/blue-cricle-placemark.png',
                    imageSize: [20, 20],
                    imageOffset: [-24, -24],
                    content: '',
                    contentOffset: [],
                    contentLayout: ''
                },
            };
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            }
        },
        mounted() {
            this.fetchCities()
            let date = new Date()
            this.activedn = this.getWeekDay(date)
            this.address.phone2 && this.address.phone2 !== '' ? this.isvisible = true : this.isvisible = false
        },
        methods: {
            holdSelectedValue() {
                setTimeout(() => {
                  $('.ant-select-selection-selected-value').text('')
                  $('.ant-select-search__field').val(this.value)
                })
              },
            deletePhone(value) {
                this.address[value] = ''
                if (value == 'phone2') {
                    this.isvisible = false
                }
            },
            editphone(telephone, phone) {
                if (telephone[0] == '8') {

                    phone == 'phone' ? this.maskactive = this.masktwo : this.maskactivetwo = this.masktwo

                } else {
                    if (telephone[0] == '7') {
                        phone == 'phone' ? this.maskactive = this.maskthree : this.maskactivetwo = this.maskthree
                    } else {
                        phone == 'phone' ? this.maskactive = this.maskone : this.maskactivetwo = this.maskone
                    }
                }
            },
            onChange() {
                this.address.work = !this.address.work
                if (this.address.work) {
                    this.address.mon   = null
                    this.address.tues  = null
                    this.address.wed   = null
                    this.address.thurs = null
                    this.address.fri   = null
                    this.address.sat   = null
                    this.address.sun   = null
                }
            },
            getWeekDay(date) {
                let days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat']
                return days[date.getDay()]
            },
            fetchCities() {
                this.loading = true
                const message = this.$message.loading('Загрузка данных', 0)
                axios.get(`/api/cabinet/city/all`)
                    .then(response => {
                        this.cities = response.data
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
                    .then(() => {
                        setTimeout(message, 0)
                        this.loading = false
                    })
            },
            handleChange(value) {
                this.address.city = this.cities.filter((item) => {
                    return item.name === value;
                })[0];
            },
            filterOption(input, option) {
                return option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
            },
            handleSearchAddress(value) {
                fetch(value, data => this.data = data);
            },
            handleChangeAddress(value) {
                console.log('value', value)
                this.value = value
                setTimeout(() => {
                  $('.ant-select-selection-selected-value').text(this.value)
                  $('.ant-select-search__field').val('')
                })
                fetch(value, data => {
                    this.data = data
                    console.log(this.data)
                    // достаем один элемент адреса дадаты
                    var current = data.length === 1 ? data[0] : data.filter((item) => {
                        return item.unrestricted_value === value;
                    })[0];

                    // текстовый вариант адреса
                    this.address.address = [
                        current.data.city,
                        current.data.settlement_with_type,
                        current.data.street_with_type,
                        current.data.house,
                    ].filter(Boolean).join(', ')

                    // координаты адреса, если определены
                    this.address.lat = current.data.geo_lat
                    this.address.long = current.data.geo_lon

                    // если не определены, то определяем
                    if (!current.data.geo_lat || !current.data.geo_lon) {
                        getCoords(this.address.address, data => {
                            this.address.lat = data[1]
                            this.address.long = data[0]
                        })
                    }

                    // название города и определение координат, если город определился
                    clearObject(this.address.city)
                    if (current.data.city) {
                        this.citySelect = false
                        getCoords(current.data.city, data => {
                            this.address.city.name = current.data.city
                            this.address.city.lat = data[1]
                            this.address.city.long = data[0]
                        })
                    } else {
                        this.citySelect = true
                    }
                });
            },
            onClick(e) {
                this.address.lat = e.get('coords')[0]
                this.address.long = e.get('coords')[1]
                fetch2(e.get('coords'), data => {
                    this.data = data
                    console.log('data', data)
                    console.log('lat', this.address.lat)
                    console.log('lon', this.address.long)
                    // достаем один элемент адреса дадаты
                    var current = data[0]

                    // текстовый вариант адреса
                    this.address.address = [
                        current.data.city,
                        current.data.settlement_with_type,
                        current.data.street_with_type,
                        current.data.house,
                    ].filter(Boolean).join(', ')

                    // координаты адреса, если определены
                    // this.address.lat = current.data.geo_lat
                    // this.address.long = current.data.geo_lon

                    // если не определены, то определяем
                    if (!current.data.geo_lat || !current.data.geo_lon) {
                        console.log('данные не определены')
                        getCoords(this.address.address, data => {
                            this.address.lat = data[1]
                            this.address.long = data[0]
                        })
                    }

                    // название города и определение координат, если город определился
                    clearObject(this.address.city)
                    if (current.data.city) {
                        this.citySelect = false
                        getCoords(current.data.city, data => {
                            this.address.city.name = current.data.city
                            this.address.city.lat = data[1]
                            this.address.city.long = data[0]
                        })
                    } else {
                        this.citySelect = true
                    }
                })
            }
        }
    };
</script>

<style>

    .ant-btn.active {
        color: #096dd9 !important;
        background: #fff !important;
        /*border-color: unset !important;*/
        /*border: none;*/
    }

    .ant-btn.notnull {
        color: white;
        background: #096dd9;
        border-color: #096dd9;
    }
    .day-btn {
        flex: 1;
    }
    label {
        margin-bottom: 0;
    }

    .ymap-container {
        height: 100%;
    }

    @media (min-width: 930px) {
        .ant-modal-body {
            padding: 0 24px;
        }

        .ant-form-item {
            margin-bottom: 10px;
        }
    }
    @media (max-width: 767px) {
        .day-btn {
            padding: 0 14px;
            flex: none;
        }
    }
</style>
