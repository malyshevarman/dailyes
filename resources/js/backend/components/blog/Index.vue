<template>
    <a-layout :style="{ minHeight: '100%' }">
        <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
            <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
                <h4>Новости</h4>
                <div>
                  <a
                    class="btn btn-success"
                    href="/admin/article/create"
                  >Добавить новость</a>
                </div>
            </div>
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

                <template slot="company" slot-scope="name">
                    {{name}}
                </template>

                <div
                    slot="action"
                    slot-scope="text, record"
                >
                    <a
                      :href="`/admin/article/${record.slug}/edit`"
                    ><a-icon type="edit" /></a>
                    <a
                        href="#"
                        @click.prevent="destroy(record.slug)"
                    >
                        <a-icon type="delete"/>
                    </a>
                </div>
<!-- 
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
                </template> -->
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
        {title: 'Заголовок', dataIndex: 'title', key: 'title', width: 200},
        {title: 'Краткое Описание', dataIndex: 'description', key: 'text', width: 300},
        // {title: 'Компания', dataIndex: 'company', key: 'company'},
        {
            title: 'Опубликован',
            key: 'published',
            scopedSlots: {customRender: 'published'},
            width: 20
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
                searchText: '',
                searchInput: null,
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
        mounted() {
            // if (localStorage.getItem("newfiltersTableBanners")) {
                // this.filters = JSON.parse(localStorage.getItem("newfiltersTableBanners"))
              // } else {
                // localStorage.setItem("newfiltersTableBanners", this.filters);
              // }
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.data = []
                // localStorage.setItem("newfiltersTableBanners", JSON.stringify(this.filters));
                Vue.set(this.filters, 'typerewiews', this.typerewiews)
                axios.post(`/api/backend/article/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
            destroy(slug) {
                swal({
                    title: "Вы уверены?",
                    text: "Это необратимый процесс!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            axios.delete(`/api/backend/article/${slug}`)
                                .then(response => {
                                    location.reload()
                                })
                                .catch(error => {
                                    this.$message.error('Ошибка')
                                })
                        }
                    })
            },
            // toggle(id) {
            //     axios.post(`/api/backend/comment/${id}/toggle`)
            //         .then(response => {
            //             location.reload()
            //         })
            //         .catch(error => {
            //             this.$message.error('Ошибка')
            //         })
            // },
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
