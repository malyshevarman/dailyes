<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff'}">
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
      <a-form layout="vertical">
        <br>
        <a-form-item
          label="Заголовок"
          :validate-status="errors.title ? 'error' : ''"
        >
          <a-input
            v-model="article.title"
            @input="delete errors['title']"
          />
        </a-form-item>

        <a-form-item
          label="Превью"
          :validate-status="errors.preview ? 'error' : ''"
        >
          <image-upload
            v-model="article.preview"
            :width="377"
            :height="224"
            @input="delete errors['preview']"
          />
        </a-form-item>

        <a-form-item
          label="Фон"
          :validate-status="errors.background ? 'error' : ''"
        >
          <image-upload
            v-model="article.background"
            :width="1440"
            :height="750"
            @input="delete errors['background']"
          />
        </a-form-item>

        <a-form-item
          label="Краткое описание"
          :validate-status="errors.description ? 'error' : ''"
        >
          <a-textarea
            id="description"
            v-model="article.description"
          />
        </a-form-item>

        <a-form-item
          label="Теги"
          :validate-status="errors.tags ? 'error' : ''"
        >
          <div id="tags">
              <span class="tag" v-for="(tag, index) in article.tags" v-on:click="deletetag(index)">{{tag.name}}</span>
          </div>
          <input type="text" class="ant-input" placeholder="Нажмите Enter после ввода тега" v-model="tag" @focusin="focusout" v-on:keyup.enter="focusout" />
        </a-form-item>

        <a-form-item
          label="Текст"
          :validate-status="errors.text ? 'error' : ''"
        >
          <vue-tinymce
            id="text"
            v-model="article.text"
            toolbar="bold italic | alignleft aligncenter alignright | bullist numlist | link image media | insertdatetime | code codesample"
            @input="delete errors['text']"
          />
        </a-form-item>
        <div style="width: 25%;">
            <img v-if="img.path" style="width: 100%;" @click="addimage('/storage/' + img.path)" v-bind:src="'/storage/' + img.path"/>
            <span style="display: block;
                        width: 100%;
                        margin-bottom: 30px;">{{img.path ? 'Кликните на картинку, чтобы добавить ее в редактор' : 'Выберите картинку для вставки в редактор'}}</span>
            <input type="file"
                   id="customFile"
                   @change="onAttachmentChange"
                   accept="image/*"
                   style="margin-bottom: 40px;"
            >
        </div>
      </a-form>

      <a-button
        v-if="article.id"
        type="danger"
        :disabled="loading"
        @click="destroy"
      >
        Удалить статью
      </a-button>
      <a-button
        :disabled="loading"
        type="primary"
        @click="article.id ? update() : create()"
      >
        {{ article.id ? 'Сохранить' : 'Добавить статью' }}
      </a-button>
    </a-layout-content>
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
              tag: '',
              img: [],
                article: {
                    title: '',
                    text: '',
                    published: true,
                    tags: [],
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
        },
        methods: {
            addimage(url) {
                tinymce.activeEditor.insertContent('<img alt="картинка" src="' + url + '"/>');

            },
            submit(attachment) {
                this.loading = true
                const formData = new FormData()
                formData.append('file', attachment)
                axios.post('/api/backend/download', formData)
                    .then(response => {
                        this.img = response.data
                        this.loading = false
                    })
                    .catch(error => console.log(error))
            },
            onAttachmentChange(e) {
                let attachment = e.target.files[0]
                console.log(this.attachment)
                this.submit(attachment)
            },
            deletetag: function(e) {
                this.article.tags.splice(e, 1)
            },
            focusout: function() {
                let txt = this.tag.replace(/[^а-яa-z0-9\+\-\.\#]/ig,''); // allowed characters
                if(txt) {
                    this.article.tags.push({name: txt});
                }
                this.tag = "";
            },
            fetch() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    axios.get(`/api/backend/article/${res[3]}`)
                        .then(response => {
                            this.article = response.data
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
                    axios.put(`/api/backend/article/${this.article.slug}`, this.article)
                        .then(response => {
                            this.errors = {}
                            this.article = response.data
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
                    axios.post(`/api/backend/article`, this.article)
                        .then(response => {
                            this.errors = {}
                            this.article = response.data
                            this.$message.success('Успешно сохранено!')
                            location.href = `/admin/article/${response.data.slug}/edit`
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
                                axios.delete(`/api/backend/article/${this.article.slug}`)
                                    .then(response => {
                                        location.replace(`/admin/article`)
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

<style scoped lang="scss">
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
</style>
