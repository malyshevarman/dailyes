<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff' }">
      <b-alert
        :show="Object.keys(errors).length > 0"
        variant="danger"
        dismissible
      >
        <template v-for="error in errors">
          <template v-for="message in error">
            {{ message }}<br>
          </template>
        </template>
      </b-alert>
      <a-tabs>
        <a-tab-pane
          key="1"
          tab="Основная информация"
        >
          <a-form layout="vertical">
            <br>
            <a-form-item>
              <a-select
                show-search
                :value="value"
                placeholder="Начните вводить город выберите подходящий"
                style="width: 100%"
                :default-active-first-option="false"
                :show-arrow="false"
                :filter-option="false"
                :not-found-content="null"
                @search="handleSearchAddress"
                @change="handleChangeAddress"
              >
                <a-select-option
                  v-for="d in data"
                  :key="d.unrestricted_value"
                >
                  {{ d.unrestricted_value }}
                </a-select-option>
              </a-select>
            </a-form-item>

            <a-form-item
              v-if="city.lat && city.long"
            >
              <yandex-map
                :coords="[city.lat, city.long]"
                style="height: 400px"
              >
                <ymap-marker
                  marker-id="1"
                  marker-type="placemark"
                  hint-content="element.hint"
                  :coords="[city.lat, city.long]"
                />
              </yandex-map>
            </a-form-item>

            <template v-if="city.lat && city.long">
              <a-form-item
                label="Отображаемое название"
                :validate-status="errors.name ? 'error' : ''"
              >
                <a-input
                  v-model="city.name"
                  placeholder="Город"
                />
              </a-form-item>

              <a-form-item
                label="Таймзона"
                :validate-status="errors.timezone ? 'error' : ''"
              >
                <a-input
                  v-model="city.timezone"
                  placeholder="Таймзона"
                  disabled
                />
              </a-form-item>

              <a-form-item
                label="Широта"
                :validate-status="errors.lat ? 'error' : ''"
              >
                <a-input
                  v-model="city.lat"
                  placeholder="Широта"
                  disabled
                />
              </a-form-item>

              <a-form-item
                label="Долгота"
                :validate-status="errors.long ? 'error' : ''"
              >
                <a-input
                  v-model="city.long"
                  placeholder="Долгота"
                  disabled
                />
              </a-form-item>
            </template>
          </a-form>
        </a-tab-pane>
        <div slot="tabBarExtraContent">
          <a-button
            v-if="city.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить
          </a-button>
          <a-button
            :disabled="loading"
            @click="city.id ? update() : create()"
          >
            Сохранить
          </a-button>
        </div>
      </a-tabs>
    </a-layout-content>
  </a-layout>
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
                    'count': 5,
                    'from_bound': {
                        'value': 'city'
                    },
                    'locations': {
                        'city_type_full': 'город'
                    },
                    'restrict_value': false,
                    'to_bound': {
                        'value': 'city'
                    }
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
            apikey: "6089fdb3-2842-4cfc-bfd6-4f933414f0bd",
            geocode: value,
            format: "json"
        });
        jsonp(`https://geocode-maps.yandex.ru/1.x/?${str}`)
            .then(response => {})
            .then((d) => {
                callback(d.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' '))
            });
    }

    function getTimezone(value, callback) {
        //TODO убрать стронний клиент
        googleMapsClient.timezone({location: value, timestamp: 0})
            .asPromise()
            .then((response) => {
                callback(response.json.timeZoneId)
            })
            .catch((err) => {
                console.log(err);
            });
    }

    export default {
        props: {
            company: {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                data: [], // список адресов из dadata
                value: undefined, // текущий адрес dadata
                city: {
                    lat: null,
                    long: null,
                    timezone: null,
                    name: null
                },
                errors: {},
                loading: false,
                alert: false
            };
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            },
            'city.lat': function (val) {
                val !== '' ? delete this.errors['lat'] : ''
            },
            'city.long': function (val) {
                val !== '' ? delete this.errors['long'] : ''
            },
            'city.name': function (val) {
                console.log('hhhhhh')
                val !== '' ? delete this.errors['name'] : ''
            },
        },
        mounted() {
            if (res[4] === 'edit') {
                this.fetch()
            }
        },
        methods: {
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/city/${res[3]}`)
                        .then(response => {
                            this.city = response.data
                        })
                        .catch(error => {
                            this.$message.error('Ошибка')
                        })
                        .then(() => {
                            setTimeout(message, 0)
                            this.loading = false
                        })
                }

            },
            update() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Сохранение', 0)
                    axios.put(`/api/backend/city/${res[3]}`, this.city)
                        .then(response => {
                            this.errors = {}
                            this.city = response.data
                            this.$message.success('Успешно сохранено!')
                        })
                        .catch(error => {
                            this.$message.error('Ошибка')
                            this.errors = error.response.data.errors
                        })
                        .then(() => {
                            setTimeout(message, 0)
                            this.loading = false
                        })
                }
            },
            create() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Сохранение', 0)
                    axios.post(`/api/backend/city`, this.city)
                        .then(response => {
                            this.errors = {}
                            this.city = response.data
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/city/${response.data.slug}/edit`
                        })
                        .catch(error => {
                            this.$message.error('Ошибка')
                            this.errors = error.response.data.errors
                        })
                        .then(() => {
                            setTimeout(message, 0)
                            this.loading = false
                        })
                }
            },
            destroy() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Сохранение', 0)
                    swal({
                        title: "Вы уверены?",
                        text: "Это необратимый процесс!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                axios.delete(`/api/backend/city/${res[3]}`)
                                    .then(response => {
                                        location.replace(`/admin/city`)
                                    })
                                    .catch(error => {
                                        this.errors = error.response.data.errors
                                        this.$message.error('Ошибка')
                                    })
                            }
                        })
                        .then(() => {
                            setTimeout(message, 0)
                            this.loading = false
                        })
                }
            },
            handleSearchAddress(value) {
                fetch(value, data => this.data = data);
            },
            handleChangeAddress(value) {
                this.value = value

                fetch(value, data => {
                    this.data = data

                    // достаем один элемент адреса дадаты
                    var current = data.length === 1 ? data[0] : data.filter((item) => {
                        return item.unrestricted_value === value;
                    })[0];

                    // текстовый вариант адреса
                    this.city.name = current.data.city

                    // координаты адреса, если определены
                    this.city.lat = current.data.geo_lat
                    this.city.long = current.data.geo_lon

                    // если не определены, то определяем
                    if (!current.data.geo_lat || !current.data.geo_lon) {
                        getCoords(this.city.name, data => {
                            this.city.lat = data[1]
                            this.city.long = data[0]
                        })
                    }

                    // если не определена таймзона
                    if (!current.data.timezone) {
                        getTimezone(this.city.lat + ',' + this.city.long, data => {
                            this.city.timezone = data
                        })
                    }
                });
            },
        }
    };
</script>

<style>
    label {
        margin-bottom: 0;
    }

    .ymap-container {
        height: 100%;
    }
</style>
