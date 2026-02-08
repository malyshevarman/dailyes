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
            <div style="background: rgba(255,0,255, .1);padding: 5px 10px;border-radius: 5px;margin-bottom: 10px;" v-if="event.message">Акция отклонена модератором по причине: {{event.message}}</div>
            <a-tabs
                v-model="activeKey"
                :class="!event.id ? 'dis':''"
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
                            v-if="!event.id"
                            label="Компания"
                            :validate-status="errors['company.id'] ? 'error' : ''"
                        >
                            <input-autocomplete
                                v-model="event.company"
                                :url="'/api/cabinet/company/search/'"
                            />
                        </a-form-item>

                        <a-form-item
                            label="Название акции"
                            :validate-status="errors.name ? 'error' : ''"
                        >
                            <a-input
                                v-model="event.name"
                                placeholder="Скидка 50% на роллы"
                            />
                        </a-form-item>

                        <a-form-item
                            label="Краткое описание акции"
                            :validate-status="errors.summary ? 'error' : ''"
                        >
                            <a-textarea
                                id="summary"
                                v-model="event.summary"
                                maxlength="120"
                            />
                            <span :style="`float:right;${event.summary.length == 120 ? 'color: #1890ff;' : ''}`">{{event.summary.length}}/120</span>
                        </a-form-item>

                        <a-form-item
                            label="Полное описание акции"
                            :validate-status="errors.about ? 'error' : ''"
                        >
                            <a-textarea
                                id="about"
                                v-model="event.about"
                                class="about"
                                maxlength="1200"
                            />
                            <span :style="`float:right;${event.about.length == 1200 ? 'color: #1890ff;' : ''}`">{{event.about.length}}/1200</span>
                        </a-form-item>

                        <a-form-item
                            label="Дата проведения акции"
                            :validate-status="errors.start ? 'error' : ''"
                        >
                            <a-checkbox :checked="noage == true" @change="noage=!noage, event.end = null">Бессрочная акция</a-checkbox>
                            <a-range-picker format="DD-MM-YYYY" v-if="noage == false" v-model="range"/>
                            <a-date-picker format="DD-MM-YYYY" v-if="noage == true" v-model="rangenot"/>

                        </a-form-item>


                        <!-- <a-form-item
                            label="Категория акции"
                            :validate-status="errors.categories ? 'error' : ''"
                            help="Доступно к выбору 1 категория"
                        >
                            <select-event-categories v-model="event"/>
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
                            help="Именно это фото, по вашей акции, пользователь видит самым первым"
                        >
                            <image-upload
                                v-model="event.image"
                                :width="285"
                                :height="200"
                            />

                        </a-form-item>

                        <a-form-item
                            label="Фон"
                            :validate-status="errors.background ? 'error' : ''"
                            help="Данное фото будет являться самым запоминающимся"
                        >
                            <image-upload
                                v-model="event.background"
                                :width="1440"
                                :height="750"
                            />
                        </a-form-item>

                        <a-form-item
                            label="Медиагалерея"
                            help="Качественные фотографии помогут привлечь заинтересованных пользователей"
                        >
                            <gallery-index v-model="event.gallery_items"/>
                        </a-form-item>
                    </a-form>
                </a-tab-pane>
                <a-tab-pane
                    key="4"
                >
                    <template v-if="tabtwo">
                        <span class="tabStep" slot="tab">
                            <span class="tabCount">3</span><span class="tabName">Адреса проведения</span>
                        </span>
                    </template>
                    <a-form layout="vertical">
                        <br>
                        <event-addresses-index
                            v-model="event.addresses"
                            :all="event.company.addresses"
                             style="margin-bottom: 20px;"
                        />
                    </a-form>
                </a-tab-pane>
                <a-tab-pane
                    key="5"
                    v-if="event.published"
                >
                    <template v-if="tabtwo">
                        <span class="tabStep" slot="tab">
                            <span class="tabCount">4</span><span class="tabName">Статус</span>
                        </span>
                    </template>
                    
                    <a-form layout="vertical">
                        <br>
                        <a-form-item
                            :label="event.active ? 'Активна' : 'Неактивна'"
                        >
                            <a-switch
                                v-model="event.active"
                            />
                            <span style="margin-left: 30px;">{{event.active ? 'Отключить' : 'Активировать'}}</span>
                            <br>
                            <span>Вы можете снять с публикации данную акцию сейчас и активировать ее при необходимости в любое время</span>
                        </a-form-item>
                    </a-form>
                </a-tab-pane>
                <div slot="tabBarExtraContent">
                </div>
            </a-tabs>
            <div class="form-bottom-buttons d-flex justify-content-between">
                <div class="form-bottom-buttons-prev-next">
                    <a-button v-show="activeKey!=='1'" @click=" prev() ">Назад</a-button>
                    <a-button v-show="activeKey=='1' || activeKey=='3' || activeKey=='4' && event.published" :disabled="activeKey=='1' && !tabone || activeKey=='3' && !tabtwo" @click=" next() ">Далее</a-button>
                </div>

                <div>
                    <a-button
                        type="primary"
                        v-show="activeKey=='4' && !event.id"
                        :disabled="loading || !tabthree"
                        @click="create()"
                    >
                        Добавить акцию
                    </a-button>


                    <a-button
                        v-if="event.id"
                        type="danger"
                        :disabled="loading"
                        @click="destroy"
                    >
                        Удалить акцию
                    </a-button>

                    <a-button
                        v-if="event.id"
                        :disabled="disableButtonValue"
                        @click="update()"
                    >
                        Сохранить
                    </a-button>
                </div>
            </div>
                <!-- <a-button
                  :disabled="loading"
                  @click="next"
                  v-if="!event.published && activeKey != '4' || event.published && activeKey != '5'"
                >
                  Далее
                </a-button> -->
        </a-layout-content>
        <a-modal
            v-model="eventCreatedModal"
            :closable="false"
            :width="540"
            :centered="true"
            :bodyStyle="{padding: '36px'}"
            :footer="null"
        >
            <img src="/icon/safari-pinned-tab.svg" width="110" height="70" style="margin: auto;display: block;">
            <p>
                Спасибо за размещение вашей акции на нашем сайте. После проверки всей необходимой информации
                модератором, ваша акция будет сразу опубликована.
            </p>
            <a-button style="padding: 14px 74px;display: block;margin: auto;min-height: 55px;" key="submit"
                      type="primary" :loading="loading" @click="redirect">
                Хорошо
            </a-button>
        </a-modal>
    </a-layout>
