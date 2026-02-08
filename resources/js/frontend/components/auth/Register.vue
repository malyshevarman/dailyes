<template>
  <form :class="[formclass ? formclass : 'reg-form']">
    <div class="row">
      <template v-if="!finish">
        <div class="col-md-6">
          <div class="auth-form__relative">
            <div class="auth-form__title">
              Имя*
            </div>
            <input
              v-model="register.name"
              name="name"
              class="auth-form__input"
              type="text"
              :class="{'error': errors.name}"
              placeholder="Ваше имя"
              autofocus
              required
              tabindex="1"
            >
          </div>
          <div class="auth-form__title">
            Пароль*
          </div>
          <div class="reg-form__block">
            <input
              v-model="register.password"
              name="password"
              class="auth-form__input"
              type="password"
              :class="{'error': errors.password}"
              placeholder="Придумайте пароль"
              tabindex="3"
            >
            <div class="open-password">
              <i class="fas fa-eye" />
            </div>
          </div>
          <div class="reg-form__agree">
            <input
              id="check"
              v-model="register.accept"
              name="agree"
              type="checkbox"
              value="1"
              tabindex="4"
              required
              :class="{ error: !register.accept }"
            >
            <label for="check" />
            <div class="reg-form__agree-block">
              Я даю свое согласие на обработку<a href="/rules"> персональных данных</a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="auth-form__relative">
            <div class="auth-form__title">
              Электронная почта*
            </div>
            <input
              v-model="register.email"
              name="email"
              class="auth-form__input"
              type="text"
              :class="{'error': errors.email}"
              placeholder="E-mail"
              tabindex="2"
            >
          </div>
          <div class="auth-form__title">
            Подтвердить пароль*
          </div>
          <div class="reg-form__block">
            <input
              v-model="register.password_confirmation"
              name="password"
              class="auth-form__input"
              type="password"
              :class="{'error': errors.password_confirmation}"
              placeholder="Подтвердите пароль"
              tabindex="3"
            >
            <div class="open-password">
              <i class="fas fa-eye" />
            </div>
          </div>
          <div class="reg-form__soc" style="margin-top: 0;">
            <div class="auth-form__soc-title">
              Или войдите<br>через соц. сети
            </div>
            <div class="reg-form__soc-list">
              <a href="/login/vkontakte">
                <div><img src="/images/icons/social/vk.svg"></div>
              </a>
              <!-- <a href="/login/facebook">
                <div><img src="/images/icons/social/fb.svg"></div>
              </a> -->
              <a href="/login/odnoklassniki">
                <div><img src="/images/icons/social/ok.svg"></div>
              </a>
              <!-- <a href="/login/instagram">
                <div><img src="/images/icons/social/inst.svg"></div>
              </a> -->
            </div>
          </div>
          <button
            type="submit"
            @click.prevent="signUp()"
            tabindex="5"
            :disabled="!register.accept"
          >
            Зарегистрироваться
          </button>
        </div>
      </template>
      <template v-else>
        <div class="col-md-12 text-center forgot-form__success">
          Вы успешно <b>зарегистрировались</b>!<br>
          Мы выслали Вам письмо на email для подтверждения регистрации!<br>
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
                register: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    accept: 1,
                },
                errors: {},
                loading: false,
                finish: 0
            }
        },
        computed: {
            password() {
                return this.register.password;
            }
        },
        watch: {
            password(val) {
                this.register.password_confirmation = val
            }
        },
        mounted() {

        },
        methods: {
            signUp() {
                this.loading = true
                axios.post(`/register`, this.register)
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
