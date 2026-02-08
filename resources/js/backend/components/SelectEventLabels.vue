<template>
  <div>
    <a-select
      mode="multiple"
      :value="value.map(item => item.id)"
      placeholder="Выберите лейблы"
      style="width: 100%"
      @change="handleChange"
    >
      <a-select-option
        v-for="d in data"
        :key="d.id"
      >
        {{ d.name }}
      </a-select-option>
    </a-select>
  </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: Array,
                default: () => []
            }
        },
        data() {
            return {
                data: [],
            };
        },
        mounted() {
            this.fetch()
        },
        methods: {
            fetch() {
                axios.get(`/api/backend/event/label/all`)
                    .then(response => {
                        this.data = response.data
                    })
                    .catch(error => {})
                    .then(() => {})
            },
            handleChange(value) {
                this.$emit('input', this.data.filter(item => {
                    return value.indexOf(item.id) !== -1
                }))
            }

        },
    };
</script>

<style>

</style>
