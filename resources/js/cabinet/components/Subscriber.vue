<template>
  <div>
    <form class="subscribe-block__form">
      <div class="subscribe-block__form-table">
        <input
          v-model="subscriber.email"
          class="subscribe-block__search-input"
          placeholder="Ваш e-mail"
          type="text"
        >
      </div>
      <button
        class="subscribe-block__search-button"
        :disabled="submiting"
        @click.prevent="create"
      >
        <img src="/images/icons/contact.svg">Подписаться
      </button>
    </form>
    <span
      v-if="errors.email"
      class="subscribe-block__notify error"
    >{{ errors.email[0] }}</span>
    <span
      v-else-if="success"
      class="subscribe-block__notify"
    >Ваша подписка успешно оформлена</span>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                subscriber: {},
                errors: {},
                success: false,
                submiting: false
            }
        },
        methods: {
            create() {
                if (!this.submiting) {
                    this.submiting = true
                    axios.post(`/api/frontend/subscriber/subscribe`, this.subscriber)
                        .then(response => {
                            this.submiting = false
                            this.success = true
                            this.subscriber = {}
                            this.errors = {}
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
