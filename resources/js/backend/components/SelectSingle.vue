<template>
  <div>
    <a-select
      show-search
      :value="field"
      :placeholder="placeholder ? placeholder : 'Выберите из списка'"
      style="width: 100%"
      :filter-option="filterOption"
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
                type: Object,
                default: null
            },
            data: {
                type: Array,
                default: () => ([])
            },
            placeholder: {
                type: String,
                default: NaN
            }
        },
        data() {
            return {
                valueCurrent: undefined
            };
        },
        computed: {
            field: function () {
                if (!this.valueCurrent && this.value && Object.keys(this.value).length !== 0) {
                    return this.value.id
                }
                return this.valueCurrent
            }
        },
        watch: {
            valueCurrent: function (val) {
                this.$emit('input', {'id': val})
            }
        },
        methods: {
            handleChange(value) {
                this.valueCurrent = value
            },
            filterOption(input, option) {
                return option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
            }

        },
    };
</script>
<style>
    .dynamic-delete-button {
        cursor: pointer;
        position: relative;
        font-size: 24px;
        color: #999;
        transition: all .3s;
    }

    .dynamic-delete-button:hover {
        color: #777;
    }

    .dynamic-delete-button[disabled] {
        cursor: not-allowed;
        opacity: 0.5;
    }
</style>
