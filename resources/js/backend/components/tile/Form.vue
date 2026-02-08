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
              label="Название"
              :validate-status="errors.name ? 'error' : ''"
            >
              <a-input
                v-model="tile.name"
                placeholder="Рейтинг ресторанов"
                @input="delete errors['name']"
              />
            </a-form-item>

            <a-form-item
              label="Краткое описание"
              :validate-status="errors.summary ? 'error' : ''"
            >
              <a-textarea
                id="summary"
                v-model="tile.summary"
                @input="delete errors['summary']"
              />
            </a-form-item>

            <a-form-item
                    label="Город размещения"
            >
              <select-single
                      v-model="tile.city"
                      :data="cities"
                      placeholder="Выберите город размещения"
              />
            </a-form-item>

            <template v-show="tile.city !== null && Object.keys(tile.city).length > 0">
              <a-form-item
                v-show="tile.companies.length === 0 && !tile.category"
                label="Акции"
                :validate-status="tile.events.length == 1 && tile.events[0].end ? 'warning' : ''"
                :help="tile.events.length == 1 && tile.events[0].end ? `Акция завершится ${eventEndDate()}, после чего плитка не будет отображаться на сайте` : ''"
              >
                <select-search
                  v-model="tile.events"
                  :url="'/api/backend/event/search/'"
                  mode="single"
                />
              </a-form-item>

              <a-form-item
                v-show="tile.events.length === 0 && !tile.category"
                label="Компании"
              >
                <select-search
                  v-model="tile.companies"
                  :url="'/api/backend/company/search/'"
                  mode="single"
                />
              </a-form-item>
            </template>

            <a-form-item
                    label="Категория"
                    v-show="tile.events.length <= 0 && tile.companies.length <= 0"
            >
              <select-single
                      v-model="tile.category"
                      :data="categories"
                      placeholder="Выберите категорию"
              />
            </a-form-item>

            <a-form-item
                    label="Тег"
                    v-show="tile.category"
            >
              <select-single
                      v-model="tile.categories_tag"
                      :data="tags"
                      placeholder="Выберите тэг"
              />
            </a-form-item>

            <a-form-item
              label="Дата публикации"
              :validate-status="errors.start ? 'error' : ''"
            >
              <a-checkbox :checked="nolimit == true" @change="nolimit=!nolimit, tile.end = null">Бессрочный</a-checkbox>
                <a-range-picker format="DD-MM-YYYY" v-if="!nolimit"  v-model="range" />
                <a-date-picker format="DD-MM-YYYY" v-else v-model="rangeNoLimit"/>

            </a-form-item>

            <a-form-item
              label="Изображение"
              v-show="tile.events && tile.events.length == 0 && tile.companies && tile.companies.length == 0"
            >
              <image-upload
                v-model="tile.image"
                :width="2880"
                :height="886"
              />
            </a-form-item>

            <!-- <a-form-item
              label="Сборка"
            >
              <a-select
                v-model="tile.selection.name"
                show-search
                placeholder="Выберите сборку"
                option-filter-prop="children"
                style="width: 100%"
                :filter-option="filterOption"
                @change="handleChange"
              >
                <template v-for="selection in selections">
                  <a-select-option :value="selection.name">
                    {{ selection.name }}
                  </a-select-option>
                </template>
              </a-select>
            </a-form-item> -->
          </a-form>
        </a-tab-pane>
        <a-tab-pane
          key="2"
          tab="SEO"
        >
          <a-form layout="vertical">
            <br>
            <!-- <a-form-item
              label="Slug"
              :validate-status="errors.slug ? 'error' : ''"
              :help="errors.slug ? errors.slug[0] : ''"
            >
              <a-input
                v-model="category.slug"
                placeholder="Необязательно"
              />
            </a-form-item> -->
            <a-form-item
              label="Тайтл"
              :validate-status="errors.title ? 'error' : ''"
              help="Чтобы указать наименование города или категории укажите переменные city или category соответственно"
            >
              <a-input
                v-model="tile.title"
                placeholder="Тайтл"
              />
            </a-form-item>
            <a-form-item
              label="Мета описание"
              :validate-status="errors.description ? 'error' : ''"
              help="Чтобы указать наименование города или категории укажите переменные city или category соответственно"
            >
              <a-input
                v-model="tile.description"
                placeholder="Мета описание"
              />
            </a-form-item>
            <a-form-item
              label="Текст на странице"
              :validate-status="errors.text ? 'error' : ''"
              help="Чтобы указать наименование города или категории укажите переменные city или category соответственно"
            >
              <vue-tinymce
                id="content"
                v-model="tile.text"
                toolbar="bold italic | alignleft aligncenter alignright | bullist numlist | link image media | insertdatetime | code codesample"
              />
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <div slot="tabBarExtraContent">
          <a-button
            v-if="tile.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить
          </a-button>
          <a-button
            :disabled="loading"
            @click="tile.id ? update() : create()"
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
                // selections: [],
                categories: [],
                cities: [],
                tile: {
                    image: {},
                    // selection: {},
                    city: {},
                    events: [],
                    companies: [],
                    start:moment().format('YYYY-MM-DD HH:mm:ss'),
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
            'tile.companies': function(val) {
              if (val.length > 0) {
                delete this.tile.category
                delete this.tile.categories_tag
              }
            },
            'tile.events': function(val) {
              if (val.length > 0) {
                delete this.tile.category
                delete this.tile.categories_tag
              }
            }
        },
        mounted() {
            if (res[4] === 'edit') {
                this.fetch()
            }
            // this.fetchSelections()
            this.fetchCities()
            this.fetchCategories()
        },
        computed: {
            tags: function() {
              if (this.tile.category && this.categories.length > 0) {
                let tags = this.categories.find(category => category.id == this.tile.category.id).tags
                return tags
              } else {
                return []
              }
            },
            range: {
                get: function () {
                    return [
                        this.tile.start ? moment.utc(this.tile.start) : moment.utc(),
                        this.tile.end ? moment.utc(this.tile.end) : moment.utc()
                    ]
                },
                set: function (value) {
                    this.tile.start = value[0].format('YYYY-MM-DD HH:mm:ss')
                    this.tile.end = value[1].format('YYYY-MM-DD HH:mm:ss')
                    delete this.errors['start']
                }
            },
            rangeNoLimit: {
                get: function () {
                    return moment.utc(this.tile.start)
                },
                set: function (value) {
                    this.tile.start = value.format('YYYY-MM-DD HH:mm:ss')
                    this.tile.end = null
                    delete this.errors['start']
                }

            },
        },
        methods: {
            eventEndDate() {
                return moment(this.tile.events[0].end).format('YYYY-MM-DD')
            },
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/tile/${res[3]}`)
                        .then(response => {
                            this.tile = response.data
                            this.tile.start == null ? this.tile.start = moment().format('YYYY-MM-DD HH:mm:ss') : this.tile.start = this.tile.start
                            this.tile.end == null ? this.nolimit = true : this.nolimit = false
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
                    axios.put(`/api/backend/tile/${res[3]}`, this.tile)
                        .then(response => {
                            this.errors = {}
                            this.tile = response.data
                            this.tile.city ? this.tile.city = this.tile.city : this.tile.city = {}
                            this.tile.end == null ? this.nolimit = true : this.nolimit = false
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
                    axios.post(`/api/backend/tile`, this.tile)
                        .then(response => {
                            this.errors = {}
                            this.tileLabel = response.data
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/tile/${response.data.id}/edit`
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
                                axios.delete(`/api/backend/tile/${res[3]}`)
                                    .then(response => {
                                        location.replace(`/admin/tile`)
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
            // fetchSelections() {
            //     this.loading = true
            //     const message = this.$message.loading('Загрузка данных', 0)
            //     axios.get(`/api/backend/selection/all`)
            //         .then(response => {
            //             this.selections = response.data
            //         })
            //         .catch(error => {
            //             this.$message.error('Ошибка')
            //         })
            //         .then(() => {
            //             setTimeout(message, 0)
            //             this.loading = false
            //         })
            // },
            // handleChange(value) {
            //     this.tile.selection = this.selections.filter((item) => {
            //         return item.name === value;
            //     })[0];
            // },
            // filterOption(input, option) {
            //     return option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
            // },
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
            fetchCategories() {
                this.loading = true
                const message = this.$message.loading('Загрузка данных', 0)
                axios.get(`/api/backend/category/all`)
                    .then(response => {
                        this.categories = response.data
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
                    .then(() => {
                        setTimeout(message, 0)
                        this.loading = false
                    })
            }
        }
    };
</script>

<style scoped>
</style>
