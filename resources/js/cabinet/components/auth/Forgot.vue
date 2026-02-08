<template>
  <form :class="[formclass ? formclass : 'forgot-form']">
    <div class="row">
      <template v-if="!finish">
        <div class="col-md-6">
          <div class="auth-form__relative">
            <div class="auth-form__title">
              Электронная почта*
            </div>
            <input
              v-model="forgot.email"
              name="email"
              class="auth-form__input"
              :class="{'error': errors.email}"
              type="text"
              placeholder="E-mail"
            >
          </div>
        </div>
        <div class="col-md-6">
          <div class="auth-form__title">
&nbsp;
          </div>
          <button
            type="submit"
            @click.prevent="forgotSend()"
          >
            Восстановить пароль
          </button>
        </div>
      </template>
      <template v-else>
        <div class="col-md-12 text-center forgot-form__success">
          Мы прислали письмо на <b>{{ forgot.email }}</b>,<br>
          пожалуйста проверьте свой почтовый ящик!<br>
          <img src="/images/mail-send.png">
        </div>
      </template>
    </div>
  </form>
</template>

<script>
    export default {
        props: [
            'formclass'
        ],
        data() {
            return {
                forgot: {
                    email: null,
                },
                errors: {},
                loading: false,
                finish: 0
            }
        },
        mounted() {

        },
        methods: {
            forgotSend() {
                this.loading = true
                axios.post(`/password/email`, this.forgot)
                    .then(response => {
                        this.finish = 1
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })
                    .then(() => {
                        this.loading = false
                    })
            }
        },
    }
</script>
