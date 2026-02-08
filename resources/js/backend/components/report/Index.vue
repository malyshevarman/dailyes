<template>
    <a-layout :style="{ minHeight: '100%' }">
        <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
            <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
                <h4>Жалобы</h4>
            </div>
            <a-select :default-value="0" placeholder="Город" style="width: 120px" @change="citychange">
                <a-select-option :key="0" :value="0">Все</a-select-option>
                <a-select-option v-for="city in cityes" :key="city.id" :value="city.name">{{city.name}}</a-select-option>
            </a-select>


            <a-select v-model="filters.type" style="width: 120px" @change="changetype">
                <a-select-option value="event">Акции</a-select-option>
                <a-select-option value="company">Компании</a-select-option>
            </a-select>

            <a-table
                :columns="columns"
                :data-source="data"
                :scroll="{ x: 1300 }"
                size="small"
                :pagination="false"
                :rowKey="record => record.id"
                    :rowClassName="record => {
                        if (record.is_moderated) {
                            return ''
                        } else {
                            return 'moderating'
                        }
                    }"
            >
                <div
                    slot="reportable"
                    slot-scope="text, record"
                >
                    <a target="_blank" :href="`/stocks/${record.reportable.slug}`">{{record.reportable.name}}</a>
                </div>

                <div
                    slot="created_at"
                    slot-scope="text, record"
                >
                    {{moment(record.created_at)}}
                </div>
                
                <div
                    slot="filterDropdown"
                    slot-scope="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }"
                    style="padding: 8px"
                >
                    <a-input
                        v-ant-ref="c => searchInput = c"
                        :placeholder="`Search ${column.dataIndex}`"
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
                    >Поиск
                    </a-button
                    >
                    <a-button @click="() => handleReset(clearFilters)" size="small" style="width: 90px"
                    >Сброс
                    </a-button
                    >
                </div>
                <a-icon
                    slot="filterIcon"
                    slot-scope="filtered"
                    type="search"
                    :style="{ color: filtered ? '#108ee9' : undefined }"
                />





                <template slot="ttxt" slot-scope="text, record, index">
                    <div>

                        <a-tooltip placement="topLeft">
                            <template slot="title">
                                <span>{{text}}</span>
                            </template>
                            {{text | truncate(70, '...') }}
                        </a-tooltip>


                    </div>
                </template>

                <template slot="operation" slot-scope="text, record, index">
                    <div class="editable-row-operations">

                        <a-button :disabled="loading" type="primary" @click="showModal(record)">Ответить</a-button>

                    </div>
                </template>

                <template slot="customRender" slot-scope="text" >
                    <span v-if="searchText">
                        <template
                            v-for="(fragment, i) in text.toString().split(new RegExp(`(?<=${searchText})|(?=${searchText})`, 'i'))"
                        >
                            <mark
                                v-if="fragment.toLowerCase() === searchText.toLowerCase()"
                                :key="i"
                                class="highlight"
                            >{{fragment}}</mark>
                            <template v-else>{{fragment}}</template>
                        </template>
                    </span>
                    <template v-else
                    >{{text}}
                    </template
                    >
                </template>

                <div
                    slot="action"
                    slot-scope="text, record"
                >
                    <a
                        href="#"
                        @click.prevent="moderate(record.id)"
                        v-if="!record.is_moderated"
                    >
                        <a-tooltip>
                            <template slot="title">
                              отметить проверку записи
                            </template>
                            <a-icon type="warning" :style="{ color: 'red' }"/>
                        </a-tooltip>
                    </a>
                    <a-tooltip v-else>
                        <template slot="title">
                          проверено
                        </template>
                        <a-icon type="check" :style="{ color: '#1890ff' }" />
                    </a-tooltip>
                </div>
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
            <a-modal v-if="Object.keys(reportForAnswer).length > 0" :title="'Ответ для '+reportForAnswer.id+' '+reportForAnswer.user.name" v-model="visible" @ok="handleOk(reportForAnswer)">


                            <a-textarea
                                v-model="answerText"
                                placeholder="Введите ответ"
                                :autosize="{ minRows: 2, maxRows: 6 }"
                            />

                        </a-modal>
        </a-layout-content>
    </a-layout>
