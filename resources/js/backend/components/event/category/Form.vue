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
                v-model="category.name"
                placeholder="Автосервисы"
                @input="delete errors['name']"
              />
            </a-form-item>

            <a-form-item
              label="Порядок в слайдере на главной"
              :validate-status="errors.order ? 'error' : ''"
            >
              <a-input
                v-model="category.order"
                placeholder="Введите номер"
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
              label="H1"
              :validate-status="errors.h1 ? 'error' : ''"
            >
              <a-input
                v-model="category.h1"
              />
            </a-form-item>
            <a-form-item
              label="Slug"
              :validate-status="errors.slug ? 'error' : ''"
            >
              <a-input
                v-model="category.slug"
                placeholder="Необязательно"
              />
            </a-form-item>
            <a-form-item
              label="Тайтл"
              :validate-status="errors.title ? 'error' : ''"
              help="Чтобы указать наименование города или категории укажите  переменные city или category соответственно"
            >
              <a-input
                v-model="category.title"
                placeholder="Тайтл"
              />
            </a-form-item>
            <a-form-item
              label="Мета описание"
              :validate-status="errors.description ? 'error' : ''"
              help="Чтобы указать наименование города или категории укажите  переменные city или category соответственно"
            >
              <a-input
                v-model="category.description"
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
                v-model="category.text"
                toolbar="bold italic | alignleft aligncenter alignright | bullist numlist | link image media | insertdatetime | code codesample"
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
        </a-tab-pane>
        <div slot="tabBarExtraContent">
          <a-button
            v-if="category.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить
          </a-button>
          <a-button
            :disabled="loading"
            @click="category.id ? update() : create()"
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
                category: {},
                errors: {},
                loading: false,
                alert: false
            };
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            },
        },
        mounted() {
            if (res[5] === 'edit') {
                this.fetch()
            }
        },
        methods: {
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/event/category/${res[4]}`)
                        .then(response => {
                            this.category = response.data
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
                    axios.put(`/api/backend/event/category/${res[4]}`, this.category)
                        .then(response => {
                            this.errors = {}
                            this.category = response.data
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
                    axios.post(`/api/backend/event/category`, this.category)
                        .then(response => {
                            this.errors = {}
                            this.category = response.data
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/event/category/${response.data.slug}/edit`
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
                                axios.delete(`/api/backend/event/category/${this.category.slug}`)
                                    .then(response => {
                                        location.replace(`/admin/event/category`)
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
            }
        }
    };
</script>

<style scoped>
</style>
