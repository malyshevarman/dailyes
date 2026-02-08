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
      <a-tabs
        v-model="activeKey"
      >
        <a-tab-pane
          key="1"
          tab="Основная информация"
        >
          <a-form layout="vertical">
            <br>
            <a-form-item
                    label="Город"
            >
              <select-single
                      v-model="newsletter.data.city"
                      :data="cities"
                      placeholder="Выберите город"
              />
            </a-form-item>
            <!-- <a-form-item
                    label="Категория"
            >
              <select-single
                      v-model="newsletter.data.category"
                      :data="categories"
                      placeholder="Выберите категорию"
              />
            </a-form-item> -->
            <!-- <template v-if="Object.keys(newsletter.data.category).length === 0"> -->
              <a-form-item
                v-if="newsletter.data.companies.length === 0"
                label="Акции"
              >
                <select-search
                  v-model="newsletter.data.events"
                  :url="'/api/backend/event/search/'"
                />
              </a-form-item>

              <a-form-item
                v-if="newsletter.data.events.length === 0"
                label="Компании"
              >
                <select-search
                  v-model="newsletter.data.companies"
                  :url="'/api/backend/company/search/'"
                />
              </a-form-item>
            <!-- </template> -->
            <a-form-item
              label="Тема письма"
              :validate-status="errors.subject ? 'error' : ''"
            >
              <a-input
                v-model="newsletter.subject"
                placeholder=""
                @input="delete errors['subject']"
              />
            </a-form-item>
            <a-form-item
              label="Текст"
              :validate-status="errors.text ? 'error' : ''"
            >
              <vue-tinymce
                id="content"
                v-model="newsletter.text"
                toolbar="bold italic | alignleft aligncenter alignright | bullist numlist | link image media | insertdatetime | code codesample"
                block_formats="Paragraph=p; Header 1=h1"
              />
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <div slot="tabBarExtraContent">
          <a-button
            v-if="newsletter.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить рассылку
          </a-button>
          <a-button
            :disabled="loading"
            @click="newsletter.id ? update() : create()"
          >
            {{ newsletter.id ? 'Сохранить' : 'Добавить рассылку' }}
          </a-button>
        </div>
      </a-tabs>
    </a-layout-content>
  </a-layout>
</template>
<script>
    // import SelectCompanyCategories from "../SelectCompanyCategories";
    let str = window.location.pathname
    let res = str.split("/")
    // let data_titles = {
    //   name: 'Название компании',
    //   summary: 'Краткое описание компании',
    //   about: 'Полное описание компании',
    //   categories: 'Категория компании',
    //   slug: 'slug',
    //   background_download_id: 'Фон',
    //   image_download_id: 'Превью',
    //   gallery_items: 'Галлерея'
    // }
    export default {
        // components: {SelectCompanyCategories},
        data() {
            return {
              pagination: {
                onChange: page => {
                  console.log(page);
                },
                pageSize: 10,
              },
              cities: [],
              // categories: [],
              // data_titles,
              activeKey: "1",
              newsletter: {
                  subject: '',
                  text: '',
                  data: {
                    companies: [],
                    events: [],
                    // category: {},
                    city: {},

                  }
              },
              errors: {},
              loading: false,
              alert: false
            };
        },
        computed: {},
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            }
        },
        created () {

          window.onbeforeunload = function (evt) {
            var message = "Вы уверены, что хотите покинуть эту страницу?";
            if (typeof evt == "undefined") {
              evt = window.event;
            }
            if (evt) {
              evt.returnValue = message;
            }
            return message;
          }

        },
        mounted() {
            if (res[4] === 'edit') {
                this.fetch()
            }
            this.fetchCities()
            // this.fetchCategories()
        },
        methods: {
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/newsletter/${res[3]}`)
                        .then(response => {
                            this.newsletter = response.data
                            this.newsletter.data.events = this.newsletter.events
                            this.newsletter.data.companies = this.newsletter.companies
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
                    window.onbeforeunload = null
                    this.loading = true
                    const message = this.$message.loading('Сохранение', 0)
                    axios.put(`/api/backend/newsletter/${res[3]}`, this.newsletter)
                        .then(response => {
                            this.errors = {}
                            this.newsletter = response.data
                            this.newsletter.data.events = this.newsletter.events
                            this.newsletter.data.companies = this.newsletter.companies
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
                    window.onbeforeunload = null
                    this.loading = true
                    const message = this.$message.loading('Сохранение', 0)
                    axios.post(`/api/backend/newsletter`, this.newsletter)
                        .then(response => {
                            this.errors = {}
                            this.newsletter = response.data
                            this.newsletter.data.events = this.newsletter.events
                            this.newsletter.data.companies = this.newsletter.companies
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/newsletter/${response.data.id}/edit`
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
                                axios.delete(`/api/backend/newsletter/${this.newsletter.id}`)
                                    .then(response => {
                                        location.replace(`/admin/newsletter`)
                                    })
                                    .catch(error => {
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
            // fetchCategories() {
            //     this.loading = true
            //     const message = this.$message.loading('Загрузка данных', 0)
            //     axios.get(`/api/backend/category/all`)
            //         .then(response => {
            //             this.categories = response.data
            //         })
            //         .catch(error => {
            //             this.$message.error('Ошибка')
            //         })
            //         .then(() => {
            //             setTimeout(message, 0)
            //             this.loading = false
            //         })
            // }
        }
    };
</script>

<style>
  .has-warning .ant-form-explain {
    color: rgba(0, 0, 0, 0.45);
  }
  .has-warning .ant-upload.ant-upload-select-picture-card,
  .has-warning .changed {
    border: 2px solid #faad14;
  }
</style>