</template>
<script>
    import moment from 'moment';

    const columns = [
        {title: 'ID', dataIndex: 'id', key: 'id',width: 20},
        {
            title: 'Автор', 
            dataIndex: 'user.name', 
            key: 'user.name',
            onFilter: (value, record) => record.user.name.toString().toLowerCase().includes(value.toLowerCase()),
            onFilterDropdownVisibleChange: visible => {
              if (visible) {
                setTimeout(() => {
                  this.searchInput.focus();
                }, 0);
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
            width: 200
        },
        {
            title: 'Название', 
            dataIndex: 'reportable.name', 
            key: 'reportable.name',
            scopedSlots: {
                filterDropdown: 'filterDropdown',
                filterIcon: 'filterIcon',
                customRender: 'customRender',
            },
            onFilter: (value, record) => record.reportable.name.toString().toLowerCase().includes(value.toLowerCase()),
            onFilterDropdownVisibleChange: visible => {
                if (visible) {

                }
            },
            sorter: (a, b) => {
                if (a.reportable.name > b.reportable.name) {
                  return 1;
                }
                if (a.reportable.name < b.reportable.name) {
                  return -1;
                }
                // a должно быть равным b
                return 0;
            },
            sortDirections: ['descend', 'ascend'],
            scopedSlots: { customRender: 'reportable' },
            width: 200
        },
        {title: 'Текст', dataIndex: 'text', key: 'text', scopedSlots: { customRender: 'ttxt' },width: 200},
        {    title: 'Ответить',
            dataIndex: 'operation',
            scopedSlots: { customRender: 'operation' },
            width: 200
        },
        {
            title: 'Создан',
            dataIndex: 'created_at',
            key: 'created_at',
            scopedSlots: {customRender: 'created_at'},
            sorter: (a, b) => new Date(a.created_at) - new Date(b.created_at),
            sortDirections: ['descend', 'ascend'],
            width: 200
        },
        {
            dataIndex: 'action',
            scopedSlots: { customRender: 'action' },
            width: 200
        },
    ];
    const columns2 = [
        {title: 'ID', dataIndex: 'id', key: 'id',width: 20},
        {title: 'Автор', dataIndex: 'user.name', key: 'user.name',width: 200},
        {title: 'Название', dataIndex: 'reportable.name', key: 'reportable.name', scopedSlots: { customRender: 'reportable' },width: 200},
        {title: 'Текст', dataIndex: 'text', key: 'text', width: 200},
        {    title: 'Ответить',
            dataIndex: 'operation',
            scopedSlots: { customRender: 'operation' },
            width: 200
        },
        {
            title: 'Создан',
            dataIndex: 'created_at',
            key: 'created_at',
            scopedSlots: {customRender: 'created_at'},
            sorter: (a, b) => new Date(a.created_at) - new Date(b.created_at),
            sortDirections: ['descend', 'ascend'],
            width: 200
        },
        {
            dataIndex: 'action',
            scopedSlots: { customRender: 'action' },
            width: 200
        },
    ];
    export default {
        data() {
            return {
                // typerewiews:'event',
                columns,
                answerText:'',
                visible:false,
                data: [],
                cityes:null,
                filters: {
                    type: 'event',
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
                        city: 0
                    }
                },
                loading: false,
                reportForAnswer: {}
            }
        },
        created(){
            axios.get('/api/backend/city/all')
                .then(response => (
                    this.cityes = response.data
                ))
        },
        mounted() {
            // if (localStorage.getItem("filtersTableReports")) {
            //     this.filters = JSON.parse(localStorage.getItem("filtersTableReports"))
            // } else {
            //     localStorage.setItem("filtersTableReports", this.filters);
            // }
            this.fetchData()
        },
        filters: {
            truncate: function (text, length, suffix) {
                text.length > length ? suffix : suffix = ''
                return text.substring(0, length) + suffix;
            },
        },
        methods: {
            moment(date) {
                return moment(date).format('DD.MM.YYYY')
            },
            citychange(value) {
                this.filters.search.city = value
                this.fetchData()
            },
            changetype(){
                if (this.filters.type == 'event') {
                    this.columns = columns
                } else {
                    this.columns = columns2
                }

              this.fetchData()

            },
            showModal(record) {
                this.reportForAnswer = record
                this.visible = true;
            },
            handleOk(reportForAnswer) {

                if (this.answerText !=''){
                    if (!this.loading) {
                        this.loading = true
                        const message = this.$message.loading('Загрузка данных', 0)
                        axios.post(`/api/backend/report/${reportForAnswer.id}/answer`, {text:this.answerText})
                            .then(response => {
                                this.answerText = ''
                                this.$message.success('Сохранено')
                            })
                            .catch(error => {
                                this.$message.error('Ошибка')
                            })
                            .then(() => {
                                setTimeout(message, 0)
                                this.loading = false
                            })
                    }
                }

                this.visible = false;
            },
            handleSearch(selectedKeys, confirm) {
                confirm();
                this.searchText = selectedKeys[0];
            },

            handleReset(clearFilters) {
                clearFilters();
                this.searchText = '';
            },
            fetchData() {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)
                    this.data = []

                    // localStorage.setItem("filtersTableReports", JSON.stringify(this.filters));
                    // if (this.$router.app._route.path == '/admin/report/company') {
                    //     this.filters.type = "company"
                    // }
                    // Vue.set(this.filters, 'typerewiews', this.typerewiews)
                    axios.post(`/api/backend/report/filter?page=${this.filters.pagination.current_page}`, this.filters)
                        .then(response => {
                            this.data = response.data.data
                            delete response.data.data
                            this.filters.pagination = response.data
                            this.$message.success('Сохранено')
                        })
                        .catch(error => {
                            this.$message.error('Ошибка')
                        })
                        .then(() => {
                            setTimeout(message, 0)
                            this.loading = false
                        })
                }

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
            moderate(id) {
                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Загрузка данных', 0)

                    // localStorage.setItem("filtersTableReports", JSON.stringify(this.filters));
                    // if (this.$router.app._route.path == '/admin/report/company') {
                    //     this.filters.type = "company"
                    // }
                    // Vue.set(this.filters, 'typerewiews', this.typerewiews)
                axios.get(`/api/backend/report/${id}/moderate`)
                    .then(response => {
                        this.fetchData()
                        this.$message.success('Сохранено')
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
                    .then(() => {
                        setTimeout(message, 0)
                        this.loading = false
                    })
                }
            },
        },
    }
</script>

<style>
.ant-table-tbody .moderating {
    background: #cccccc;
  }
</style>
