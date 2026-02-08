<template>
  <a-table
    :row-selection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
    :columns="columns"
    :data-source="all"
    :row-key="record => record.id"
    :locale="{ emptyText: 'для выбора адреса сначала укажите компанию' }"
    :pagination="false"
  >
  <template slot="footer" slot-scope="currentPageData">
    {{value ? 'Выберите адрес' : ''}}
  </template>
  </a-table>
</template>

<script>
    const columns = [
        // {title: 'ID', dataIndex: 'id', key: 'id'},
        {title: 'Город', dataIndex: 'city.name', key: 'city.name'},
        {title: 'Адрес', dataIndex: 'address', key: 'address'},
        // {title: 'График работы', dataIndex: 'work', key: 'work'},
        // {title: 'Сайт', dataIndex: 'site', key: 'site'}
    ];

    export default {
        props: {
            value: {
                type: Array,
                default: () => ([])
            },
            all: {
                type: Array,
                default: () => ([])
            }
        },
        data() {
            return {
                columns,
                errors: {},
                loading: false,
                alert: false
            }
        },
        computed: {
            hasSelected() {
                return this.selectedRowKeys.length > 0
            },
            selectedRowKeys: {
                get: function () {
                    return this.value.map(address => address.id)
                },
                set: function (val) {
                    this.$emit('input', this.all.filter(item => val.indexOf(item.id) !== -1))
                }
            }
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            }
        },
        methods: {
            onSelectChange (selectedRowKeys) {
                this.selectedRowKeys = selectedRowKeys
            }
        }
    }
</script>
<style type="text/css">
    .ant-table-footer {
        text-align: center;
    }
</style>
