<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Сборки</h4>
        <div>
          <a
            class="btn btn-success"
            href="/admin/selection/create"
          >Добавить сборку</a>
        </div>
      </div>
      <a-select placeholder="Город" style="width: 120px" @change="citychange">
        <a-select-option :key="0" :value="0">Все</a-select-option>
        <a-select-option v-for="city in cityes" :key="city.id" :value="city.id">{{city.name}}</a-select-option>
      </a-select>
      <a-table
        :columns="columns"
        :data-source="data"
        :scroll="{ x: 1300 }"
        size="small"
        :pagination="false"
        :rowKey="record => record.id"
      >
        <a
          slot="action"
          slot-scope="text, record"
          :href="`/admin/selection/${record.id}/edit`"
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
        {title: 'Название', dataIndex: 'name', key: 'name'},
        {
            key: 'operation',
            fixed: 'right',
            width: 100,
            scopedSlots: {customRender: 'action'},
        },
    ];

    export default {
        data() {
            return {
                columns,
                cityes:null,
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
                    search: {
                      text: '',
                      city: ''
                    }
                },
            }
        },
        created(){
            axios
                .get('/api/backend/city/all')
                .then(response => (
                    this.cityes = response.data,
                        this.selectcity = response.data[0].name
                ))
        },
        mounted() {
            // if (localStorage.getItem("newfiltersTableSelections")) {
            //     this.filters = JSON.parse(localStorage.getItem("newfiltersTableSelections"))
            // } else {
            //     localStorage.setItem("newfiltersTableSelections", this.filters);
            // }
            this.fetchData()
        },
        methods: {
            citychange(value) {
              this.filters.search.city = value
              this.fetchData()
            },
            fetchData() {
                this.data = []

                // localStorage.setItem("newfiltersTableSelections", JSON.stringify(this.filters));

                axios.post(`/api/backend/selection/filter?page=${this.filters.pagination.current_page}`, this.filters)
                    .then(response => {
                        this.data = response.data.data
                        this.alldata = response.data.data
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
