<template>
  <div>
    <a-select
      mode="multiple"
      :value="value.categories.map(item => item.id)"
      placeholder="Выберите категории"
      style="width: 100%"
      @change="handleChange"
    >
      <a-select-option
        v-for="d in value.company.categories"
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
                type: Object,
                default: () => {}
            },
            // categories: {
            //     type: Array,
            //     default: () => []
            // }
        },
        data() {
            return {
                // data: [],
            };
        },
        mounted() {
            // this.fetch()
        },
        methods: {
            // fetch() {
            //     this.data = this.categories
            //     axios.get(`/api/backend/category/all`)
            //         .then(response => {
            //             this.data = response.data
            //         })
            //         .catch(error => {})
            //         .then(() => {})
            // },
            handleChange(value) {
                console.log('value', value)
                this.value.tags = []
                if (value.length>1) {
                    let valuez=value.slice(0)
                    valuez.splice(0, 1)
                    let categories = this.value.company.categories.filter(item => {
                        return valuez.indexOf(item.id) !== -1
                    })
                    console.log('categories1', categories)
                    this.value.categories = categories
                    this.$emit('input', this.value)
                } else {
                    let categories = this.value.company.categories.filter(item => {
                        return value.indexOf(item.id) !== -1
                    })
                    console.log('categories2', categories)
                    this.value.categories = categories
                    this.$emit('input', this.value)
                }
            }

        },
    };
</script>

<style>

</style>
