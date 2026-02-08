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
                v-model="page.name"
                placeholder="О сервисе"
                @input="delete errors['name']"
              />
            </a-form-item>

            <a-form-item
              label="Краткое описание"
              :validate-status="errors.summary ? 'error' : ''"
            >
              <a-textarea
                id="summary"
                v-model="page.summary"
              />
            </a-form-item>

            <a-form-item
              label="Основной блок"
              :validate-status="errors.content ? 'error' : ''"
            >
              <vue-tinymce
                id="content"
                v-model="page.content"
                toolbar="bold italic | alignleft aligncenter alignright | bullist numlist | link image media | insertdatetime | code codesample"
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
              label="Тайтл"
              :validate-status="errors.title ? 'error' : ''"
            >
              <a-input
                v-model="page.title"
                placeholder="Тайтл"
              />
            </a-form-item>

            <a-form-item
              label="Мета описание"
              :validate-status="errors.description ? 'error' : ''"
            >
              <a-input
                v-model="page.description"
                placeholder="Мета описание"
              />
            </a-form-item>

            <a-form-item
              label="Заголовок первого уровня"
              :validate-status="errors.h1 ? 'error' : ''"
            >
              <a-input
                v-model="page.h1"
                placeholder="Заголовок первого уровня"
              />
            </a-form-item>

            <a-form-item
              label="Путь"
              :validate-status="errors.path ? 'error' : ''"
            >
              <a-input
                v-model="page.path"
                placeholder="Необязательно"
              />
            </a-form-item>
          </a-form>
        </a-tab-pane>
        <a-button
          slot="tabBarExtraContent"
          :disabled="loading"
          @click="update"
        >
          Сохранить
        </a-button>
      </a-tabs>
    </a-layout-content>
  </a-layout>
</template>
<script>
  export default {
    data() {
      return {
        page: {},
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
    methods: {
      update() {
        if (!this.loading) {
          this.loading = true
          const message = this.$message.loading('Сохранение', 0)
          axios.post(`/api/backend/page`, this.page)
                  .then(response => {
                    this.errors = {}
                    this.page = response.data
                    this.$message.success('Успешно сохранено!')
                    location.href = `/admin/page/${response.data.id}/edit`
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
      }
    }
  };
</script>

<style scoped>
</style>
