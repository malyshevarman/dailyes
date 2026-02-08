<template>
  <div
    v-if="!isHidden"
    class="top-block__city-option"
  >
    <div
      class="top-block__city-close"
      @click="isHidden = true"
    >
      <img
        class="close_button"
        src="/images/icons/close_city.svg"
      >
    </div>
    <div class="top-block__city-title">
      Ваш город <span>{{ nearCity.name }}</span>?
    </div>
    <div class="top-block__city-nav">
      <div>
        <button @click.prevent="setCitySlug()">
          Да
        </button>
      </div>
      <div
        class="cityPanel"
        @click="showCitySelectPanel()"
      >
        <span>Выбрать другой</span>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                nearCity: {},
                isHidden: true
            }
        },
        mounted() {
          this.checkCookie()
        },
        methods: {
            checkCookie() {
                var name = "citySlug"
                var citySlug = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)')
                citySlug = citySlug ? citySlug[2] : null

                if (!citySlug) {
                    axios.get(`/api/frontend/city/near`)
                        .then(response => {
                            this.nearCity = response.data
                            this.isHidden = false
                        })
                        .catch(error => {
                            this.$toasted.global.error('City does not exist!')
                        })
                }
            },
            setCitySlug() {
                var date = new Date();
                date.setTime(date.getTime() + (100 * 365 * 24 * 60 * 60 * 1000));
                document.cookie = `citySlug=${this.nearCity.slug}; expires=${date.toUTCString()}; path=/`

                location.href = `/${this.nearCity.slug}`
            },
            showCitySelectPanel() {
                this.$bus.$emit('showCitySelectPanel')
                this.isHidden = true
            }
        },
    }
</script>
