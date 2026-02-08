<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Ответы на вопросы</h4>
      </div>
      <a-select placeholder="Город" style="width: 120px" @change="citychange">
        <a-select-option :key="0" :value="0">Все</a-select-option>
        <a-select-option v-for="city in cityes" :key="city.id" :value="city.name">{{city.name}}</a-select-option>
      </a-select>
      <a-table
        :columns="columns"
        :data-source="data"
        :scroll="{ x: 1300 }"
        size="small"
        :pagination="false"
        :rowKey="record => record.id"
      >
        <div
                slot="filterDropdown"
                slot-scope="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }"
                style="padding: 8px"
        >
        <a-input
                v-ant-ref="c => searchInput = c"
                placeholder="Введите имя автора"
                :value="selectedKeys[0]"
                @change="e => setSelectedKeys(e.target.value ? [e.target.value] : [])"
                @pressEnter="() => handleSearch(selectedKeys, confirm)"
                style="width: 188px; margin-bottom: 8px; display: block;"
        />
        <a-button
                type="primary"
                @click="() => handleSearch(selectedKeys, confirm)"
                icon="search"
                size="small"
                style="width: 90px; margin-right: 8px"
        >Поиск</a-button
        >
        <a-button @click="() => handleReset(clearFilters)" size="small" style="width: 90px"
        >очистить</a-button
        >
        </div>
        <a-icon
                slot="filterIcon"
                slot-scope="filtered"
                type="search"
                :style="{ color: filtered ? '#108ee9' : undefined }"
        />
        <div
          slot="published"
          slot-scope="text, record"
        >
          <a
            href="#"
            @click.prevent="toggle(record.id)"
          >
            <a-icon
              v-if="record.published"
              type="check-circle"
              style="margin-right: 15px;"
            />
            <a-icon
              v-else
              type="close-circle"
              style="margin-right: 15px;"
            />
          </a>
        </div>
        <div
          slot="action"
          slot-scope="text, record"
        >
          <a
            href="#"
            @click.prevent="destroy(record.id)"
          >
            <a-icon type="delete" />
          </a>
        </div>

        <template slot="customRender" slot-scope="text">
                  <span v-if="searchText">
                    <template
                            v-for="(fragment, i) in text.toString().split(new RegExp(`(?<=${searchText})|(?=${searchText})`, 'i'))"
                    >
                      <mark
                              v-if="fragment.toLowerCase() === searchText.toLowerCase()"
                              :key="i"
                              class="highlight"
                      >{{fragment}}</mark
                      >
                      <template v-else
                      >{{fragment}}</template
                      >
                    </template>
                  </span>
          <template v-else
          >{{text}}
          </template
          >
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
    {title: 'ID', dataIndex: 'id', key: 'id'},
    {
      title: 'Город',
      dataIndex: 'user.city',
      key: 'user.city',
      scopedSlots: {
        filterDropdown: 'filterDropdown',
        filterIcon: 'filterIcon',
        customRender: 'customRender',
      },
      onFilter: (value, record) => record.user.city.toString().toLowerCase().includes(value.toLowerCase()),
      onFilterDropdownVisibleChange: visible => {
        if (visible) {

        }
      },
      sorter: (a, b) => {
          if (a.user.city > b.user.city) {
            return 1;
          }
          if (a.user.city < b.user.city) {
            return -1;
          }
          // a должно быть равным b
          return 0;
      },
      sortDirections: ['descend', 'ascend'],
    },
    {
      title: 'Автор',
      dataIndex: 'user.name',
      key: 'user.name',
      scopedSlots: {
        filterDropdown: 'filterDropdown',
        filterIcon: 'filterIcon',
        customRender: 'customRender',
      },
      onFilter: (value, record) => record.user.name.toString().toLowerCase().includes(value.toLowerCase()),
      onFilterDropdownVisibleChange: visible => {
        if (visible) {

        }
      },
      sorter: (a, b) => {
          if (a.user.name > b.user.name) {
            return 1;
          }
          if (a.user.name < b.user.name) {
            return -1;
          }
          // a должно быть равным b
          return 0;
      },
      sortDirections: ['descend', 'ascend'],
    },
    {title: 'Текст', dataIndex: 'text', key: 'text'},
    {
      title: 'Опубликован',
      key: 'published',
      scopedSlots: {customRender: 'published'},
    },
    {
        title: 'Создан',
        dataIndex: 'created_at',
        key: 'created_at',
        scopedSlots: {customRender: 'created_at'},
        sorter: (a, b) => new Date(a.created_at) - new Date(b.created_at),
        sortDirections: ['descend', 'ascend'],
    },
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
                data: [],
              searchInput: null,
              searchText: '',
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
          axios.get('/api/backend/city/all')
              .then(response => this.cityes = response.data)
        },
        mounted() {
            // if (localStorage.getItem("newfiltersTableQuestionAnswers")) {
            //     this.filters = JSON.parse(localStorage.getItem("newfiltersTableQuestionAnswers"))
            // } else {
            //     localStorage.setItem("newfiltersTableQuestionAnswers", this.filters);
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

                // localStorage.setItem("newfiltersTableQuestionAnswers", JSON.stringify(this.filters));

                axios.post(`/api/backend/question/answer/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
            destroy(id) {
                swal({
                    title: "Вы уверены?",
                    text: "Это необратимый процесс!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            axios.delete(`/api/backend/question/answer/${id}`)
                                .then(response => {
                                    location.reload()
                                })
                                .catch(error => {
                                    this.$message.error('Ошибка')
                                })
                        }
                    })
            },
            toggle(id) {
                axios.post(`/api/backend/question/answer/${id}/toggle`)
                    .then(response => {
                        location.reload()
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
            },
            handleSearch(selectedKeys, confirm) {
                confirm();
                this.searchText = selectedKeys[0];

            },
            handleReset(clearFilters) {
                clearFilters();
                this.searchText = '';
            },
        },
    }
</script>

<style scoped>
  .highlight {
    background-color: rgb(255, 192, 105);
    padding: 0px;
  }
</style>
