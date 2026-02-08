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
                v-model="slide.name"
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
                v-model="slide.summary"
                @input="delete errors['summary']"
              />
            </a-form-item>

            <a-form-item
              label="Надпись на кнопке"
              :validate-status="errors.button ? 'error' : ''"
            >
              <a-input
                v-model="slide.button"
                placeholder="Подробнее"
                @input="delete errors['button']"
              />
            </a-form-item>

            <a-form-item
              label="Изображение"
            >
              <image-upload
                v-model="slide.image"
                :width="2880"
                :height="886"
                @input="delete errors['image.id']"
              />
            </a-form-item>

            <a-form-item
                    label="Категория"
            >
              <select-single
                      v-model="slide.category"
                      :data="categories"
                      placeholder="Выберите категорию"
              />
            </a-form-item>

            <a-form-item
                    label="Тег"
                    v-if="slide.category"
            >
              <select-single
                      v-model="slide.categories_tag"
                      :data="tags"
                      placeholder="Выберите тэг"
              />
            </a-form-item>

            <a-form-item
                    label="Город размещения"
            >
              <select-single
                      v-model="slide.city"
                      :data="cities"
                      placeholder="Выберите город размещения"
              />
            </a-form-item>

            <!-- <a-form-item
                    label="Сборка"
            >
              <select-single
                      v-model="slide.selection"
                      :data="selections"
                      placeholder="Выберите сборку"
              />
            </a-form-item> -->
            <!-- <a-form-item
              label="Сборка"
            >
              <a-select
                v-model="slide.selection.name"
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
                v-model="slide.title"
                placeholder="Тайтл"
              />
            </a-form-item>
            <a-form-item
              label="Мета описание"
              :validate-status="errors.description ? 'error' : ''"
              help="Чтобы указать наименование города или категории укажите переменные city или category соответственно"
            >
              <a-input
                v-model="slide.description"
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
                v-model="slide.text"
                toolbar="bold italic | alignleft aligncenter alignright | bullist numlist | link image media | insertdatetime | code codesample"
              />
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <div slot="tabBarExtraContent">
          <a-button
            v-if="slide.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить
          </a-button>
          <a-button
            :disabled="loading"
            @click="slide.id ? update() : create()"
          >
            Сохранить
          </a-button>
        </div>
      </a-tabs>
    </a-layout-content>
  </a-layout>
</template>
<script>
    let str = window.location.pathname
    let res = str.split("/")

    export default {
        data() {
            return {
                // selections: [],
                cities: [],
                categories: [],
                slide: {
                    image: {},
                    // selection: {},
                    city: {},
                    category: {}
                },
                errors: {},
                loading: false,
                alert: false
            };
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
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
              if (Object.keys(this.slide.category).length > 0 && this.categories.length > 0) {
                let tags = this.categories.find(category => category.id == this.slide.category.id).tags
                return tags
              } else {
                return []
              }
            }
        },
        methods: {
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/slide/${res[3]}`)
                        .then(response => {
                            this.slide = response.data
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
                    axios.put(`/api/backend/slide/${res[3]}`, this.slide)
                        .then(response => {
                            this.errors = {}
                            this.slide = response.data
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
                    axios.post(`/api/backend/slide`, this.slide)
                        .then(response => {
                            this.errors = {}
                            this.slideLabel = response.data
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/slide/${response.data.id}/edit`
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
                                axios.delete(`/api/backend/slide/${res[3]}`)
                                    .then(response => {
                                        location.replace(`/admin/slide`)
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
            //     this.slide.selection = this.selections.filter((item) => {
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
