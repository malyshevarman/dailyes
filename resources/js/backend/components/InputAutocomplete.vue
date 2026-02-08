<template>
  <a-select
    show-search
    :value="field"
    placeholder="Вводите ID или название"
    style="width: 100%"
    :default-active-first-option="false"
    :show-arrow="false"
    :filter-option="false"
    :not-found-content="null"
    @search="handleSearch"
    @change="handleChange"
  >
    <a-select-option
      v-for="d in data"
      :key="d.slug"
    >
      {{ d.id }} - {{ d.name }}
    </a-select-option>
  </a-select>
</template>

<script>
    let timeout;
    let currentValue;

    function fetch(value, url, callback) {
        if (timeout) {
            clearTimeout(timeout);
            timeout = null;
        }
        currentValue = value;

        function fake() {
            axios({
                method: 'get',
                url: url + value
            }).then(response => {
                if (currentValue === value) {
                    callback(response.data);
                }
            });
        }

        timeout = setTimeout(fake, 400);
    }

    export default {
        props: {
            value: {
                type: Object,
                default: null
            },
            url: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                data: [],
                valueCurrent: undefined
            };
        },
        computed: {
            field: function () {
                if (!this.valueCurrent && Object.keys(this.value).length !== 0) {
                    return this.value.slug
                }
                return this.valueCurrent
            }
        },
        watch: {
            valueCurrent: function (val) {
                this.$emit('input', {'slug': val})
            },
            value: function (val) {
                if(!this.valueCurrent) {
                    this.data = [val]
                }
            }
        },
        methods: {
            handleChange(value) {
                this.valueCurrent = value

                fetch(value, this.url, data => {
                    this.data = data
                });
            },
            handleSearch(value) {
                fetch(value, this.url, data => this.data = data);
            }
        }
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
