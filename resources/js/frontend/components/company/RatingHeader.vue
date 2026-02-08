<template>
  <form :class="{'not-selected': notSelected}">
    <template
      v-for="index in stars"
    >
      <input
        :id="`star-rating-${index}`"
        class="star-rating__input"
        type="radio"
        name="rating"
        :value="index"
        :checked="index === selectedStar"
      >
      <label
        class="star-rating__ico"
        :for="`star-rating-${index}`"
        :title="`${index} из 5 звёзд`"
        @click="click(index)"
      />
    </template>
  </form>
</template>

<script>
    let str = window.location.pathname
    let res = str.split("/")

    export default {
        props: {
            userRating: {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                stars: [5, 4, 3, 2, 1],
                selectedStar: null
            }
        },
        mounted() {
            if (this.userRating) {
                this.selectedStar = this.userRating.star
            }
        },
        computed: {
            // star() {
            //     return this.selectedStar ? this.selectedStar : this.userRating ? this.userRating.star : null
            // },
            notSelected() {
                return !this.selectedStar
            }
        },
        methods: {
            click(index) {
                if (!Laravel.user) {
                   // location.replace(`/login`)
                    $('.mobile__nav-login .authPanel').click();
                }
                // if (!this.selectedStar) {
                    this.selectedStar = index
                    axios.post(`/api/frontend/company/${res[2]}/rating`, {star: index})
                        .then(response => {
                            if (response.data == 'deleted') {
                                this.selectedStar = null
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
