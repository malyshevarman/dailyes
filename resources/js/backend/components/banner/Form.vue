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

            <a-form-item
              label="Ссылка"
              :validate-status="errors.link ? 'error' : ''"
            >
              <a-input
                v-model="banner.link"
                placeholder="Переадресация по нажатию"
                @input="delete errors['link']"
              />
            </a-form-item>

            <a-form-item
              label="Интервал"
              :validate-status="errors.start ? 'error' : ''"
            >
                <a-checkbox :checked="nolimit == true" @change="nolimit=!nolimit, banner.end = null">Бессрочный</a-checkbox>
                <a-range-picker format="DD-MM-YYYY" v-if="!nolimit"  v-model="range" />
                <a-date-picker format="DD-MM-YYYY" v-else v-model="rangeNoLimit"/>
            </a-form-item>

            <a-form-item
              label="Город размещения"
              :validate-status="errors['city.id'] ? 'error' : ''"
            >
              <select-single
                v-model="banner.city"
                :data="cities"
                placeholder="Выберите город размещения"
                @input="delete errors['city.id']"
              />
            </a-form-item>

            <a-form-item
              label="Место размещения"
              :validate-status="errors['place.id'] ? 'error' : ''"
            >
              <select-single
                v-model="banner.place"
                :data="places"
                placeholder="Выберите место размещения"
                @input="delete errors['place.id']"
              />
            </a-form-item>

            <template
              v-if="banner.place.id"
            >
              <a-form-item
                label="Баннер"
                :validate-status="errors['download.id'] ? 'error' : ''"
              >
                <image-upload
                  v-model="banner.download"
                  :width="places.filter(item => item.id === banner.place.id)[0].width"
                  :height="places.filter(item => item.id === banner.place.id)[0].height"
                  @input="delete errors['download.id']"
                />
              </a-form-item>

              <a-form-item
                label="Мобильный баннер"
                :validate-status="errors['mobile.id'] ? 'error' : ''"
              >
                <image-upload
                  v-model="banner.mobile"
                  :width="315"
                  :height="222"
                  @input="delete errors['mobile.id']"
                />
              </a-form-item>
            </template>
          </a-form>
        </a-tab-pane>
        <div slot="tabBarExtraContent">
          <a-button
            v-if="banner.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить
          </a-button>
          <a-button
            :disabled="loading"
            @click="banner.id ? update() : create()"
          >
            Сохранить
          </a-button>
        </div>
      </a-tabs>
    </a-layout-content>
  </a-layout>
</template>
<script>
    import moment from 'moment';

    let str = window.location.pathname
    let res = str.split("/")

    export default {
        data() {
            return {
                nolimit: false,
                places: [],
                cities: [],
                banner: {
                    download: {},
                    mobile: {},
                    place: {},
                    city: {},
                    start:moment().format('YYYY-MM-DD HH:mm:ss'),
                },
                errors: {},
                loading: false,
                alert: false
            };
        },
        computed: {
            range: {
                get: function () {
                    return [
                        this.banner.start ? moment.utc(this.banner.start) : moment.utc(),
                        this.banner.end ? moment.utc(this.banner.end) : moment.utc()
                    ]
                },
                set: function (value) {
                    this.banner.start = value[0].format('YYYY-MM-DD HH:mm:ss')
                    this.banner.end = value[1].format('YYYY-MM-DD HH:mm:ss')
                    delete this.errors['start']
                }
            },
            rangeNoLimit: {
                get: function () {
                    return moment.utc(this.banner.start)
                },
                set: function (value) {
                    this.banner.start = value.format('YYYY-MM-DD HH:mm:ss')
                    this.banner.end = null
                    delete this.errors['start']
                }

            },
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            },
        },
        mounted() {
            this.fetchPlaces()
            this.fetchCities()
            if (res[4] === 'edit') {
                this.fetch()
            }
        },
        methods: {
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/banner/${res[3]}`)
                        .then(response => {
                            this.banner = response.data
                            this.banner.end == null ? this.nolimit = true : this.nolimit = false
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
                    axios.put(`/api/backend/banner/${this.banner.id}`, this.banner)
                        .then(response => {
                            this.errors = {}
                            this.banner = response.data
                            this.banner.end == null ? this.nolimit = true : this.nolimit = false
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
                    axios.post(`/api/backend/banner`, this.banner)
                        .then(response => {
                            this.errors = {}
                            this.banner = response.data
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/banner/${response.data.id}/edit`
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
                                axios.delete(`/api/backend/banner/${this.banner.id}`)
                                    .then(response => {
                                        location.replace(`/admin/banner`)
                                    })
                                    .catch(error => {
                                        this.$message.error('Ошибка')
                                        this.errors = error.response.data.errors
                                    })
                            }
                        })
                        .then(() => {
                            setTimeout(message, 0)
                            this.loading = false
                        })
                }
            },
            fetchPlaces() {
                const message = this.$message.loading('Загрузка данных', 0)
                axios.get(`/api/backend/banner/place/all`)
                    .then(response => {
                        this.places = response.data
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
                    .then(() => {
                        setTimeout(message, 0)
                    })
            },
            fetchCities() {
                const message = this.$message.loading('Загрузка данных', 0)
                axios.get(`/api/backend/city/all`)
                    .then(response => {
                        this.cities = response.data
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
                    .then(() => {
                        setTimeout(message, 0)
                    })
            },
        }
    };
</script>

<style scoped>
</style>
