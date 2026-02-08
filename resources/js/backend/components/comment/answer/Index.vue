<template>
    <a-layout :style="{ minHeight: '100%' }">
        <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
            <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
                <h4>Ответы на отзывы</h4>
            </div>


            <a-select :default-value="0" placeholder="Город" style="width: 120px" @change="citychange">
                <a-select-option :key="0" :value="0">Все</a-select-option>
                <a-select-option v-for="city in cityes" :key="city.id" :value="city.name">{{city.name}}</a-select-option>
            </a-select>


            <a-select v-model="typerewiews" style="width: 120px" @change="changetype">
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
                    slot="company"
                    slot-scope="text, record"
                >
                    <a target="_blank" :href="`/company/${record.company.slug}`">{{record.company.name}}</a>
                </div>

                <div
                    slot="commented"
                    slot-scope="text, record"
                >
                    <a target="_blank" :href="`/company/${record.comment.commented.slug}`">{{record.comment.commented.name}}</a>
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
                <a-button @click="() => handleReset(clearFilters)" size="small" style="width: 90px">очистить</a-button>
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
                    <span class="published">{{record.published && !record.rejected && record.is_moderated ?
                                        'Опубликован':
                                        ''}}</span>

                    <span class="unpublished">{{!record.published && record.rejected && !record.is_moderated ?
                                                'Не опубликован':
                                                ''}}</span>

                    <span class="rejected">{{record.rejected ? 
                                        'Отклонен' :
                                        ''}}</span>

                    <span class="moderation_waiting">{{!record.is_moderated ? 
                                                'Ждет модерации':
                                                'Проверен'}}</span>
                    <span class="publish_waiting">{{record.is_moderated && !record.published && !record.rejected ? 
                                                'Ждет публикации':
                                                ''}}</span>
                </div>
                <div
                    slot="action"
                    slot-scope="text, record"
                >
                    <a
                        href="#"
                        @click.prevent="togglePublished(record.id)"
                        v-if="!record.published"
                    >
                        <a-tooltip>
                            <template slot="title">
                              Опубликовать
                            </template>
                            <a-icon type="play-circle" :style="{ color: '#1890ff' }" />
                        </a-tooltip>
                    </a>
                    <a
                        href="#"
                        @click.prevent="togglePublished(record.id)"
                        v-else
                    >
                        <a-tooltip>
                            <template slot="title">
                              Снять с публикации
                            </template>
                            <a-icon type="pause" :style="{ color: 'orange' }" />
                        </a-tooltip>
                    </a>
                    <a
                        href="#"
                        @click.prevent="record.message ? toggleRejected(record.id) : false"
                        v-if="!record.rejected"
                    >
                        <a-tooltip v-if="record.message">
                            <template slot="title">
                              Отклонить
                            </template>
                            <a-icon type="stop" :style="{ color: 'red' }" />
                        </a-tooltip>
                        <a-tooltip v-else>
                            <template slot="title">
                              Чтобы отклонить укажите причину
                            </template>
                            <a-icon type="stop" :style="{ color: 'grey' }" />
                        </a-tooltip>
                    </a>
                    <a
                        href="#"
                        @click.prevent="toggleRejected(record.id)"
                        v-else
                    >
                        <a-tooltip>
                            <template slot="title">
                              Одобрить
                            </template>
                            <a-icon type="check" :style="{ color: '#1890ff' }" />
                        </a-tooltip>
                    </a>
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
                    <a
                        href="#"
                        @click.prevent="destroy(record.id)"
                    >
                        <a-tooltip>
                            <template slot="title">
                              удалить запись
                            </template>
                            <a-icon type="delete"/>
                        </a-tooltip>
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
                            >{{fragment}}</mark>
                            <template v-else>{{fragment}}</template>
                        </template>
                    </span>
                    <template v-else>{{text}}</template>
                </template>
                <template slot="comment" slot-scope="text, record">
                    <editable-cell :text="text" @change="updateCommentText(record.id, 'text', $event)" />
                </template>

                <template slot="message" slot-scope="text, record">
                    <editable-cell :text="text" @change="updateCommentRejectionMessage(record.id, 'message', $event)" />
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
    import moment from 'moment';

    const columns = [
        {
            title: 'ID', 
            dataIndex: 'id', 
            key: 'id',
            width: 20
        },
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
                setTimeout(() => {
                  this.searchInput.focus();
                }, 0);
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
            width: 200
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
        {title: 'Текст', dataIndex: 'text', key: 'text', width: 200, scopedSlots: {customRender: 'comment'},},
        {
            title: 'Компания', 
            dataIndex: 'company.name', 
            key: 'company.id',
            sorter: (a, b) => {
                if (a.company.name > b.company.name) {
                  return 1;
                }
                if (a.company.name < b.company.name) {
                  return -1;
                }
                // a должно быть равным b
                return 0;
            },
            sortDirections: ['descend', 'ascend'],
            scopedSlots: {customRender: 'company'},
            width: 200
        },
        {
            title: 'Статус',
            key: 'published',
            scopedSlots: {customRender: 'published'},
            width: 20
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
            title: 'Причина отклонения', 
            dataIndex: 'message', 
            key: 'message',
            scopedSlots: {customRender: 'message'},
            width: 200
        },
        {
            key: 'operation',
            // fixed: 'right',
            width: 100,
            scopedSlots: {customRender: 'action'},
        },
    ];

    const columns2 = [
        {
            title: 'ID', 
            dataIndex: 'id', 
            key: 'id',
            width: 20
        },
        {
            title: 'Город',
            dataIndex: 'user.city',
            key: 'user.city',
            onFilter: (value, record) => record.user.city.toString().toLowerCase().includes(value.toLowerCase()),
            onFilterDropdownVisibleChange: visible => {
              if (visible) {
                setTimeout(() => {
                  this.searchInput.focus();
                }, 0);
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
            width: 200
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
            title: 'Текст', 
            dataIndex: 'text', 
            key: 'text',
            width: 200,
            scopedSlots: {customRender: 'comment'},
        },
        {
            title: 'Компания', 
            dataIndex: 'comment.commented.name', 
            key: 'comment.commented.id',
            sorter: (a, b) => {
                if (a.comment.commented.name > b.comment.commented.name) {
                  return 1;
                }
                if (a.comment.commented.name < b.comment.commented.name) {
                  return -1;
                }
                // a должно быть равным b
                return 0;
            },
            sortDirections: ['descend', 'ascend'],
            scopedSlots: {customRender: 'commented'},
            width: 200
        },
        {
            title: 'Статус',
            key: 'published',
            scopedSlots: {customRender: 'published'},
            width: 20
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
            title: 'Причина отклонения', 
            dataIndex: 'message', 
            key: 'message',
            scopedSlots: {customRender: 'message'},
            width: 200
        },
        {
            key: 'operation',
            // fixed: 'right',
            width: 100,
            scopedSlots: {customRender: 'action'},
        },
    ];
    const EditableCell = {
        template: `
        <div class="editable-cell">
            <div v-if="editable" class="editable-cell-input-wrapper">
                <a-input :value="value" @change="handleChange" @pressEnter="check" /><a-icon
                    type="check"
                    class="editable-cell-icon-check"
                    @click="check"
                    />
            </div>
            <div v-else class="editable-cell-text-wrapper">
                {{ value || ' ' }}
                <a-icon type="edit" class="editable-cell-icon" @click="edit" />
            </div>
        </div>
        `,
        props: {
            text: String,
        },
        data() {
            return {
                value: this.text,
                editable: false,
            };
        },
        methods: {
            handleChange(e) {
                const value = e.target.value;
                this.value = value;
            },
            check() {
                this.editable = false;
                this.$emit('change', this.value);
            },
            edit() {
                this.editable = true;
            },
        },
    };
    export default {
        components: {
            EditableCell,
        },
        data() {
            return {
                columns,
                data: [],
                typerewiews:'event',
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
                        city: 0
                    }
                },
            }
        },
        created(){
            axios.get('/api/backend/city/all')
                .then(response => (
                    this.cityes = response.data
                ))
        },
        mounted() {
            // if (localStorage.getItem("newfiltersTableCommentAnswers")) {
                // this.filters = JSON.parse(localStorage.getItem("newfiltersTableCommentAnswers"))
            // } else {
                // localStorage.setItem("newfiltersTableCommentAnswers", this.filters);
            // }
            this.fetchData()
        },
        methods: {
            updateCommentText(key, dataIndex, value) {
                console.log(key)
                axios.post(`/api/backend/comment/answer/${key}/update-text`, {text: value})
                    .then(response => {
                        const columns = [...this.columns];
                        const target = columns.find(item => item.key === key);
                        if (target) {
                            target[dataIndex] = value;
                            this.columns = columns;
                        }
                        this.fetchData()
                        this.$message.success('Сохранено')
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
            },
            updateCommentRejectionMessage(key, dataIndex, value) {
                console.log(key)
                axios.post(`/api/backend/comment/answer/${key}/update-message`, {message: value})
                    .then(response => {
                        const columns = [...this.columns];
                        const target = columns.find(item => item.key === key);
                        if (target) {
                            target[dataIndex] = value;
                            this.columns = columns;
                        }
                        this.fetchData()
                        this.$message.success('Сохранено')
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
            },
            moderate(id) {
                axios.get(`/api/backend/comment/answer/${id}/moderate`)
                    .then(response => {
                        this.fetchData()
                        this.$message.success('Сохранено')
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
            },
            moment(date) {
                return moment(date).format('DD.MM.YYYY')
            },
            citychange(value) {
                this.filters.search.city = value
                this.fetchData()
            },
            changetype(){
                if (this.typerewiews == 'event') {
                    this.columns = columns
                } else {
                    this.columns = columns2
                }

                this.fetchData()

            },
            fetchData() {
                this.data = []

                // localStorage.setItem("newfiltersTableCommentAnswers", JSON.stringify(this.filters));

                Vue.set(this.filters, 'typerewiews', this.typerewiews)

                axios.post(`/api/backend/comment/answer/filter?page=${this.filters.pagination.current_page}`, this.filters)
                    .then(response => {

                        console.log('data=',response.data.answers)
                        if (this.typerewiews == 'event') {


                            let arrr = response.data.events
                            this.data = response.data.answers.data
                            this.data.map((dat,index) => {
                                arrr.map(ar => {
                                    if (dat.comment.commented_id == ar.id) {
                                        dat.company = ar.company
                                    }
                                })
                            })

                            delete response.data.events
                            this.filters.pagination = response.data.answers
                            this.loading = false

                        } else {


                            this.data = response.data.data
                            delete response.data.data
                            this.filters.pagination = response.data
                            this.loading = false
                        }
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
                            axios.delete(`/api/backend/comment/answer/${id}`)
                                .then(response => {
                                    this.fetchData()
                                    this.$message.success('Сохранено')
                                })
                                .catch(error => {
                                    this.$message.error('Ошибка')
                                })
                        }
                    })
            },
            togglePublished(id) {
                axios.post(`/api/backend/comment/answer/${id}/toggle-published`)
                    .then(response => {
                        this.fetchData()
                        this.$message.success('Сохранено')
                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
            },
            toggleRejected(id) {
                axios.post(`/api/backend/comment/answer/${id}/toggle-rejected`)
                    .then(response => {
                        this.fetchData()
                        this.$message.success('Сохранено')
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
  .unpublished,
  .publish_waiting {
        color: orange;
    }
    .rejected {
        color: red;
    }
    .published {
        color: green;
    }
    .moderation_waiting {
        color: grey;
    }
</style>
<style>
.ant-table-tbody .moderating {
    background: #cccccc;
  }
.editable-cell {
  position: relative;
}

.editable-cell-input-wrapper,
.editable-cell-text-wrapper {
  padding-right: 24px;
}

.editable-cell-text-wrapper {
  padding: 5px 24px 5px 5px;
}

.editable-cell-icon,
.editable-cell-icon-check {
  position: absolute;
  right: 0;
  width: 20px;
  cursor: pointer;
}

.editable-cell-icon {
  line-height: 18px;
  /*display: none;*/
}

.editable-cell-icon-check {
  line-height: 28px;
}

.editable-cell:hover .editable-cell-icon {
  display: inline-block;
}

.editable-cell-icon:hover,
.editable-cell-icon-check:hover {
  color: #108ee9;
}

.editable-add-btn {
  margin-bottom: 8px;
}
</style>
