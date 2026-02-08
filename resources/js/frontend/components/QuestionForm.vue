<template>
  <div class="have-questions">
    <p><strong>Остались вопросы?</strong></p>
    <p>Задайте их нашему менеджеру, заполнив форму обратной связи:</p>
    <div>
        <form v-if="!loading" class="d-flex news-block_subscribe-block_form flex-wrap">
            <div class="form-block">
                <input :class="{'is-invalid': errors.phone}" class="form-control height-inp" type="text" placeholder=" " v-mask="'+# (###) ###-##-##'" @click="startTexting" v-model="data.phone">
                <label for="email">Телефон*</label>
                <small class="form-text text-muted"></small>
            </div>
            <div class="form-block">
                <input :class="{'is-invalid': errors.name}" class="form-control height-inp" type="text" placeholder=" " v-model="data.name">
                <label for="name">Ваше имя*</label>
                <small class="form-text text-muted"></small>
            </div>
            <div class="form-block">
                <input v-if="data.agreement" class="height-inp but-inp" type="submit" value="Заказать звонок" @click.prevent="send">
                <input v-else disabled class="height-inp but-inp disabled" type="submit" value="Заказать звонок"/>
                <!-- <div
                  v-if="success"
                  class="subscribe-block__notify"
                  id="success-subscribe"
                >Заявка отправлена</div> -->
            </div>

            <div class="form-block full-width">
              <div class="checkbox">
                <input class="form-control" :class="{'is-invalid': errors.agreement}" type="checkbox" v-model="data.agreement">
                <span class="checkmark" @click="signAgreement"></span>
                <label>Отправляя форму, вы даете свое согласие на обработку<a href="/rules"> персональных данных</a></label>
                <small class="form-text text-muted"></small>
              </div>
            </div>
        </form>
    </div>
  </div>
</template>

<script>

export default {
  data () {
    return {
      data: {
        phone: '',
        name: '',
        agreement: false,
      },
      errors: {},
      loading: false,
      submiting: false,
      success: false,
    }
  },
  mounted () { 
    console.log(this.data.phone)
  },
  methods: {
    signAgreement() {
      this.data.agreement = !this.data.agreement
    },
    startTexting() {
      this.data.phone = "+7 ("
    },
    send () {
      if (!this.submiting) {
        this.submiting = true
        this.success = false
        // this.errors = {}
        axios.post(`/api/frontend/callback/callbackorder `, this.data)
        .then(response => {
          this.submiting = false
          this.success = true
          this.errors = {}
          this.data = {
            phone: '',
            name: '',
            agreement: false,
          }
          this.$bus.$emit('showModal', {
                              // title: 'Спасибо, что оставили свой отзыв',
                              text: 'Заявка отправлена'
                            })
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    }
  }
}
</script>
