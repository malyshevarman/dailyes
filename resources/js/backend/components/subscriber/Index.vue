<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Подписчики</h4>
        <div>
          <a
            class="btn btn-success"
            href="/admin/subscriber/create"
          >Добавить подписчика</a>
        </div>
      </div>
      <a-table
        :columns="columns"
        :data-source="data"
        :scroll="{ x: 1300 }"
        size="small"
        :pagination="false"
      >
        <a
          slot="action"
          slot-scope="text, record"
          :href="`/admin/subscriber/${record.id}/edit`"
        >
          <a-icon type="edit" />
        </a>
      </a-table>
      <br>
      <a-pagination
        v-model="filters.pagination.current_page"
        :style="{ float: 'right' }"
        :total="filters.pagination.total"
        :page-size-options="['25', '50', '100', '200']"
        show-size-changer
        :page-size.sync="filters.pagination.per_page"
        show-quick-jumper
        @change="changeCurrentPage"
        @showSizeChange="changeShowSizeChange"
      />
    </a-layout-content>
  </a-layout>
</template>
<script>
    const columns = [
        {title: 'ID', dataIndex: 'id', key: 'id'},
        {title: 'Email', dataIndex: 'email', key: 'email'},
        {
            key: 'operation',
            // fixed: 'right',
            width: 100,
            scopedSlots: {customRender: 'action'},
        },
    ];

    export default {
        data() {
            return {
                columns,
                data: [],
                filters: {
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
            // if (localStorage.getItem("filtersTableSubscribers")) {
            //     this.filters = JSON.parse(localStorage.getItem("filtersTableSubscribers"))
            // } else {
            //     localStorage.setItem("filtersTableSubscribers", this.filters);
            // }
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.data = []

                // localStorage.setItem("filtersTableSubscribers", JSON.stringify(this.filters));

                axios.post(`/api/backend/subscriber/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
        }
    }
</script>

<style scoped>

</style>
