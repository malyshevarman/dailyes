<template>
	<div class="col-md-12 bootfix-col">
	  <div class="news-block_subscribe-block">
	    <p><strong>Хочешь получать наши классные статьи на почту?</strong></p>
	    <p>Подпишись на рассылку прямо сейчас!</p>
	    <div>
	        <form v-if="!loading" class="d-flex news-block_subscribe-block_form flex-wrap">
	            <div class="form-block">
	                <input :class="{'is-invalid': errors.email}" class="form-control height-inp" type="text" placeholder=" " v-model="data.email">
	                <label for="email">E-mail*</label>
	                <small class="form-text text-muted"></small>
	            </div>
	            
	            <div class="form-block">
	                <input v-if="data.agreement" class="height-inp but-inp" type="submit" value="Подписаться" @click.prevent="send">
	                <input v-else disabled class="height-inp but-inp disabled" type="submit" value="Подписаться"/>
	                <!-- <div
	                  v-if="success"
	                  class="subscribe-block__notify"
	                  id="success-subscribe"
	                >Ваша подписка успешно оформлена</div> -->
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
    send () {
      if (!this.submiting) {
        this.submiting = true
        this.success = false
        // this.errors = {}
        axios.post(`/api/frontend/subscriber/subscribe`, this.data)
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
                              text: 'Ваша подписка успешно оформлена'
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
