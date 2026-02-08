<template>
  <div id="form_bgr" class="form-background" style="margin-top: 96px;">
    <div class="form-background-title">
      <p><strong>Оставьте заявку</strong></p>
      <p>Начните работать с нами уже сегодня</p>
      <p>Если вам нужна медийная реклама, заполните форму ниже. Мы​ определим ваши потребности и​ сформируем подходящее предложение.</p>
    </div>
    <div>
        <form id="form" v-if="!loading" class="form">

            <div class="form-block">
                <input :class="{'is-invalid': errors.name}" class="form-control" type="text" placeholder=" " v-model="order.name">
                <label for="name">Имя*</label>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block">
                <input :class="{'is-invalid': errors.phone}" class="form-control" type="text" placeholder=" " v-mask="'+# (###) ###-##-##'" @click="startTexting" v-model="order.phone">
                <label for="email">Телефон*</label>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block">
                <input :class="{'is-invalid': errors.mail}" class="form-control" type="text" placeholder=" " v-model="order.mail">
                <label>E-mail*</label>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block">
                <input :class="{'is-invalid': errors.site_link}" class="form-control" type="text" placeholder=" " v-model="order.site_link">
                <label for="name">Ссылка на ваш сайт</label>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block">
                <textarea class="form-control" :class="{'is-invalid': errors.description}" placeholder="Комментарий" v-model="order.description"></textarea>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block d-flex">
                <input v-if="order.agreement" type="submit"  class="submit-button" @click.prevent="send" value="Отправить"/>
                <input v-else disabled class="submit-button disabled" type="submit" value="Отправить"/>
               <!--  <div
                  v-if="success"
                  class="subscribe-block__notify"
                  id="success-subscribe"
                  style="width: 320px;z-index: 1;top:100%;right:18%;"
                >Заявка отправлена</div> -->
            </div>

            <div class="form-block">
              <div class="checkbox">
                <input class="form-control" :class="{'is-invalid': errors.agreement}" type="checkbox" v-model="order.agreement">
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
      headers: {
        authorization: 'authorization-text',
      },
      order: {
        phone: '',
        name: '',
        mail: '',
        description: '',
        agreement: false,
        site_link: ''

      },
      errors: {},
      loading: false,
      submiting: false,
      success: false
    }
  },
  mounted () { 
  
  },
  methods: {
    signAgreement() {
      this.order.agreement = !this.order.agreement
    },
    startTexting() {
      this.order.phone = "+7 ("
    },
    send () {
      if (!this.submiting) {
        this.submiting = true
        this.success = false
        axios.post(`/api/frontend/callback/advertising-callbackorder`, this.order)
        .then(response => {
          this.submiting = false
          this.success = true
          this.errors = {}
          this.order = {
            phone: '',
            name: '',
            mail: '',
            description: '',
            agreement: false,
            site_link: ''

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
