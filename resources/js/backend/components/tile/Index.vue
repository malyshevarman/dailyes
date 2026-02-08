<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Плитки</h4>
        <div>
          <a
            class="btn btn-success"
            href="/admin/tile/create"
          >Добавить плитку</a>
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
        :rowKey="record => record.id"
      >
        <a
          slot="action"
          slot-scope="text, record"
          :href="`/admin/tile/${record.id}/edit`"
        ><a-icon type="edit" /></a>

        <div slot="city" slot-scope="text, record">
                {{record.city == null ? 'Все' : record.city.name}}
        </div>
        
        <div
            slot="status"
            slot-scope="text, record"
        >
            <!-- {{(record.published) ? 'Опубликована':''}}
            {{(!record.rejected && !record.published) ? 'На модерации':''}}

            {{(record.rejected) ? 'Отклонена':''}}
            {{(!record.active) ? 'Неактивна':''}} -->
            <span class="event_expired">{{record.type == 'event-single' && record.events[0].end !==null && isBefore(record.events[0].end) ?
                                        'акция завершена':
                                        ''}}</span>

            <span class="tile_expired">{{record.end !==null && isBefore(record.end) ?
                                        'срок плитки завершен':
                                        ''}}</span>

            <span class="active">{{isAfter(record.end) ? 
                                moment(record.start) + ' - ' + moment(record.end):
                                ''}}</span>

            <span class="start_waiting">{{isAfter(record.start) ? 
                                        'не опубликована':
                                        ''}}</span>

            <span class="no_date">{{record.end == null ? 
                                    'бессрочная':
                                    ''}}</span>
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
    </a-layout-content>
  </a-layout>
</template>
<script>
    import moment from 'moment';

    const columns = [
        {title: 'ID', dataIndex: 'id', key: 'id', width: 20},
        {title: 'Название', dataIndex: 'name', key: 'name', width: 300},
        {title: 'Категория', dataIndex: 'category.name', key: 'category.name', width: 200},
        {title: 'Город', dataIndex: 'city.name', key: 'city.name', scopedSlots: {customRender: 'city'}, width: 200},
        {title: 'Статус', dataIndex: 'status', key: 'status',
          scopedSlots: {customRender: 'status'}, width: 200
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
                cityes:null,
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
                    search: {
                      text: '',
                      city: 0
                    }
                },
            }
        },
        created() {
            axios
                .get('/api/backend/city/all')
                .then(response => (
                    this.cityes = response.data,
                        this.selectcity = response.data[0].name
                ))
        },
        mounted() {
            // if (localStorage.getItem("newfiltersTableTiles")) {
            //     this.filters = JSON.parse(localStorage.getItem("newfiltersTableTiles"))
            // } else {
            //     localStorage.setItem("newfiltersTableTiles", this.filters);
            // }
            this.fetchData()
        },
        methods: {
            moment(date = null) {
                console.log(moment(date).format('DD.MM.YYYY'))
                if (date == null) {
                    return moment().format('DD.MM.YYYY')
                } else {
                    return moment(date).format('DD.MM.YYYY')
                }
            },
            isAfter(date) {
                return moment(date).isAfter(moment())
            },
            isBefore(date) {
                return moment(date).isBefore(moment())
            },
            citychange(value) {
              this.filters.search.city = value
              this.fetchData()
            },
            fetchData() {
                this.data = []

                // localStorage.setItem("newfiltersTableTiles", JSON.stringify(this.filters));

                axios.post(`/api/backend/tile/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
    .event_expired {
        color: orange;
    }
    .tile_expired {
        color: red;
    }
    .active {
        color: green;
    }
    .start_waiting {
        color: blue;
    }
    .no_date {
        color: grey;
    }
</style>
