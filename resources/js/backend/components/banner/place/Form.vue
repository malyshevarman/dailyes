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
                v-model="place.name"
                placeholder="Баннер в списке акций"
                @input="delete errors['name']"
              />
            </a-form-item>

            <a-form-item
              label="Ключ"
              :validate-status="errors.key ? 'error' : ''"
            >
              <a-input
                v-model="place.key"
                placeholder="banner-key"
              />
            </a-form-item>

            <a-form-item
              label="Ширина"
              :validate-status="errors.width ? 'error' : ''"
            >
              <a-input
                v-model="place.width"
                placeholder="240"
                @input="delete errors['width']"
              />
            </a-form-item>

            <a-form-item
              label="Высота"
              :validate-status="errors.height ? 'error' : ''"
            >
              <a-input
                v-model="place.height"
                placeholder="400"
                @input="delete errors['height']"
              />
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <div slot="tabBarExtraContent">
          <a-button
            v-if="place.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить
          </a-button>
          <a-button
            :disabled="loading"
            @click="place.id ? update() : create()"
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
                place: {},
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
                    axios.get(`/api/backend/banner/place/${res[4]}`)
                        .then(response => {
                            this.place = response.data
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
                    axios.put(`/api/backend/banner/place/${this.place.id}`, this.place)
                        .then(response => {
                            this.errors = {}
                            this.place = response.data
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
                    axios.post(`/api/backend/banner/place`, this.place)
                        .then(response => {
                            this.errors = {}
                            this.place = response.data
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/banner/place/${response.data.id}/edit`
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
                                axios.delete(`/api/backend/banner/place/${this.place.id}`)
                                    .then(response => {
                                        location.replace(`/admin/banner/place`)
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
            }
        }
    };
</script>

<style scoped>
</style>
