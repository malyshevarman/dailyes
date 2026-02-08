<template>
  <div
    class="events-block__badges-bookmark"
    :class="{'active': label}"
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
            company: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                label: this.status
            }
        },
        mounted() {},
        methods: {
            change() {
                this.label = !this.label
                axios.post(`/api/frontend/company/feature`, this.company)
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
