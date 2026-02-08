<template>
  <a-comment>
    <span
      slot="actions"
      @click="handleClick"
    >Ответить</span>
    <a slot="author">{{ question.user.name }}</a>
    <a-avatar
      slot="avatar"
      :src="question.user.avatar_url"
      :alt="question.user.name"
    />
    <p slot="content">
      {{ question.text }}
    </p>
    <div>
      <a-list
        v-if="question.answers.length"
        :data-source="question.answers"
        :header="`${question.answers.length} ${question.answers.length > 1 ? 'ответов' : 'ответ'}`"
        item-layout="horizontal"
      >
        <a-list-item
          slot="renderItem"
          slot-scope="item, index"
        >
          <a-comment
            :author="item.user.name"
            :avatar="item.user.avatar_url"
            :content="item.text"
            :datetime="item.created_at"
          >
            <span
              slot="actions"
              @click="handleClick($event, item)"
            >Ответить</span>
          </a-comment>
        </a-list-item>
      </a-list>
      <div v-if="formVisible">
        <div
          v-if="answer.parent"
          style="margin-left: 44px;"
        >
          Ответ {{ answer.parent.user.name }}
        </div>
        <a-comment>
          <a-avatar
            slot="avatar"
            :src="user.avatar_url"
            :alt="user.name"
          />
          <div slot="content">
            <a-form-item>
              <a-textarea
                :rows="4"
                :value="value"
                @change="handleChange"
              />
            </a-form-item>
            <a-form-item>
              <a-button
                html-type="submit"
                type="primary"
                @click="handleSubmit"
              >
                Добавить ответ
              </a-button>
            </a-form-item>
          </div>
        </a-comment>
      </div>
    </div>
  </a-comment>
</template>

<script>
    let str = window.location.pathname
    let res = str.split("/")

    export default {
        data() {
            return {
                user: {},
                question: {
                    user: {},
                    answers: [{
                        user: {}
                    }]
                },
                answer: {
                    parent: null,
                    value: ''
                },
                value: '',
                formVisible: false,
                errors: {},
                loading: false,
                alert: false
            };
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            },
            value: function (val) {
                this.answer.text = val
            }
        },
        mounted() {
            this.getAuthUser()
            this.fetch()
        },
        methods: {
            getAuthUser() {
                this.loading = true
                axios.get(`/api/cabinet/profile/get-auth-user`)
                    .then(response => {
                        this.user = response.data
                        this.loading = false
                    })
            },
            fetch() {
                axios.get(`/api/cabinet/question/${res[3]}`)
                    .then(response => {
                        this.question = response.data
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })

            },
            handleClick(e, parent) {
                this.answer.parent = parent
                this.formVisible = true
            },
            handleSubmit() {
                if (!this.value) {
                    return;
                }
                axios.post(`/api/cabinet/question/${this.question.id}/answer`, this.answer)
                    .then(response => {
                        location.reload()
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                        this.errors = error.response.data.errors
                    })
            },
            handleChange(e) {
                this.value = e.target.value
            }
        }
    };
</script>

<style scoped>
    .ant-comment-content-detail p {
        white-space: unset !important;
    }
</style>
