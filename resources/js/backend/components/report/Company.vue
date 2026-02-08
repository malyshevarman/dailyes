<template>
    <a-layout :style="{ minHeight: '100%' }">
        <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
            <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
                <h4>Жалобы</h4>
            </div>
            <a-table
                    :columns="columns"
                    :data-source="data"
                    :pagination="false"
                    :scroll="{ x: 1300 }"
                    size="small"
            >
                <div
                    slot="reportable"
                    slot-scope="text, record"
                >
                    <a target="_blank" :href="`/company/${record.reportable.slug}`">{{record.reportable.name}}</a>
                </div>
            </a-table>
            <br>
            <a-pagination
                    :page-size-options="['25', '50', '100', '200']"
                    :page-size.sync="filters.pagination.per_page"
                    :style="{ float: 'right' }"
                    :total="filters.pagination.total"
                    @change="changeCurrentPage"
                    @showSizeChange="changeShowSizeChange"
                    show-quick-jumper
                    show-size-changer
                    v-model="filters.pagination.current_page"
            />
        </a-layout-content>
    </a-layout>
</template>
<script>
    const columns = [
        {title: 'ID', dataIndex: 'id', key: 'id'},
        {title: 'Автор', dataIndex: 'user.name', key: 'user.name'},
        {title: 'Название', dataIndex: 'reportable.name', key: 'reportable.name', scopedSlots: { customRender: 'reportable' },},
        {title: 'Текст', dataIndex: 'text', key: 'text'},
    ];

    export default {
        data() {
            return {
                columns,
                data: [],
                filters: {
                    type:'company',
                    pagination: {
                        from: 0,
                        to: 0,
                        total: 0,
                        per_page: 25,
                        current_page: 1,
                        last_page: 0
                    },
                    orderBy: {
                        column: 'id',
                        direction: 'asc'
                    },
                    search: ''
                },
            }
        },
        mounted() {
            // if (localStorage.getItem("filtersTableReports")) {
            //     this.filters = JSON.parse(localStorage.getItem("filtersTableReports"))
            // } else {
            //     localStorage.setItem("filtersTableReports", this.filters);
            // }
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.data = []

                // localStorage.setItem("filtersTableReports", JSON.stringify(this.filters));

                axios.post(`/api/backend/report/filter?page=${this.filters.pagination.current_page}`, this.filters)
                    .then(response => {
                        this.data = response.data.data
                        delete response.data.data
                        this.filters.pagination = response.data
                        this.loading = false
                    })
            },
            changeCurrentPage(currentPage) {
                this.filters.pagination.current_page = currentPage
                this.fetchData()
            },
            changeShowSizeChange(currentPage, perPage) {
                this.filters.pagination.current_page = currentPage
                this.filters.pagination.per_page = perPage
                this.fetchData()
            }
        },
    }
</script>

<style scoped>

</style>
