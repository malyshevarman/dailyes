<template>
    <div>
        <a-select
            showSearch
            mode="multiple"
            :ref="reference"
            :value="value.categories.map(item => item.id)"
            placeholder="Выберите категорию(и)"
            style="width: 100%"
            @change="handleChange"
            @focus="checkCatCount"
            notFoundContent="Удалите одну из двух категорий"
        >
            <a-select-option
                v-for="d in options"
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
                default: () => []
            }
        },
        data() {
            return {
                data: [],
                options: [],
                // optionselect: null,
                // valuelocal: null,
                reference: `${this.locationType}Select`
            };
        },
        computed: {},
        mounted() {

            this.fetch()
        },
        methods: {
            fetch() {
                axios.get(`/api/cabinet/category/all`)
                    .then(response => {
                        this.data = response.data
                        this.options = this.data
                    })
                    .catch(error => {
                    })
                    .then(() => {
                    })
            },
            // countrec() {
            //     this.valuelocal = this.value.length
            // },
            handleChange(value) {
                this.value.tags = []
                if (value.length>2) {
                    let valuez=value.slice(0)
                    valuez.splice(0, 1)
                    let categories = this.data.filter(item => {
                        return valuez.indexOf(item.id) !== -1
                    })
                    this.value.categories = categories
                    this.$emit('input', this.value)

                } else {
                    let categories = this.data.filter(item => {
                        return value.indexOf(item.id) !== -1
                    })
                    this.value.categories = categories
                    this.$emit('input', this.value)
                }
                this.$refs[this.reference].blur();
            },
            checkCatCount() {
                if (this.value.length == 2) {
                    this.options = []
                } else {
                    this.options = this.data
                }
            }
        },
    };
</script>
