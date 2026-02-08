<template>
  <a-layout :style="{ minHeight: '100%' }">
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
                v-model="selection.name"
                placeholder="Рейтинг ресторанов"
              />
            </a-form-item>

            <a-form-item
              v-if="selection.companies.length === 0"
              label="Акции"
            >
              <select-search
                v-model="selection.events"
                :url="'/api/backend/event/search/'"
              />
            </a-form-item>

            <a-form-item
              v-if="selection.events.length === 0"
              label="Компании"
            >
              <select-search
                v-model="selection.companies"
                :url="'/api/backend/company/search/'"
              />
            </a-form-item>

              <a-form-item
                  label="Фоновая картинка"
              >
                  <image-upload
                      :height="750"
                      :width="1440"
                      v-model="selection.background"
                  />
              </a-form-item>


              <a-form-item
              label="Параметры"
            >
              <div
                v-for="(param, key, index) in selection.params"
                :key="key"
              >
                <a-input-group compact>
                  <a-input
                    style=" width: 200px; text-align: center"
                    placeholder="Название"
                    :value="key"
                    disabled
                  />
                  <a-input
                    style=" width: 30px; border-left: 0; pointer-events: none; backgroundColor: #fff"
                    placeholder="->"
                    disabled
                  />
                  <a-input
                    v-model="selection.params[key]"
                    style="width: 200px; text-align: center; border-left: 0"
                    placeholder="Значение"
                  />
                </a-input-group>
                <a-icon
                  type="delete"
                  @click="() => deleteParam(key)"
                />
                <br>
                <br>
              </div>
              <a-input-group compact>
                <a-input
                  v-model="newKey"
                  style=" width: 200px; text-align: center"
                  placeholder="Ключ"
                />
                <a-button @click.prevent="addKey">
                  Добавить
                </a-button>
              </a-input-group>
            </a-form-item>
          </a-form>
        </a-tab-pane>

        <div slot="tabBarExtraContent">
          <a-button
            v-if="selection.id"
            type="danger"
            :disabled="loading"
            @click="destroy"
          >
            Удалить
          </a-button>
          <a-button
            :disabled="loading"
            @click="selection.id ? update() : create()"
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
                selection: {
                    params: {},
                    events: [],
                    companies: []
                },
                newKey: '',
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
        },
        methods: {
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/selection/${res[3]}`)
                        .then(response => {
                            this.selection = response.data
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
                    axios.put(`/api/backend/selection/${res[3]}`, this.selection)
                        .then(response => {
                            this.errors = {}
                            this.selection = response.data
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
                    axios.post(`/api/backend/selection`, this.selection)
                        .then(response => {
                            this.errors = {}
                            this.selectionLabel = response.data
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/selection/${response.data.id}/edit`
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
                                axios.delete(`/api/backend/selection/${res[3]}`)
                                    .then(response => {
                                        location.replace(`/admin/selection`)
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
            addKey() {
                if (!this.newKey) {
                    return;
                }
                if(!this.selection.params || this.selection.params.length < 1) {
                    this.selection.params = {}
                }
                this.$set(this.selection.params, this.newKey, '')
                this.newKey = ''
            },
            deleteParam(key) {
                this.$delete(this.selection.params, key)
            },
        }
    };
</script>

<style scoped>
</style>
