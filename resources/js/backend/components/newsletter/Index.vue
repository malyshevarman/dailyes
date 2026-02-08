<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Рассылки</h4>
        <div>
          <a
            class="btn btn-success"
            href="/admin/newsletter/create"
          >Добавить рассылку</a>
        </div>
      </div>
      <a-table
        :columns="columns"
        :data-source="data"
        :scroll="{ x: 1300 }"
        size="small"
        :pagination="false"
      >
        <a-switch
            slot="is_active"
            slot-scope="text, record"
            :checked="record.is_active"
            @change="toggleIsActive(record)"
        />

        <a
          slot="action"
          slot-scope="text, record"
          :href="`/admin/newsletter/${record.id}/edit`"
        ><a-icon type="edit" /></a>
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
        {title: 'Тема', dataIndex: 'subject', key: 'subject'},
        // {title: 'Текст', dataIndex: 'text', key: 'text'},
        {title: 'Город', dataIndex: 'city.name', key: 'city.name'},
        {title: 'Статус', dataIndex: 'is_active', key: 'is_active', scopedSlots: {customRender: 'is_active'},},
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
            // if (localStorage.getItem("filtersTablePages")) {
            //     this.filters = JSON.parse(localStorage.getItem("filtersTablePages"))
            // } else {
            //     localStorage.setItem("filtersTablePages", this.filters);
            // }
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.data = []

                // localStorage.setItem("filtersTablePages", JSON.stringify(this.filters));

                axios.post(`/api/backend/newsletter/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
            },
            toggleIsActive(item) {
                axios.put(`/api/backend/newsletter/${item.id}/toggle-is-active/`)
                .then(response => {
                    let found = this.data.find(item => item.id == response.data.id)

                    found.is_active = response.data.is_active
                })
            }
        }
    }
</script>

<style scoped>

</style>
