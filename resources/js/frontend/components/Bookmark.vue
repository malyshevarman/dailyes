<template>
  <div
    title="Добавить в избранное"
    class="events-block__badges-bookmark"
    :class="{'active': label}"
    :data="data"
    @click="change()"
  />
</template>

<script>
    export default {
        props: {
            status: {
                type: Boolean,
                required: true
            },
            event: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                data: 1,
                label: this.status
            }
        },
        mounted() {},
        methods: {
            change() {
                if (!Laravel.user) {
                    $('.auth-panel').fadeToggle();
                    var loginW = $('.auth-panel__option-login').width() + 2;
                    var registerW = $('.auth-panel__option-register').width() + 2;
                    var forgotW = $('.auth-panel__option-forgot').width() + 2;

                    $('.auth-panel__option-full-login').width(loginW);
                    $('.auth-panel__option-full-register').width(registerW);
                    $('.auth-panel__option-full-forgot').width(forgotW);

                    if ($('.mobile__nav-fix').is(':visible')) {
                        $('.mobile__nav-fix').hide();
                    }

                    if (this.data == 1) {
                        $('body').css('overflow', 'hidden');
                    } else {
                        $('body').css('overflow', 'auto');
                    }
                    //location.replace(`/login`)
                }
                
                this.label = !this.label
                axios.post(`/api/frontend/event/feature`, this.event)
                    .then(response => {})
                    .catch(error => {
                        this.label = !this.label
                    })
            }
        }
    }
</script>

<style scoped>

</style>
