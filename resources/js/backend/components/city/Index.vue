<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Города</h4>
        <div>
          <a
            class="btn btn-success"
            href="/admin/city/create"
          >Добавить город</a>
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
          :href="`/admin/city/${record.slug}/edit`"
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
        {
            title: 'ID', 
            width: 50, 
            dataIndex: 'id', 
            key: 'id', 
            fixed: 'left'
        },
        {
            title: 'Название', 
            width: 200, 
            dataIndex: 'name', 
            key: 'name', 
            fixed: 'left',
            sorter: (a, b) => {
                if (a.name[0] > b.name[0]) {
                  return 1;
                }
                if (a.name[0] < b.name[0]) {
                  return -1;
                }
                // a должно быть равным b
                return 0;
            },
            sortDirections: ['descend', 'ascend'],
        },
        {
            title: 'Slug', 
            dataIndex: 'slug', 
            key: 'slug'
        },
        {
            title: 'Кординаты', children: [
                {title: 'Lat', dataIndex: 'lat', key: 'lat'},
                {title: 'Long', dataIndex: 'long', key: 'long'}
            ]
        },
        {
            title: 'Таймзона', 
            dataIndex: 'timezone', 
            key: 'timezone'
        },
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
                        column: 'name',
                        direction: 'asc'
                    },
                    search: ''
                },
            }
        },
        mounted() {
            // if (localStorage.getItem("filtersTableCities")) {
            //     this.filters = JSON.parse(localStorage.getItem("filtersTableCities"))
            // } else {
            //     localStorage.setItem("filtersTableCities", this.filters);
            // }
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.data = []

                // localStorage.setItem("filtersTableCities", JSON.stringify(this.filters));

                axios.post(`/api/backend/city/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