</template>
<script>
    import moment from 'moment';

    let str = window.location.pathname
    let res = str.split("/")

    export default {
        data() {
            return {
                noage: false,
                lengthcounter: 0,
                activeKey: "1",
                event: {
                    id:null,
                    tags: [],
                    name:'',
                    summary:'',
                    about:'',
                    category: {},
                    gallery_items: [],
                    start:moment().format('YYYY-MM-DD HH:mm:ss'),
                    company: {
                        id:null,
                        slug: undefined,
                        addresses: []
                    },
                    addresses: [],
                    labels: [],
                    favorite: false,
                    published: false,
                    rejected: false,
                    active: true,
                    image:null,
                    background:null,
                },
                copyItem: {},
                errors: {},
                loading: false,
                alert: false,
                eventCreatedModal: false,
                beforeunload: window.onbeforeunload,
                isItemEdited: false
            };
        },
        created() {

            window.onbeforeunload = (evt) => {
                var message = "Вы уверены, что хотите покинуть эту страницу?"
                if (!this.disableButtonValue) {
                    if (typeof evt == "undefined") {
                        evt = window.event
                    }
                    if (evt) {
                        evt.returnValue = message
                    }
                    return message
                }
            }

        },
        computed: {
            // tags: function () {
            //     return this.event.categories.length > 1 ? this.event.categories[0].tags.concat(this.event.categories[1].tags) : this.event.categories[0].tags
            // },
            disableButtonValue: function() {
                if (JSON.stringify(this.copyItem) == JSON.stringify(this.event)) {
                    return true
                } else {
                    return this.loading
                }
            },
            tabone: function(){
                if (this.event.company.id != null &&
                    this.event.name.length > 0 &&
                    this.event.summary.length > 0 &&
                    this.event.about.length > 0 &&
                    (this.event.end !== undefined || this.noage) &&
                    this.event.tags.length > 0) {
                    return true
                } else {
                    return false
                }
            },
            tabtwo: function(){
                if ( this.event.image &&
                    this.event.background) {
                    return true
                } else {
                    return false
                }
            },
            tabthree: function(){
                if ( this.event.addresses.length) {
                    return true
                } else {
                    return false
                }
            },
            // currentLength() {
            //     if (!this.event.about)
            //         return 0;

            //     return this.event.about.length
            // },
            rangenot: {
                get: function () {
                    return moment.utc(this.event.start)
                },
                set: function (value) {
                    this.event.start = value.format('YYYY-MM-DD HH:mm:ss')
                    this.event.end = null
                    console.log('start', this.event.start)
                    console.log('end', this.event.end)

                }

            },
            range: {
                get: function () {
                    return [
                        moment.utc(this.event.start),
                        moment.utc(this.event.end)
                    ]
                },
                set: function (value) {
                    this.event.start = value[0].format('YYYY-MM-DD HH:mm:ss');
                    this.event.end = value[1].format('YYYY-MM-DD HH:mm:ss');
                }
            }
        },
        watch: {
            noage: function () {
                this.noage==false ? (this.event.end = this.event.start) : ''
            },
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
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
            next() {
              if (this.activeKey == "1") {
                this.activeKey = "3"
              } else if (this.activeKey == "3") {
                this.activeKey = "4"
              } else if (this.activeKey == "4") {
                this.activeKey = "5"
              }
            },
            prev() {
              if (this.activeKey == "5") {
                this.activeKey = "4"
              } else if (this.activeKey == "4") {
                this.activeKey = "3"
              } else if (this.activeKey == "3") {
                this.activeKey = "1"
              }
            },
            checkIfItemIsEdited() {
                let copy = JSON.parse(JSON.stringify(this.event))
                delete copy.start
                delete copy.end
                delete copy.active
                let copyItem = JSON.parse(JSON.stringify(this.copyItem))
                delete copyItem.start
                delete copyItem.end
                delete copyItem.active
                if (JSON.stringify(copyItem) !== JSON.stringify(copy)) {
                    this.event.active = false
                    this.event.published = false
                    this.isItemEdited = true
                } else {
                    this.isItemEdited = false
                }

            },
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
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/cabinet/event/${res[3]}`)
                        .then(response => {

                            this.event = response.data
                            this.event.end == null ? this.noage = true : this.noage = false
                            this.copyItem = JSON.parse(JSON.stringify(this.event))
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
                    this.beforeunload = null
                    const message = this.$message.loading('Сохранение', 0)
                    this.checkIfItemIsEdited()
                    axios.put(`/api/cabinet/event/${this.event.slug}`, this.event)
                        .then(response => {
                            this.errors = {}
                            this.$message.success('Успешно сохранено!')
                            if (this.isItemEdited) {
                                this.showModal()
                            } else {
                                if (response.data.published) {
                                    location.href = '/cabinet/event'
                                } else {
                                    location.href = '/cabinet/event?moderation=1'
                                }
                            }
                            this.event = response.data
                            this.copyItem = JSON.parse(JSON.stringify(this.event))
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
            create() {
                if (!this.loading) {
                    this.loading = true
                    this.beforeunload = null
                    const message = this.$message.loading('Сохранение', 0)
                    axios.post(`/api/cabinet/event`, this.event)
                        .then(response => {
                            this.showModal()
                            this.errors = {}
                            this.event = response.data
                            // this.$message.success('Успешно сохранено!')
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
                                axios.delete(`/api/cabinet/event/${this.event.slug}`)
                                    .then(response => {
                                        location.replace(`/cabinet/event`)
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
                    axios.get(`/api/cabinet/company/${this.event.company.slug}`)
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
            redirect() {
                window.onbeforeunload = null
                location.href = `/cabinet/event?moderation=1`
            },
            showModal() {
                this.eventCreatedModal = true
            },
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
