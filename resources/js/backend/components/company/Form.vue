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
              label="Название компании"
              :validate-status="errors.name || company.changes_flags.is_changed_name ? (!errors.name ? 'warning' : 'error') : ''"
            >
              <a-input
                v-model="company.name"
                placeholder="Ресторан Якитория"
                @input="delete errors['name']"
              />
            </a-form-item>

            <!-- <a-form-item
              label="Сайт"
              :validate-status="errors.url ? 'error' : ''"
              :help="errors.url ? errors.url[0] : ''"
            >
              <a-input
                v-model="company.url"
                placeholder="https://example.com"
              />
            </a-form-item> -->

            <a-form-item
              label="Краткое описание компании"
              :validate-status="errors.summary || company.changes_flags.is_changed_summary ? (!errors.summary ? 'warning' : 'error') : ''"
            >
              <a-textarea
                id="summary"
                v-model="company.summary"
                @input="delete errors['summary']"
                maxlength="120"
              />
            </a-form-item>

            <a-form-item
              label="Полное описание компании"
              :validate-status="errors.about || company.changes_flags.is_changed_about ? (!errors.about ? 'warning' : 'error') : ''"
            >
              <a-textarea
                id="about"
                v-model="company.about"
                @input="delete errors['about']"
                maxlength="1200"
              />
            </a-form-item>

            <a-form-item
              label="Категории компании"
              :validate-status="errors.category || company.changes_flags.is_changed_categories ? (!errors.category ? 'warning' : 'error') : ''"
            >
              <select-single
                      v-model="company.category"
                      :data="categories"
                      placeholder="Выберите категорию"
              />
            </a-form-item>
            <a-form-item
                label="Теги"
                :validate-status="errors.tags ? 'error' : ''"
                v-if="company.category && Object.keys(company.category).length > 0"
                help="3 тега максимум"
            >
                <div id="tags">
                    <span class="tag" v-for="(tag, index) in categories.find(cat=> company.category.id == cat.id) !== undefined ? categories.find(cat=> company.category.id == cat.id).tags : []" :class="company.tags.length > 0 && company.tags.find(ct => ct.name == tag.name) !== undefined ? 'active' : ''" v-on:click="toggleTag(tag)">{{tag.name}}</span>
                </div>
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <a-tab-pane
          key="2"
          tab="SEO"
        >
          <a-form layout="vertical">
            <br>
            <a-form-item
              label="Slug"
              :validate-status="errors.slug || company.changes_flags.is_changed_slug ? (!errors.slug ? 'warning' : 'error') : ''"
            >
              <a-input
                v-model="company.slug"
                placeholder="Необязательно"
                @input="delete errors['slug']"
              />
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <a-tab-pane
          key="3"
          tab="Галерея"
        >
          <a-form layout="vertical">
            <br>

            <a-form-item
              label="Превью"
              :validate-status="errors['image.id'] || company.changes_flags.is_changed_image_download_id ? (!errors['image.id'] ? 'warning' : 'error') : ''"
              help="Именно это фото, по вашей компании, пользователь видит самым первым"
            >
              <image-upload
                v-model="company.image"
                :width="285"
                :height="350"
                @input="delete errors['image.id']"
              />
            </a-form-item>

            <a-form-item
              label="Фон"
              :validate-status="errors['background.id'] || company.changes_flags.is_changed_background_download_id ? (!errors['background.id'] ? 'warning' : 'error') : ''"
              help="Данное фото будет являться самым запоминающимся"
            >
              <image-upload
                v-model="company.background"
                :width="1440"
                :height="750"
                @input="delete errors['background.id']"
              />
            </a-form-item>

            <a-form-item
              label="Медиагалерея"
              :validate-status="errors.gallery_items || company.changes_flags.is_changed_gallery_items ? (!errors.gallery_items ? 'warning' : 'error') : ''"
              help="Качественные фотографии помогут привлечь заинтересованных пользователей"
            >
              <gallery-index v-model="company.gallery_items" :changes="company.changes_log" @input="delete errors['gallery_items']"/>
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <a-tab-pane
          key="4"
          tab="Статус"
        >
          <a-form layout="vertical">
            <br>

            <a-form-item
              label="Опубликован"
            >
              <a-switch
                :checked="company.published"
                @change="publishOrReject(true)"
              />
            </a-form-item>

            <a-form-item
              label="Активен"
            >
              <a-switch
                v-model="company.active"
              />
            </a-form-item>

            <a-form-item
              label="Отклонен"
            >
              <a-switch
                :checked="company.rejected"
                @change="publishOrReject(false)"
              />
            </a-form-item>

            <a-form-item
              v-if="company.rejected"
              label="Причина отклонения"
              :validate-status="errors.message ? 'error' : ''"
            >
              <a-textarea
                v-model="company.message"
                placeholder="Опишите причину"
              />
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <a-tab-pane
          key="5"
          tab="Адреса"
        >
          <a-form>
            <company-addresses-index v-model="company.addresses" :errors="errors ? errors : {}"/>
          </a-form>
        </a-tab-pane>
        <a-tab-pane
          key="6"
          tab="E-mail для верификации"
        >
          <a-form>
            <a-form-item
              label="Введите e-mail"
              :validate-status="errors.verification_email ? 'error' : ''"
            >
              <a-input
                v-model="company.verification_email"
                placeholder="My@company.ru"
              />
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <a-tab-pane
          key="7"
          tab="Лог изменений"
        >
          <a-list item-layout="vertical" :data-source="company.changes_log" :pagination="pagination">
            <a-list-item slot="renderItem" slot-scope="item, index">
              <template>
                <a-list-item-meta>
                  <a slot="title" href="#">{{ item.updated_at }}</a>
                  <div slot="description" v-for="(changed, i) in item.changed_data" v-if="i !== 'updated_at'">
                    Изменено: <strong>{{data_titles[i]}}</strong><br> <strong>C:</strong> {{item.original_data[i]}}<br> <strong>На:</strong> {{changed}}
                  </div>
                </a-list-item-meta>
                <!-- <hr> -->
              </template>
            </a-list-item>
          </a-list>
        </a-tab-pane>
        <div slot="tabBarExtraContent">
          <a-button
            v-if="company.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить компанию
          </a-button>
          <a-button
            :disabled="loading"
            @click="company.id ? update() : create()"
          >
            {{ company.id ? 'Сохранить' : 'Добавить компанию' }}
          </a-button>
        </div>
      </a-tabs>
    </a-layout-content>
  </a-layout>
