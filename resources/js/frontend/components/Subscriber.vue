<template>
  <div class="footer__col footer__col--newsletter">
    <div class="footer__head">
      Подпишитесь на новости
    </div>
    <div class="footer__note">
      Рассылка не содержит рекламных материалов
    </div>
    <form class="footer__form">
      <input
        v-model="subscriber.email"
        class="footer__input"
        type="email"
        :class="{'is-invalid': errors.email}"
        placeholder="Ваш e-mail"
      >
      <button
        class="btn btn--primary btn--sm"
        :disabled="!subscriber.agreement || submiting"
        type="button"
        @click.prevent="create"
      >
        Подписаться
      </button>
    </form>

    <input
      v-model="subscriber.agreement"
      :class="{'is-invalid': errors.agreement}"
      type="checkbox"
    >
    <span
      class="checkmark"
      @click="signAgreement"
    />
    <label class="footer__consent">Подписываясь на рассылку, вы соглашаетесь с получением информационных сообщений и
      нашей политикой конфиденциальности.</label>
  </div>
</template>

<script>
export default {
    data() {
        return {
            subscriber: {
                email: '',
                agreement: false
            },
            errors: {},
            success: false,
            submiting: false,
        }
    },
    methods: {
        signAgreement() {
            this.data.agreement = !this.data.agreement
        },
        create() {
            if (!this.submiting) {
                this.submiting = true
                axios.post(`/api/frontend/subscriber/subscribe`, this.subscriber)
                    .then(response => {
                        this.submiting = false
                        this.success = true
                        this.subscriber = {
                            email: '',
                            agreement: false
                        }
                        this.errors = {}
                        this.$bus.$emit('showModal', {
                            // title: 'Спасибо, что оставили свой отзыв',
                            text: 'Ваша подписка успешно оформлена'
                        })
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                        this.submiting = false
                    })
            }
        },
    }
}
</script>

<style scoped>

</style>
