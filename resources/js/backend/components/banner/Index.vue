<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Баннеры</h4>
        <div>
          <a
            class="btn btn-success"
            href="/admin/banner/create"
          >Добавить баннер</a>
        </div>
      </div>

      <a-select :default-value="0" placeholder="Город" style="width: 120px" @change="citychange">
        <a-select-option :key="0" :value="0">Все</a-select-option>
        <a-select-option v-for="city in cityes" :key="city.id" :value="city.id">{{city.name}}</a-select-option>
      </a-select>

      <a-table
        :columns="columns"
        :data-source="data"
        :scroll="{ x: 1300 }"
        size="small"
        :pagination="false"
        rowKey="id" 
      >
        <a
          slot="action"
          slot-scope="text, record"
          :href="`/admin/banner/${record.id}/edit`"
        ><a-icon type="edit" /></a>

        <template slot="end" slot-scope="text, record">
          {{text | moment("D.M.YYYY")}}
        </template>

        <template slot="start" slot-scope="text, record">
          {{text | moment("D.M.YYYY")}}
        </template>

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
      dataIndex: 'place.name', 
      key: 'place.name',
      sorter: (a, b) => {
        if (a.place.name > b.place.name) {
          return 1;
        }
        if (a.place.name < b.place.name) {
          return -1;
        }
        // a должно быть равным b
        return 0;
      },
      sortDirections: ['descend', 'ascend'],
      width: 300
    },
    {
      title: 'Начало', 
      dataIndex: 'start', 
      key: 'start', 
      scopedSlots: {customRender: 'start'}, 
      sorter: (a, b) => new Date(a.start) - new Date(b.start),
      sortDirections: ['descend', 'ascend'],
      width: 200
    },
    {
      title: 'Окончание', 
      dataIndex: 'end', 
      key: 'end',      
      scopedSlots: {customRender: 'end'},
      sorter: (a, b) => new Date(a.end) - new Date(b.end),
      sortDirections: ['descend', 'ascend'],
      width: 200
    },
    {
      title: 'Город', 
      dataIndex: 'city.name', 
      key: 'city.name',
      sorter: (a, b) => {
        if (a.city.name > b.city.name) {
          return 1;
        }
        if (a.city.name < b.city.name) {
          return -1;
        }
        // a должно быть равным b
        return 0;
      },
      sortDirections: ['descend', 'ascend'],
      width: 200
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
        cityes:null,
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
            column: 'places.name',
            direction: 'asc'
          },
          search: {
            text: '',
            city: 0
          }
        },
      }
    },
    mounted() {
      // if (localStorage.getItem("filtersTableBanners")) {
        // this.filters = JSON.parse(localStorage.getItem("filtersTableBanners"))
      // } else {
        // localStorage.setItem("filtersTableBanners", this.filters);
      // }
      this.fetchData()
    },
    created(){
      axios.get('/api/backend/city/all')
          .then(response => (
            this.cityes = response.data
          ))
    },
    methods: {
      citychange(value) {
        this.filters.search.city = value
        this.fetchData()
      },
      fetchData() {
        this.data = []

        // localStorage.setItem("filtersTableBanners", JSON.stringify(this.filters));

        axios.post(`/api/backend/banner/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