</template>
<script>
    import SelectCompanyCategories from "../SelectCompanyCategories";
    let str = window.location.pathname
    let res = str.split("/")
    let data_titles = {
      name: 'Название компании',
      summary: 'Краткое описание компании',
      about: 'Полное описание компании',
      categories: 'Категория компании',
      slug: 'slug',
      background_download_id: 'Фон',
      image_download_id: 'Превью',
      gallery_items: 'Галлерея'
    }
    export default {
        components: {SelectCompanyCategories},
        data() {
            return {
              pagination: {
                onChange: page => {
                  console.log(page);
                },
                pageSize: 10,
              },
              data_titles,
                activeKey: "1",
                company: {
                    tags: [],
                    addresses: [],
                    gallery_items: [],
                    category: {},
                    published: true,
                    rejected: false,
                    active: true,
                    clock:{},
                    verification_email: '',
                    changes_log: [{
                      changed_data: {},
                      original_data: {},
                    }],
                    changes_flags: {}
                },
                categories: [],
                errors: {},
                loading: false,
                alert: false
            };
        },
        computed: {
          // tags: function () {
          //    return this.company.categories.length > 1 ? this.company.categories[0].tags.concat(this.company.categories[1].tags) : this.company.categories[0].tags
          // }
        },
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
            this.fetchCategories()
        },
        methods: {
            toggleTag(tag) {
              if (this.company.tags.length > 0) {
                const index = this.company.tags.findIndex(ct => {
                  return ct.name === tag.name;
                });

                if (index !== -1) {
                  this.company.tags.splice(index, 1)
                } else {
                  if (this.company.tags.length < 3) {
                    this.company.tags.push(tag)
                  }
                }
              } else {
                if (this.company.tags.length < 3) {
                  this.company.tags.push(tag)
                }
              }
            },
            publishOrReject(value) {
                if (value) {
                  this.company.published = true
                  this.company.rejected = false
                  this.company.message = ''
                } else {
                  this.company.published = false
                  this.company.rejected = true
                }
            },
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/company/${res[3]}`)
                        .then(response => {
                            this.company = response.data
                            if (this.company.changes_flags == null) {
                              this.company.changes_flags = {}
                            }
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
                    axios.put(`/api/backend/company/${res[3]}`, this.company)
                        .then(response => {
                            this.errors = {}
                            this.company = response.data
                            if (this.company.changes_flags == null) {
                              this.company.changes_flags = {}
                            }
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
                    axios.post(`/api/backend/company`, this.company)
                        .then(response => {
                            this.errors = {}
                            this.company = response.data
                            this.$message.success('Успешно сохранено!')
                            // location.href = `/admin/company/${response.data.slug}/edit`
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
                                axios.delete(`/api/backend/company/${this.company.slug}`)
                                    .then(response => {
                                        location.replace(`/admin/company`)
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

<style scoped lang="scss">
  .has-warning .ant-form-explain {
    color: rgba(0, 0, 0, 0.45);
  }
  .has-warning .ant-upload.ant-upload-select-picture-card,
  .has-warning .changed {
    border: 2px solid #faad14;
  }
  .tag {
    padding: 0 5px 3px 5px;
    margin-bottom: 10px;
    display: inline-block;
    min-width: 50px;
    border: 3px solid #096dd9;
    border-radius: 10px;
    background:#096dd9;
    text-transform: lowercase;
    text-align: center;
    color: #fff;
    margin-right: 5px;
    cursor: pointer;
    opacity: .4;
    // &:after {
    //   content: "\f00d";
    //   padding-left: 3px;
    //   display: inline-block;
    //   font: normal normal normal 14px/1 FontAwesome;
    //   font-size: inherit;
    //   text-rendering: auto;
    //   -webkit-font-smoothing: antialiased;
    //   -moz-osx-font-smoothing: grayscale;

    // }
  }
  .active {
    opacity: 1;
  }
</style>
