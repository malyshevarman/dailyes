<template>
    <div>
      <div class="lk-body__title">
          Отзыв
      </div>
      <div style="background: rgba(255,0,255, .1);padding: 5px 10px;border-radius: 5px;margin-bottom: 10px;" v-if="comment.message && comment.rejected">Отзыв отклонен модератором по причине: {{comment.message}}</div>
      <div class="lk-body__row">
          <div class="container-fluid">
            <a-comment>
              <a slot="author">{{ comment.user.name }}</a>
              <a-avatar
                slot="avatar"
                :src="comment.user.avatar_url"
                :alt="comment.user.name"
              />
              <template v-if="!showCommentEditForm">
                <span
                  slot="actions"
                  @click="showEditForm()"
                  v-if="comment.rejected"
                >Редактировать</span>
                <p slot="content">
                  {{ comment.text }}
                </p>
              </template>
              <div v-else slot="content">
                <a-form-item>
                  <a-textarea
                    :rows="4"
                    v-model="comment.text"
                    id="editForm"
                  />
                  <!-- <span style="color:red;">Причина отклонения : {{comment.message}}</span> -->
                </a-form-item>
                <a-form-item>
                  <a-button
                    html-type="submit"
                    type="primary"
                    @click="copyCommentText == comment.text ? false : update()"
                    :disable="copyCommentText == comment.text"
                    :class="copyCommentText == comment.text ? 'disabled' : ''"
                  >
                    Сохранить
                  </a-button>
                </a-form-item>
              </div>
              <div>
                <a-list
                  v-if="comment.answers.length"
                  :data-source="comment.answers"
                  :header="`${comment.answers.length} ${comment.answers.length > 1 ? 'ответов' : 'ответ'}`"
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
                      <!-- <span
                        slot="actions"
                        @click="handleClick($event, item)"
                      >Ответить</span> -->
                    </a-comment>
                  </a-list-item>
                </a-list>
                <!-- <div v-if="formVisible">
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
                </div> -->
              </div>
            </a-comment>
          </div>
      </div>
      <a-modal
            v-model="modal"
            :closable="false"
            :width="540"
            :centered="true"
            :bodyStyle="{padding: '36px'}"
            :footer="null"
        >
            <img src="/icon/safari-pinned-tab.svg" width="110" height="70" style="margin: auto;display: block;">
            <p>
                Спасибо за ваш отзыв. После проверки всей необходимой информации
                модератором, ваш отзыв будет сразу опубликован.
            </p>
            <a-button style="padding: 14px 74px;display: block;margin: auto;min-height: 55px;" key="submit"
                      type="primary" :loading="loading" @click="closeModal()">
                Хорошо
            </a-button>
        </a-modal>
    </div>
  
</template>

<script>
    let str = window.location.pathname
    let res = str.split("/")

    export default {
        data() {
            return {
                user: {},
                comment: {
                    user: {},
                    answers: [{
                        user: {}
                    }]
                },
                copyCommentText: '',
                // answer: {
                //     parent: null,
                //     value: ''
                // },
                // value: '',
                // formVisible: false,
                errors: {},
                loading: false,
                alert: false,
                showCommentEditForm: false,
                modal: false
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
            showEditForm() {
              this.showCommentEditForm = !this.showCommentEditForm
              setTimeout(() => {
                $('#editForm').focus()
              }, 500)
            },
            update() {
              axios.put(`/api/cabinet/comment/${this.comment.id}`, this.comment)
              .then(response => {
                this.comment = response.data
                this.showEditForm()
                this.showModal()
              })
              .catch(error => {
                this.$message.error('Ошибка')
                this.errors = error.response.data.errors
              })
            },
            getAuthUser() {
                this.loading = true
                axios.get(`/api/cabinet/profile/get-auth-user`)
                    .then(response => {
                        this.user = response.data
                        this.loading = false
                    })
            },
            fetch() {
                axios.get(`/api/cabinet/comment/${res[3]}`)
                    .then(response => {
                        this.comment = response.data
                        if (this.comment.rejected) {
                          this.copyCommentText = JSON.parse(JSON.stringify(this.comment.text))
                          this.showEditForm()
                        }
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })

            },
            showModal() {
                this.modal = true
            },
            closeModal() {
                this.modal = false
                location.reload()
            }
            // handleClick(e, parent) {
            //     this.answer.parent = parent
            //     this.formVisible = true
            // },
            // handleSubmit() {
            //     if (!this.value) {
            //         return;
            //     }
            //     axios.post(`/api/cabinet/comment/${this.comment.id}/answer`, this.answer)
            //         .then(response => {
            //             location.reload()
            //         })
            //         .catch(error => {
            //             this.$message.error('Ошибка')
            //             this.errors = error.response.data.errors
            //         })
            // },
            // handleChange(e) {
            //     this.value = e.target.value
            // }
        }
    };
</script>

<style scoped>
    .ant-comment-content-detail p {
        white-space: unset !important;
    }
    .disabled {
      background: grey !important;
      color: white !important;
    }
</style>
