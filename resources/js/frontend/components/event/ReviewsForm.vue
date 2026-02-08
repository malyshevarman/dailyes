<template>
	<div class="onwrite-review">
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
              <div class="v-align">
                  <div class="onwrite-review__nav">
                          	<!-- <input v-if="event.user_rating" type="hidden" name="rating" :value="event.user_rating.star"> -->
                          	<template>
                          		<span>Поставьте оценку</span>
		                          <div class="onwrite-review__rating">
		                              <div class="onwrite-review__rating-wrap">
		                                  <input class="onwrite-review__rating-input" id="star-review-5"
		                                         type="radio"
		                                         name="rating" value="5" v-model="data.rating">
		                                  <label class="star-review__ico" for="star-review-5"
		                                         title="5 из 5 звёзд"></label>
		                                  <input class="onwrite-review__rating-input" id="star-review-4"
		                                         type="radio"
		                                         name="rating" value="4" v-model="data.rating">
		                                  <label class="star-review__ico" for="star-review-4"
		                                         title="4 из 5 звёзд"></label>
		                                  <input class="onwrite-review__rating-input" id="star-review-3"
		                                         type="radio"
		                                         name="rating" value="3" v-model="data.rating">
		                                  <label class="star-review__ico" for="star-review-3"
		                                         title="3 из 5 звёзд"></label>
		                                  <input class="onwrite-review__rating-input" id="star-review-2"
		                                         type="radio"
		                                         name="rating" value="2" v-model="data.rating">
		                                  <label class="star-review__ico" for="star-review-2"
		                                         title="2 из 5 звёзд"></label>
		                                  <input class="onwrite-review__rating-input" id="star-review-1"
		                                         type="radio"
		                                         name="rating" value="1" v-model="data.rating">
		                                  <label class="star-review__ico" for="star-review-1"
		                                         title="1 из 5 звёзд"></label>
		                              </div>
		                          </div>
                          	</template>
                      		<!-- <input v-if="event.user_recommendation" type="hidden" name="thumb"
                                 :value="event.user_recommendation.bool"> -->
						              <template>
                          	<span>Рекомендуете?</span>
	                          <div class="onwrite-review__blockmob">
	                              <input class="review__thumb-input up" id="thumb-review-2" type="radio"
	                                     name="thumb"
	                                     value="1" v-model="data.thumb">
	                              <label class="thumb-review__ico up" for="thumb-review-2"
	                                     title="Нравится"></label>
	                              <input class="review__thumb-input down" id="thumb-review-1" type="radio"
	                                     name="thumb" value="0" v-model="data.thumb">
	                              <label class="thumb-review__ico down" for="thumb-review-1"
	                                     title="Не нравится"></label>
	                          </div>
                          </template>
                  </div>
              </div>
              <textarea maxlength="400" id="review-text" name="review" placeholder="Напишите здесь отзыв" v-model="data.review"></textarea>
              <div class="v-align">
                  <div class="onwrite-review__button">
                      <button id="submit-review-form" :class="data.review == '' || data.rating == '' || data.thumb == '' ? 'disabled' : ''" type="submit" @click.prevent="data.review == '' ? false : submit()">Опубликовать</button>
                      <span class="closeReview">Отменить</span>
                  </div>
              </div>
          </form>
      </div>
</template>

<script>
    export default {
    	props: {
          event: {
            default: null,
            type: Object
          }, 
          user_rating: {
            default: null,
            type: Object
          },
          user_recommendation: {
            default: null,
            type: Object
          }
        },
        data() {
            return {
            	user: Laravel.user,
                loading: false,
                show: false,
                data: {
                	review: '',
                	thumb: '',
                	rating: ''
                }

            }
        },
        mounted() {
          if (this.user_rating !== null) {
            this.data.rating = this.user_rating.star
          }

          if (this.user_recommendation !== null) {
            this.data.thumb = this.user_recommendation.bool
          }
        },
        methods: {
            submit() {
            	axios.post(`/stocks/${this.event.slug}/review`, this.data)
            	.then(response => {
            		$('.closeReview').click()
            		this.data = {
            			review: '',
	                	thumb: '',
	                	rating: ''
            		}
            		this.$bus.$emit('showModal', {
            			title: 'Спасибо, что оставили свой отзыв',
            			text: 'После успешного прохождения модерации, ваш отзыв будет добавлен на сайт'
            		})
            	})
            	.catch(error => {

            	})
            }
        }
    };
</script>