<template>
  <form :class="[formclass ? formclass : 'auth-form']">
    <div class="row">
      <div class="col-md-6">
        <div class="auth-form__relative">
          <div class="auth-form__title">
            Электронная почта*
          </div>
          <input
            v-model="login.email"
            name="email"
            class="auth-form__input"
            :class="{'error': errors.email}"
            type="text"
            placeholder="E-mail"
            required
          >
        </div>
        <div class="auth-form__soc">
          <div class="auth-form__soc-title">
            Или войдите<br>через соц. сети
          </div>
          <div class="auth-form__soc-list">
            <a href="/login/vkontakte">
              <div><img src="/images/icons/social/vk.svg"></div>
            </a>
            <a href="/login/facebook">
              <div><img src="/images/icons/social/fb.svg"></div>
            </a>
            <a href="/login/odnoklassniki">
              <div><img src="/images/icons/social/ok.svg"></div>
            </a>
            <a href="/login/instagram">
              <div><img src="/images/icons/social/inst.svg"></div>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="auth-form__relative">
          <div class="auth-form__title">
            Пароль*
          </div>
          <input
            v-model="login.password"
            name="password"
            class="auth-form__input"
            :class="{'error': errors.password}"
            type="password"
            placeholder="Пароль"
            required
          >
        </div>
        <div class="auth-form__soc-mob">
          <div class="auth-form__soc-title">
            Или войдите<br>через соц. сети
          </div>
          <div class="auth-form__soc-list">
            <a href="/login/vkontakte">
              <div><img src="/images/icons/social/inst.svg">
              </div>
            </a>
            <a href="/login/facebook">
              <div><img src="/images/icons/social/fb.svg">
              </div>
            </a>
            <a href="/login/odnoklassniki">
              <div><img src="/images/icons/social/ok.svg">
              </div>
            </a>
            <a href="/login/instagram">
              <div><img src="/images/icons/social/inst.svg"></div>
            </a>
          </div>
        </div>
        <button
          type="submit"
          @click.prevent="signIn()"
        >
          Войти в аккаунт
        </button>
      </div>
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
                login: {
                    email: null,
                    password: null,
                    remember: 1
                },
                errors: {},
                loading: false,
            }
        },
        mounted() {
            console.log(this.formclass)
        },
        methods: {
            signIn() {
                this.loading = true
                axios.post(`/login`, this.login)
                    .then(response => {
                        location.href = '/'
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
