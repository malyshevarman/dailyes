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
                                v-model="tag.name"
                                placeholder="Автосервисы"
                                @input="delete errors['name']"
                            />
                        </a-form-item>
                        <!-- <a-form-item
                          label="Теги"
                          :validate-status="errors.tags ? 'error' : ''"
                        >
                          <div id="tags">
                              <span class="tag" v-for="(tag, index) in category.tags" v-on:click="deletetag(index)">{{tag.name}}</span>
                          </div>
                          <input type="text" class="ant-input" placeholder="Нажмите Enter после ввода тега" v-model="tag" @focusin="focusout" v-on:keyup.enter="focusout" />
                        </a-form-item> -->
                        <a-form-item
                          label="Slug"
                          :validate-status="errors.slug ? 'error' : ''"
                        >
                          <a-input
                            v-model="tag.slug"
                            placeholder="Необязательно"
                          />
                        </a-form-item>
                        <a-form-item
                            label="Номер порядка"
                            :validate-status="errors.order ? 'error' : ''"
                        >
                            <a-input
                                v-model="tag.order"
                                placeholder="Введите номер"
                            />
                        </a-form-item>
                        <a-form-item
                            label="Превью"
                            :validate-status="errors['image.id'] ? 'error' : ''"
                        >
                            <image-upload
                                v-model="tag.image"
                                :width="510"
                                :height="600"
                                @input="delete errors['image.id']"
                            />
                        </a-form-item>
                        <a-form-item
                            label="Фон"
                            :validate-status="errors['background.id'] ? 'error' : ''"
                        >
                            <image-upload
                                v-model="tag.background"
                                :width="1440"
                                :height="750"
                                @input="delete errors['background.id']"
                            />
                        </a-form-item>
                        <!-- <a-form-item
                            label="Порядок в слайдере на главной"
                            :validate-status="errors.order ? 'error' : ''"
                        >
                            <a-input
                                v-model="category.order"
                                placeholder="Введите номер"
                            />
                        </a-form-item> -->
                    </a-form>
                </a-tab-pane>
                <!-- <a-tab-pane
                        key="2"
                        tab="Галерея"
                >
                    <a-form layout="vertical">
                        <br>
                        <a-form-item
                            label="Превью"
                            :validate-status="errors['image.id'] ? 'error' : ''"
                        >
                            <image-upload
                                v-model="category.image"
                                :width="510"
                                :height="600"
                                @input="delete errors['image.id']"
                            />
                        </a-form-item>
                        <a-form-item
                            label="Фон"
                            :validate-status="errors['background.id'] ? 'error' : ''"
                        >
                            <image-upload
                                v-model="category.background"
                                :width="1440"
                                :height="750"
                                @input="delete errors['background.id']"
                            />
                        </a-form-item>
                    </a-form>
                </a-tab-pane> -->
                <a-tab-pane
                  key="3"
                  tab="SEO акций"
                >
                  <a-form layout="vertical">
                    <br>
                    <a-form-item
                      label="H1"
                    >
                      <a-input
                        v-model="seoEvent.h1"
                      />
                    </a-form-item>
                    <a-form-item
                      label="Тайтл"
                      help="Чтобы указать наименование города или категории укажите  переменные city или tag соответственно"
                    >
                      <a-input
                        v-model="seoEvent.title"
                        placeholder="Тайтл"
                      />
                    </a-form-item>
                    <a-form-item
                      label="Мета описание"
                      help="Чтобы указать наименование города или категории укажите  переменные city или tag соответственно"
                    >
                      <a-input
                        v-model="seoEvent.description"
                        placeholder="Мета описание"
                      />
                    </a-form-item>
                    <a-form-item
                      label="Текст на странице"
                      help="Чтобы указать наименование города или категории укажите переменные city или tag соответственно"
                    >
                      <vue-tinymce
                      :key="seoCompany.page_text"
                        id="seoEvent"
                        v-model="seoEvent.page_text"
                        toolbar="bold italic | alignleft aligncenter alignright | bullist numlist | link image media | insertdatetime | code codesample"
                      />
                    </a-form-item>
                  </a-form>
                </a-tab-pane>
                <a-tab-pane
                  key="4"
                  tab="SEO компаний"
                >
                  <a-form layout="vertical">
                    <br>
                    <a-form-item
                      label="H1"
                    >
                      <a-input
                        v-model="seoCompany.h1"
                      />
                    </a-form-item>
                    <a-form-item
                      label="Тайтл"
                      help="Чтобы указать наименование города или категории укажите  переменные city или tag соответственно"
                    >
                      <a-input
                        v-model="seoCompany.title"
                        placeholder="Тайтл"
                      />
                    </a-form-item>
                    <a-form-item
                      label="Мета описание"
                      help="Чтобы указать наименование города или категории укажите  переменные city или tag соответственно"
                    >
                      <a-input
                        v-model="seoCompany.description"
                        placeholder="Мета описание"
                      />
                    </a-form-item>
                    <a-form-item
                      label="Текст на странице"
                      help="Чтобы указать наименование города или категории укажите переменные city или tag соответственно"
                    >
                      <vue-tinymce
                        :key="seoEvent.page_text"
                        id="seoCompany"
                        v-model="seoCompany.page_text"
                        toolbar="bold italic | alignleft aligncenter alignright | bullist numlist | link image media | insertdatetime | code codesample"
                      />
                    </a-form-item>
                  </a-form>
                </a-tab-pane>
                <div slot="tabBarExtraContent">
                    <!-- <a-button
                            v-if="tag.id"
                            type="danger"
                            :disabled="loading"
                            @click="destroy"
                    >
                        Удалить
                    </a-button> -->
                    <a-button
                            :disabled="loading"
                            @click="tag.id ? update() : create()"
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
                // tag: '',
                tag: {
                    // tags: []
                },
                errors: {},
                loading: false,
                alert: false,
                seoCompany: {
                    h1: '',
                    title: '',
                    description: '',
                    page_text: ''
                },
                seoEvent: {
                    h1: '',
                    title: '',
                    description: '',
                    page_text: ''
                }
            };
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            },
        },
        mounted() {
            if (res[4] === 'edit') {
                this.fetch()
            }
        },
        methods: {
            // focusout: function() {
            //     console.log()
            //     let txt = this.tag.replace(/[^а-яa-z0-9\+\-\.\#]/ig,''); // allowed characters
            //     if(txt) {
            //         this.category.tags.push({name: txt});
            //     }
            //     this.tag = "";
            // },
            // deletetag: function(e) {
            //     this.category.tags.splice(e, 1)
            // },
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/tags/${res[3]}`)
                        .then(response => {
                            this.tag = response.data.tag
                            this.seoEvent = response.data.seoEvent !== null ? response.data.seoEvent : this.seoEvent
                            this.seoCompany = response.data.seoCompany !== null ? response.data.seoCompany : this.seoCompany
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
                    axios.put(`/api/backend/tags/${res[3]}`, {tag: this.tag, seoEvent: this.seoEvent, seoCompany: this.seoCompany})
                        .then(response => {
                            this.errors = {}
                            this.tag = response.data.tag
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
                    axios.post(`/api/backend/tags`, {tag: this.tag, seoEvent: this.seoEvent, seoCompany: this.seoCompany})
                        .then(response => {
                            this.errors = {}
                            this.tag = response.data.tag
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/tags/${response.data.tag.slug}/edit`
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
            // destroy() {
            //     if (!this.loading) {
            //         this.loading = true
            //         const message = this.$message.loading('Сохранение', 0)
            //         swal({
            //             title: "Вы уверены?",
            //             text: "Это необратимый процесс!",
            //             icon: "warning",
            //             buttons: true,
            //             dangerMode: true,
            //         })
            //             .then((willDelete) => {
            //                 if (willDelete) {
            //                     axios.delete(`/api/backend/tags/${this.tag.slug}`)
            //                         .then(response => {
            //                             location.replace(`/admin/tags`)
            //                         })
            //                         .catch(error => {
            //                             this.errors = error.response.data.errors
            //                         })
            //                 }
            //             })
            //             .then(() => {
            //                 setTimeout(message, 0)
            //                 this.loading = false
            //             })
            //     }
            // }
        }
    };
</script>

<!-- <style scoped lang="scss">
.tag {
  padding: 0 5px 3px 5px;
  margin-bottom: 10px;
  display: inline-block;
  min-width: 50px;
  border: 3px solid #096dd9;
  border-radius: 10px;
  background: #096dd9;
  text-transform: lowercase;
  text-align: center;
  color: #fff;
  margin-right: 5px;
    cursor: pointer;
  &:after {
    content: "\f00d";
    padding-left: 3px;
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;

  }
}
</style> -->
