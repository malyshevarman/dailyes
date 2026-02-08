<template>
  <div
    v-if="show"
    class="cookie"
  >
    <div class="cookie__title">
      Мы используем файлы Cookie
    </div>
    <div class="cookie__text">
      Потому что экономить ваше время и пользоваться вам жизнь
    </div>
    <button
      class="cookie__close"
      type="button"
      aria-label="Закрыть"
      @click.prevent="setCookie"
    >
      ✕
    </button>
  </div>
</template>

<script>
    export default {
        name: "Coockie",
        data: () => ({
            show: false,
        }),
        mounted() {
            this.checkCookies();
        },
        methods: {
            setCookie() {
                document.cookie = "usescookie=true;max-age="+60 * 60 * 24 * 1;
                this.checkCookies()

            },
            getCookie(name) {
                var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
                return matches ? decodeURIComponent(matches[1]) : undefined;
            },
            checkCookies() {
                if (!this.getCookie('usescookie')) {
                    this.show = true
                } else {
                    this.show = false
                }
            }
        }
    }
</script>
