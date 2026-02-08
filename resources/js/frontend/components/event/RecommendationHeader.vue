<template>
  <form :class="{'not-selected': selectedRecommendation}">
    <input
      id="thumb-rating-2"
      class="thumb-rating__input down"
      type="radio"
      name="rating"
      value="2"
      :checked="selectedRecommendation && selectedRecommendation === 0"
    >
    <label
      class="thumb-rating__ico down"
      for="thumb-rating-2"
      title="Не нравится"
      @click="click(0)"
    />
    <input
      id="thumb-rating-1"
      class="thumb-rating__input up"
      type="radio"
      name="rating"
      value="1"
      :checked="selectedRecommendation && selectedRecommendation === 1"
    >
    <label
      class="thumb-rating__ico up"
      for="thumb-rating-1"
      title="Нравится"
      @click="click(1)"
    />
  </form>
</template>

<script>
    let str = window.location.pathname
    let res = str.split("/")

    export default {
        props: {
            userRecommendation: {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                selectedRecommendation: null
            }
        },
        mounted() {
            if (this.userRecommendation) {
                this.selectedRecommendation = this.userRecommendation.bool
            }
        },
        computed: {
            // recommendation() {
            //     return this.selectedRecommendation
            // },
        },
        methods: {
            click(bool) {
                if (!Laravel.user) {
                   // location.replace(`/login`)
                    $('.mobile__nav-login .authPanel').click();
                    return;
                }
                // if (this.selectedRecommendation == null) {
                    this.selectedRecommendation = bool
                    axios.post(`/api/frontend/event/${res[2]}/recommendation`, {bool: bool})
                        .then(response => {
                          if (response.data == 'deleted') {
                            this.selectedRecommendation = null
                          }
                        })
                        .catch(error => {

                        })
                // }
            }
        }
    }
</script>

<style scoped>

</style>
