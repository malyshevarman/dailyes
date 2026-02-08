<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Категории акций</h4>
        <div>
          <a
            class="btn btn-success"
            href="/admin/event/category/create"
          >Добавить категорию</a>
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
          :href="`/admin/event/category/${record.slug}/edit`"
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
    {title: 'ID', dataIndex: 'id', key: 'id', width: 20},
    {
        title: 'Название', 
        dataIndex: 'name', 
        key: 'name',
        sorter: (a, b) => {
            if (a.name > b.name) {
                return 1;
            }
            if (a.name < b.name) {
                return -1;
            }
            // a должно быть равным b
            return 0;
        },
        sortDirections: ['descend', 'ascend'],
        width: 200
    },
    {title: 'Slug', dataIndex: 'slug', key: 'slug', width: 200},
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
      // if (localStorage.getItem("filtersTableEventCategories")) {
      //   this.filters = JSON.parse(localStorage.getItem("filtersTableEventCategories"))
      // } else {
      //   localStorage.setItem("filtersTableEventCategories", this.filters);
      // }
      this.fetchData()
    },
    methods: {
      fetchData() {
        this.data = []

        // localStorage.setItem("filtersTableEventCategories", JSON.stringify(this.filters));

        axios.post(`/api/backend/event/category/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
