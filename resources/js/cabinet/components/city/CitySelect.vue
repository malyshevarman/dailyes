<template>
  <transition name="fade">
    <div
      v-if="!isHidden"
      class="city-panel"
    >
      <a
        class="auth-panel__close cityPanel"
        @click.prevent="hideCitySelectPanel()"
      ><img
        src="/images/icons/close.svg"
      ></a>
      <div class="container-fluid mob-top">
        <div class="city-mv">
          Ваш город <span><a
            href="#"
            @click.prevent="setCitySlug(nearCity.slug)"
          >{{ nearCity.name }}</a></span>?
          <div class="mob-top__form">
            <div class="mob-top__form-block">
              <input
                v-model="search"
                placeholder="Название вашего города"
                type="text"
              >
            </div>
            <button @click.prevent="">
              <img src="/images/icons/glass-blue.svg">
            </button>
          </div>
        </div>
      </div>
      <div class="container mw">
        <div class="row city-mh">
          <div class="col-md-12">
            <div class="city-panel__title">
              Мы определили ваш город как <span><a
                href="#"
                @click.prevent="setCitySlug(nearCity.slug)"
              >{{ nearCity.name }}</a></span>
              <br>Если это не так, выберите другой город из списка или воспользуйтесь поиском.
            </div>
          </div>
          <div class="col-md-12">
            <form>
              <input
                v-model="search"
                placeholder="Название вашего города"
                type="text"
              >
              <button
                type="submit"
                @click.prevent=""
              >
                <img src="/images/icons/glass-blue.svg">
              </button>
            </form>
          </div>
        </div>
        <div class="city-panel__list">
          <div class="row">
            <div
              v-for="(cities, letter) in selectedCities"
              class="col-lg-five col-lg-3 col-md-3 col-sm-4 col-12 group_city"
            >
              <span class="city-theme">{{ letter }}</span>
              <ul>
                <li
                  v-for="city in cities"
                  class="all-city"
                >
                  <a
                    href="#"
                    @click.prevent="setCitySlug(city.slug)"
                  >{{ city.name }}</a>
                </li>
              </ul>
            </div>
            <div
              v-if="Object.keys(selectedCities).length === 0"
              class="col-md-12 city-panel__not"
            >
              Такой город не найден!
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
    export default {
        data() {
            return {
                nearCity: {},
                search: '',
                cities: [],
                isHidden: true
            }
        },

        computed: {
            selectedCities: function () {
                return this.cities.filter((city) => {
                    return city.name.toUpperCase().indexOf(this.search.toUpperCase()) !== -1;
                }).sort(function (a, b) {
                    return a.name > b.name ? 1 : -1;
                }).reduce(function (res, a, index, arr) {
                    var letter = a.name[0];

                    if (!res.hasOwnProperty(letter)) {
                        res[letter] = [];
                    }
                    res[letter].push(a);

                    return res;
                }, {})
            }
        },
        mounted() {
            this.$bus.$on('showCitySelectPanel', () => {
                this.getNearCity()
                this.fetchCities()
                this.showCitySelectPanel()
            });
        },
        methods: {
            getNearCity() {
                axios.get(`/api/frontend/city/near`)
                    .then(response => {
                        this.nearCity = response.data
                    })
                    .catch(error => {
                        this.$toasted.global.error('City does not exist!')
                    })
            },
            setCitySlug(slug) {
                var date = new Date();
                date.setTime(date.getTime() + (100 * 365 * 24 * 60 * 60 * 1000));
                document.cookie = `citySlug=${slug}; expires=${date.toUTCString()}; path=/`

                location.href = `/${slug}`
            },
            fetchCities() {
                this.cities = []

                axios.post(`/api/frontend/city/all`)
                    .then(response => {
                        this.cities = response.data
                        delete response.data
                    })
            },
            showCitySelectPanel() {
                this.isHidden = false
                document.body.style = "overflow: hidden;"
            },
            hideCitySelectPanel() {
                this.isHidden = true
                document.body.style = "overflow: auto;"
            }
        },
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .4s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

    .city-panel__not {
      display: block;
    }
</style>​
