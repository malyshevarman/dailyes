<template>
	<div id="review-answer-form" class="onwrite-review">
          <div class="v-align">
              <div class="onwrite-review__avatar">
                  <img src="/images/avatarblack.svg"/>
              </div>
              <div class="onwrite-review__title">
                  {{ user.name }}<br>
                  <span>Пользователь</span>
              </div>
          </div>
          <form>
              <textarea maxlength="400" id="review-answer-text" name="text" placeholder="Напишите здесь ответ" v-model="data.text"></textarea>
              <div class="v-align">
                  <div class="onwrite-review__button">
                      <button id="submit-review-answer-form" :class="data.text == '' ? 'disabled' : ''" type="submit" @click.prevent="data.text == '' ? false : submit()">Опубликовать</button>
                      <span class="closeReview">Отменить</span>
                  </div>
              </div>
          </form>
      </div>
</template>

<script>
    export default {
    	props: ['comment', 'company'],
        data() {
            return {
            	user: Laravel.user,
                loading: false,
                show: false,
                data: {
                	text: '',
                }

            }
        },
        mounted() {
        },
        methods: {
            submit() {
            	axios.post(`/company/${this.company.slug}/${this.comment.id}/review-answer`, this.data)
            	.then(response => {
            		$('#review-answer-form .closeReview').click()
            		this.data = {
            			text: '',
            		}
            		this.$bus.$emit('showModal', {
            			title: 'Спасибо, что оставили свой ответ на отзыв',
            			text: 'После успешного прохождения модерации, ваш ответ будет добавлен на сайт'
            		})
            	})
            	.catch(error => {

            	})
            }
        }
    };
</script>