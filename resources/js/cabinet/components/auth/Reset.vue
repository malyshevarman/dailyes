<template>
  <form :class="[formclass ? formclass : 'reg-form']">
    <div class="row">
      <template v-if="!finish">
        <div class="col-md-6">
          <div class="auth-form__relative">
            <div class="auth-form__title">
              Email*
            </div>
            <input
              v-model="reset.email"
              name="name"
              class="auth-form__input"
              type="text"
              :class="{'error': errors.email}"
              placeholder="Ваше имя"
              autofocus
              required
            >
          </div>
        </div>
        <div class="col-md-6">
          <div class="auth-form__relative">
            <div class="auth-form__title">
              Пароль*
            </div>
            <div class="reg-form__block">
              <input
                v-model="reset.password_confirmation"
                name="password"
                class="auth-form__input"
                type="password"
                :class="{'error': errors.password_confirmation}"
                placeholder="Придумайте пароль"
              >
              <div class="open-password">
                <i class="fas fa-eye" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="auth-form__title">
            Повторите пароль*
          </div>
          <div class="reg-form__block">
            <input
              v-model="reset.password"
              name="password"
              class="auth-form__input"
              type="password"
              :class="{'error': errors.password}"
              placeholder="Придумайте пароль"
            >
          </div>
        </div>
        <div class="col-md-6">
          <div
            style="margin-top:29px;margin-bottom:0px;"
            class="reg-form__soc"
          >
            <button
              type="submit"
              @click.prevent="resetSend()"
            >
              Смена пароля
            </button>
          </div>
        </div>
      </template>
      <template v-else>
        <div class="col-md-12 text-center forgot-form__success">
          Ваш пароль успешно обновлен!<br>
          <img src="/images/icons/good.svg">
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
                reset: {
                    token: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                },
                errors: {},
                loading: false,
                finish: 0
            }
        },
        mounted: function () {
            let str = window.location.pathname
            let res = str.split("/")
            this.reset.token = res[3]
        },
        methods: {
            resetSend() {
                this.loading = true
                axios.post(`/password/reset`, this.reset)
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
        }
    }
</script>
