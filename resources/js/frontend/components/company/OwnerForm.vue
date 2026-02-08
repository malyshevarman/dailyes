<template>
	<div style="margin-top: 45px;">
      <button v-if="!show" style="margin-top: 52px;" class="owner-panel__button call-form-verify-company-owner" @click.prevent="show = !show">Это моя компания</button>
      <form class="form-verify-company-owner" v-if="show">
          <input @input="clearMessage" class="form-control" type="text" placeholder="Введите e-mail" v-model="data.verification_email">
          <span class="owner-error-span">{{message}}</span>
          <a class="owner-panel__close-form"><img src="/images/icons/close.svg" @click.prevent="show = !show"/></a>
          <button class="owner-panel__button submit-form-verify-company-owner" :class="data.verification_email == '' ? 'disabled' : ''" type="submit" @click.prevent="data.verification_email == '' ? false : submit()">Подтвердить</button>
      </form>
  </div>
</template>

<script>
    export default {
      	props: {
          company: {
            default: null,
            type: Object
          },
        },
        data() {
            return {
            	user: Laravel.user,
                loading: false,
                show: false,
                data: {
                  verification_email: '',
                },
                message: ''

            }
        },
        mounted() {
        },
        methods: {
            submit() {
              $('.form-verify-company-owner input').css('border', 'none');
            	axios.post(`/api/frontend/company/${this.company.slug}/submit-owner `, this.data)
            	.then(response => {
            		this.data.verification_email = ''
            		this.$bus.$emit('showModal', {
            			// title: 'Спасибо, что оставили свой отзыв',
            			text: response.data.success
            		})
            	})
            	.catch(error => {
                $('.form-verify-company-owner input').css('border', '2px solid red');
                this.message = 'Неверный email'
            	})
            },
            clearMessage() {
              $('.form-verify-company-owner input').css('border', 'none');
              this.message = ''
            }
        }
    };
</script>