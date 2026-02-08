<template>
  <a-layout class="formCompany" :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff' }">
      <b-alert
        :show="alert"
        variant="danger"
        dismissible
      >
        <template v-for="error in errors">
          <template v-for="message in error">
            {{ message }}<br>
          </template>
        </template>
      </b-alert>
      <div style="background: rgba(255,0,255, .1);padding: 5px 10px;border-radius: 5px;margin-bottom: 10px;" v-if="company.message">Компания отклонена модератором по причине: {{company.message}}</div>
      <a-tabs
        v-model="activeKey"
        :class="!company.id ? 'dis':''"
      >
        <a-tab-pane
          key="1"

        >
            <span class="tabStep" slot="tab">
              <span class="tabCount">1</span><span class="tabName">Основная информация</span>
            </span>

          <a-form layout="vertical">
            <br>
            <a-form-item
              label="Название компании"
              :validate-status="errors.name ? 'error' : ''"
            >
              <a-input
                v-model="company.name"
                placeholder="Ресторан Якитория"
              />
            </a-form-item>

            <a-form-item
              label="Краткое описание компании"
              :validate-status="errors.summary ? 'error' : ''"
            >
              <a-textarea
                id="summary"
                v-model="company.summary"
                maxlength="120"
              />
              <span :style="`float:right;${company.summary.length == 120 ? 'color: #1890ff;' : ''}`">{{company.summary.length}}/120</span>
            </a-form-item>

            <a-form-item
              label="Полное описание компании"
              :validate-status="errors.about ? 'error' : ''"
            >
              <a-textarea
                id="about"
                v-model="company.about"
                maxlength="1200"
                class="about"
              />
              <span :style="`float:right;${company.about.length == 1200 ? 'color: #1890ff;' : ''}`">{{company.about.length}}/1200</span>
            </a-form-item>

            <a-form-item
              label="Категория компании"
              :validate-status="errors.categories ? 'error' : ''"
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
          key="3"
        >
            <template v-if="tabone">
                <span class="tabStep" slot="tab">
                    <span class="tabCount">2</span><span class="tabName">Галерея</span>
                </span>
            </template>
          <a-form layout="vertical">
            <br>

            <a-form-item
              label="Превью"
              :validate-status="errors.image ? 'error' : ''"
              help="Именно это фото, по вашей компании, пользователь видит самым первым"
            >
              <image-upload
                v-model="company.image"
                :width="285"
                :height="350"
              />
            </a-form-item>

            <a-form-item
              label="Фон"
              :validate-status="errors.background ? 'error' : ''"
              help="Данное фото будет являться самым запоминающимся"
            >
              <image-upload
                v-model="company.background"
                :width="1440"
                :height="750"
              />
            </a-form-item>

            <a-form-item
              label="Медиагалерея"
              help="Качественные фотографии помогут привлечь заинтересованных пользователей"
            >
              <gallery-index v-model="company.gallery_items" />
            </a-form-item>
          </a-form>

        </a-tab-pane>
        <a-tab-pane
          key="5"
        >
        <template v-if="tabtwo">
            <span class="tabStep" slot="tab">
                <span class="tabCount">3</span><span class="tabName">Адреса</span>
            </span>
        </template>
          <a-form>
            <company-addresses-index v-model="company.addresses" style="margin-bottom: 20px;" />
          </a-form>

        </a-tab-pane>
        <div slot="tabBarExtraContent">
        </div>
      </a-tabs>
        <div class="form-bottom-buttons d-flex justify-content-between">
            <div class="form-bottom-buttons-prev-next">
                <a-button v-show="activeKey!=='1'" @click=" prev() ">Назад</a-button>
                <a-button v-show="activeKey!=='5'" :disabled="activeKey=='1' && !tabone || activeKey=='3' && !tabtwo" @click=" next() ">Далее
                </a-button>
            </div>

            <div>
                <a-button
                    type="primary"
                    v-show="activeKey=='5' && !company.id"
                    :disabled="loading || !tabthree"
                    @click="create()"
                >
                    Добавить компанию
                </a-button>
                <a-button
                    v-if="company.id"
                    type="danger"
                    :disabled="loading"
                    @click="destroy"
                >
                    Удалить компанию
                </a-button>

                <a-button
                    v-if="company.id"
                    :disabled="disableButtonValue"
                    @click="update()"
                >
                    Сохранить
                </a-button>
            </div>
        </div>
    </a-layout-content>
    <a-modal
      v-model="companyCreatedModal"
      :closable="false"
      :width="540"
      :centered="true"
      :bodyStyle="{padding: '36px'}"
      :footer="null"
    >
      <img src="/icon/safari-pinned-tab.svg" width="110" height="70" style="margin: auto;display: block;">
      <p>Спасибо за размещение вашей компании на нашем сайте. После проверки всей необходимой информации модератором, ваша компания будет сразу опубликована.</p>
      <a-button style="padding: 14px 74px;display: block;margin: auto;min-height: 55px;" key="submit" type="primary" :loading="loading" @click="redirect">
        Хорошо
      </a-button>
    </a-modal>
  </a-layout>
