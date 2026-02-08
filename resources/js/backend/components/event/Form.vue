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
              label="Компания"
              :validate-status="errors['company.id'] || event.changes_flags.is_changed_company_id ? (!errors['company.id'] ? 'warning' : 'error') : ''"
            >
              <input-autocomplete
                v-model="event.company"
                :url="'/api/backend/company/search/'"
                @input="delete errors['company.id']"
              />
            </a-form-item>

            <a-form-item
              label="Название"
              :validate-status="errors.name || event.changes_flags.is_changed_name ? (!errors.name ? 'warning' : 'error') : ''"
            >
              <a-input
                v-model="event.name"
                placeholder="Скидки на роллы в Якитории"
                @input="delete errors['name']"
              />
            </a-form-item>

            <a-form-item
              label="Краткое описание"
              :validate-status="errors.summary || event.changes_flags.is_changed_summary ? (!errors.summary ? 'warning' : 'error') : ''"
            >
              <a-textarea
                id="summary"
                v-model="event.summary"
                @input="delete errors['summary']"
                maxlength="120"
              />
            </a-form-item>

            <a-form-item
              label="Полное описание"
              :validate-status="errors.about || event.changes_flags.is_changed_about ? (!errors.about ? 'warning' : 'error') : ''"

            >
              <a-textarea
                id="about"
                v-model="event.about"
                :rows="10"
                @input="delete errors['about']"
                maxlength="1200"
              />
            </a-form-item>

            <a-form-item
              label="Дата проведения акции"
              :validate-status="errors.start ? 'error' : ''"
            >
              <a-checkbox :checked="noage == true" @change="noage=!noage, event.end = null">Бессрочная акция</a-checkbox>
              <a-range-picker format="DD-MM-YYYY" v-if="noage == false"  v-model="range"/>
              <a-date-picker format="DD-MM-YYYY" v-if="noage == true" v-model="rangenot"/>

            </a-form-item>

            <!-- <a-form-item
              label="Категория"
              :validate-status="errors.categories || event.changes_flags.is_changed_categories ? (!errors.categories ? 'warning' : 'error') : ''"
              help="Доступно к выбору 1 категория"
            >
              <select-event-categories v-model="event" @input="delete errors['categories']"/>
            </a-form-item> -->
            <a-form-item
                label="Теги"
                :validate-status="errors.tags ? 'error' : ''"
                v-if="event.company && event.company.tags && event.company.tags.length > 0"
            >
                <div id="tags">
                    <span class="tag" v-for="(tag, index) in event.company.tags" :class="event.tags.length > 0 && event.tags.find(ct => ct.name == tag.name) !== undefined ? 'active' : ''" v-on:click="toggleTag(tag)">{{tag.name}}</span>
                </div>
            </a-form-item>
            <a-form-item
              label="Лейблы"
            >
              <select-event-labels v-model="event.labels" />
            </a-form-item>

            <a-form-item
              label="Выбор редакции"
            >
              <a-switch
                v-model="event.favorite"
              />
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
              :validate-status="errors.slug ? 'error' : ''"
            >
              <a-input
                v-model="event.slug"
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
              :validate-status="errors['image.id'] || event.changes_flags.is_changed_image_download_id ? (!errors['image.id'] ? 'warning' : 'error') : ''"
            >
              <image-upload
                v-model="event.image"
                :width="285"
                :height="200"
                @input="delete errors['image.id']"
              />
            </a-form-item>

            <a-form-item
              label="Фон"
              :validate-status="errors['background.id'] || event.changes_flags.is_changed_background_download_id ? (!errors['background.id'] ? 'warning' : 'error') : ''"
            >
              <image-upload
                v-model="event.background"
                :width="1440"
                :height="750"
                @input="delete errors['background.id']"
              />
            </a-form-item>

            <a-form-item
              label="Медиагалерея"
              :validate-status="errors.gallery_items || event.changes_flags.is_changed_gallery_items ? (!errors.gallery_items ? 'warning' : 'error') : ''"
            >
              <gallery-index v-model="event.gallery_items" :changes="event.changes_log" @input="delete errors['gallery_items']"/>
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
                :checked="event.published"
                @change="publishOrReject(true)"
              />
            </a-form-item>

            <a-form-item
              label="Активен"
            >
              <a-switch
                v-model="event.active"
              />
            </a-form-item>

            <a-form-item
              label="Отклонен"
            >
              <a-switch
                :checked="event.rejected"
                @change="publishOrReject(false)"
              />
            </a-form-item>

            <a-form-item
              v-if="event.rejected"
              label="Причина отклонения"
              :validate-status="errors.message ? 'error' : ''"
            >
              <a-textarea
                v-model="event.message"
                placeholder="Опишите причину"
              />
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <a-tab-pane
          key="5"
          tab="Адреса проведения"
        >
          <a-form layout="vertical">
            <br>
            <event-addresses-index
              v-model="event.addresses"
              :all="event.company.addresses"
            />
          </a-form>
        </a-tab-pane>
        <a-tab-pane
          key="6"
          tab="Лог изменений"
        >
          <a-list item-layout="vertical" :data-source="event.changes_log" :pagination="pagination">
            <a-list-item slot="renderItem" slot-scope="item, index">
              <template>
                <a-list-item-meta>
                  <a slot="title" href="#">{{ item.updated_at }}</a>
                  <div slot="description" v-for="(changed, i) in item.changed_data" v-if="i !== 'updated_at'">
                    Изменено: <strong>{{data_titles[i]}}</strong>
                    <br> 
                    <strong>C:</strong>
                    <template v-if="item.original_data[i] == 1 || item.original_data[i] == true">
                      Да
                    </template>
                    <template v-else-if="item.original_data[i] == false || item.original_data[i] == 0">
                      Нет
                    </template>
                    <template v-else-if="item.original_data[i] == null">
                      Бессрочная
                    </template>
                    <template v-else>
                      {{item.original_data[i]}}
                    </template>
                    <br> 
                    <strong>На:</strong>
                    <template v-if="changed == 1 || changed == true">
                      Да
                    </template>
                    <template v-else-if="changed == false || changed == 0">
                      Нет
                    </template>
                    <template v-else-if="changed == null">
                      Бессрочная
                    </template>
                    <template v-else>
                      {{changed}}
                    </template>
                  </div>
                </a-list-item-meta>
                <!-- <hr> -->
              </template>
            </a-list-item>
          </a-list>
        </a-tab-pane>
        <div slot="tabBarExtraContent">
          <a-button
            v-if="event.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить
          </a-button>
          <a-button
            :disabled="loading"
            @click="event.id ? update() : create()"
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
    let data_titles = {
      'company_id': 'Компания акции',
      'name': 'Название акции',
      'summary': 'Краткое описание акции',
      'about': 'Полное описание акции',
      'categories': 'Категория акции',
      'slug': 'slug',
      'background_download_id': 'Фон',
      'image_download_id': 'Превью',
      'gallery_items': 'Галлерея',
      'start': 'Начало проведения',
      'updated_at': 'Обновлено',
      'active': 'Активна',
      'published': 'Опубликована',
      'end': 'Конец проведения'
    }
    export default {
        data() {
            return {
              pagination: {
                onChange: page => {
                  // console.log(page);
                },
                pageSize: 10,
              },
              data_titles,
                noage:false,
                event: {
                  tags: [],
                    gallery_items: [],
                    company: {
                        slug: undefined,
                        addresses: []
                    },
                    addresses: [],
                    // categories: [],
                    labels: [],
                    favorite: false,
                    published: true,
                    rejected: false,
                    active: true,
                    start:moment().format('YYYY-MM-DD HH:mm:ss'),
                    // end: null,
                    changes_log: {
                      changed_data: {},
                      original_data: {},
                    },
                    changes_flags: {}
                },
                errors: {},
                loading: false,
                alert: false
            };
        },
        computed: {
            // tags: function () {
            //    return this.event.categories.length > 1 ? this.event.categories[0].tags.concat(this.event.categories[1].tags) : this.event.categories[0].tags
            // },
            range: {
                get: function () {
                    return [
                        this.event.start ? moment.utc(this.event.start) : moment.utc(),
                        this.event.end ? moment.utc(this.event.end) : moment.utc()
                    ]
                },
                set: function (value) {
                    this.event.start = value[0].format('YYYY-MM-DD HH:mm:ss')
                    this.event.end = value[1].format('YYYY-MM-DD HH:mm:ss')
                    delete this.errors['start']
                }
            },
            rangenot: {
              get: function () {
                return moment.utc(this.event.start)
              },
              set: function (value) {
                this.event.start = value.format('YYYY-MM-DD HH:mm:ss')
                this.event.end = null
                delete this.errors['start']

              }

            },
        },
        watch: {
            errors: {
              handler(newValue, oldValue) {
                console.log(Object.keys(newValue).length)
                this.alert = Object.keys(newValue).length > 0
              },
              deep: true
            },
            'event.company.slug': function (val, old) {
                if (val !== old) {
                    this.fetchCompany()
                }
                if (old !== undefined) {
                    this.event.addresses = []
                }
            }
        },
        mounted() {
            if (res[4] === 'edit') {
                this.fetch()
            }
        },
        methods: {
            toggleTag(tag) {
              if (this.event.tags.length > 0) {
                const index = this.event.tags.findIndex(ct => {
                  return ct.name === tag.name;
                });

                if (index !== -1) {
                  this.event.tags.splice(index, 1)
                } else {
                  this.event.tags.push(tag)
                }
              } else {
                this.event.tags.push(tag)
              }
            },
            publishOrReject(value) {
                if (value) {
                  this.event.published = true
                  this.event.rejected = false
                  this.event.message = ''
                } else {
                  this.event.published = false
                  this.event.rejected = true
                }
            },
            onChangerejected(checked){
                if (checked == true) {
                    this.event.published=false;
                    this.event.active=false
                }
            },
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/event/${res[3]}`)
                        .then(response => {
                            this.event = response.data
                            this.event.end == null ? this.noage = true : this.noage = false
                            if (this.event.changes_flags == null) {
                              this.event.changes_flags = {}
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
                    this.loading = true
                    const message = this.$message.loading('Сохранение', 0)
                    axios.put(`/api/backend/event/${res[3]}`, this.event)
                        .then(response => {
                            this.errors = {}
                            this.event = response.data
                            if (this.event.changes_flags == null) {
                              this.event.changes_flags = {}
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
                    this.loading = true
                    const message = this.$message.loading('Сохранение', 0)
                    axios.post(`/api/backend/event`, this.event)
                        .then(response => {
                            this.errors = {}
                            this.event = response.data
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/event/${response.data.slug}/edit`
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
                                axios.delete(`/api/backend/event/${this.event.slug}`)
                                    .then(response => {
                                        location.replace(`/admin/event`)
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
            fetchCompany() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/company/${this.event.company.slug}`)
                        .then(response => {
                            this.event.company = response.data
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
        }
    };
</script>

<style lang="scss">
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