</template>
<script>
    import SelectCompanyCategories from "../SelectCompanyCategories";
    let str = window.location.pathname
    let res = str.split("/")



    export default {
        components: {SelectCompanyCategories},
        data() {
            return {
                activeKey: "1",
                company: {
                    id:null,
                    tags: [],
                    name:'',
                    summary:'',
                    about:'',
                    gallery_items: [],
                    category: {},
                    published: false,
                    rejected: false,
                    active: true,
                    image:null,
                    background:null,
                    addresses:[],
                    clock:{}
                },
                categories: [],
                errors: {},
                loading: false,
                alert: false,
                companyCreatedModal: false,
                beforeunload: window.onbeforeunload,
                copyItem: {},
                isItemEdited: false,
            };
        },

        computed: {
            disableButtonValue: function() {
                if (JSON.stringify(this.copyItem) == JSON.stringify(this.company)) {
                    return true
                } else {
                    return this.loading
                }
            },
            tabone: function(){
                if (this.company.name.length > 0 &&
                    this.company.summary.length > 0 &&
                    this.company.about.length > 0 &&
                    Object.keys(this.company.category).length > 0 &&
                    this.company.tags.length > 0) {
                    return true
                } else {
                    return false
                }
            },
            tabtwo: function(){
                if ( this.company.image &&
                    this.company.background) {
                    return true
                } else {
                    return false
                }
            },
            tabthree: function(){
                if ( this.company.addresses.length) {
                    return true
                } else {
                    return false
                }
            },
            // tags: function () {
            //     return this.company.categories.length > 1 ? this.company.categories[0].tags.concat(this.company.categories[1].tags) : this.company.categories[0].tags
            // }
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            }
        },
        created () {

          window.onbeforeunload = function (evt) {
            var message = "Вы уверены, что хотите покинуть эту страницу?"
            if (typeof evt == "undefined") {
              evt = window.event
            }
            if (evt) {
              evt.returnValue = message
            }
            return message
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
            next() {
              if (this.activeKey == "1") {
                this.activeKey = "3"
              } else if (this.activeKey == "3") {
                this.activeKey = "5"
              }
            },
            prev() {
              if (this.activeKey == "3") {
                this.activeKey = "1"
              } else if (this.activeKey == "5") {
                this.activeKey = "3"
              }
            },
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/cabinet/company/${res[3]}`)
                        .then(response => {
                            this.company = response.data
                            this.copyItem = JSON.parse(JSON.stringify(this.company))
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
                    this.beforeunload = null
                    this.loading = true
                    const message = this.$message.loading('Сохранение', 0)

                    this.checkForModeration()
                    axios.put(`/api/cabinet/company/${this.company.slug}`, this.company)
                        .then(response => {
                            this.errors = {}
                            this.company = response.data
                            this.$message.success('Успешно сохранено!')
                            this.copyItem = JSON.parse(JSON.stringify(this.company))
                            if (this.isItemEdited) {
                                this.showModal()
                            }
                        })
                        .catch(error => {
                          // console.log('error', error)
                            this.$message.error('Ошибка')
                            this.errors = error.response.data.errors
                            this.beforeunload = window.onbeforeunload
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
                    this.beforeunload = null
                    const message = this.$message.loading('Сохранение', 0)

                    axios.post(`/api/cabinet/company`, this.company)
                        .then(response => {

                            this.showModal()
                            this.errors = {}
                            this.company = response.data
                            this.$message.success('Успешно сохранено!')
                        })
                        .catch(error => {
                            this.$message.error('Ошибка')
                            this.errors = error.response.data.errors
                            this.beforeunload = window.onbeforeunload
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
                        buttons: ["Нет", "Да"],
                        dangerMode: true,
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                axios.delete(`/api/cabinet/company/${this.company.slug}`)
                                    .then(response => {
                                        location.replace(`/cabinet/company`)
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
            redirect() {
                window.onbeforeunload = null
                location.href = `/cabinet/company`
            },
            showModal() {
                this.companyCreatedModal = true
            },
            checkForModeration() {
                this.isItemEdited = false
                let copy = JSON.parse(JSON.stringify(this.company))
                if (JSON.stringify(this.copyItem) !== JSON.stringify(copy)) {
                    // this.company.active = false
                    this.company.published = false
                    this.isItemEdited = true
                }
            },
            fetchCategories() {
                this.loading = true
                const message = this.$message.loading('Загрузка данных', 0)
                axios.get(`/api/cabinet/category/all`)
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
.tag {
    padding: 0 5px 3px 5px;
    margin-bottom: 10px;
    display: inline-block;
    min-width: 50px;
    border: 3px solid #096dd9;
    border-radius: 10px;
    background:#096dd9;
    // text-transform: lowercase;
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

  @media(max-width: 500px) {
    .form-bottom-buttons {
        display: block !important;
    }
    .form-bottom-buttons-prev-next {
        margin-bottom: 10px;
    }
  }
</style>
