<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Акции</h4>
        <div>
          <a
            class="btn btn-success"
            href="/admin/event/create"
          >Добавить акцию</a>
        </div>
      </div>
      <div class="col-7 col-md-4 mt-3">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
              <span
                      class="input-group-text"
                      @click="filter"
              >
                <i class="fas fa-search" />
              </span>
          </div>

          <input
                  v-model.trim="filters.search.text"
                  type="text"
                  class="form-control"
                  placeholder="Search"
                  @keyup.enter="filter"
                  style="margin-right:15px;"
          >

          <a-select :default-value="0" placeholder="Город" style="width: 120px" @change="citychange">
            <a-select-option :key="0" :value="0">Все</a-select-option>
            <a-select-option v-for="city in cityes" :key="city.id" :value="city.id">{{city.name}}</a-select-option>
          </a-select>
        </div>
      </div>
      <div style="display: flex;align-items: center;" v-for="status in statuses" :class="filters.status == status.name ? 'active' : ''">
        <span
          style="width: 30px;height: 30px;display: inline-block;cursor:pointer;border: 1px solid #a2a2a2"
          :class="status.class"
          @click="sortByStatus(status.name)">
        </span>
        &nbsp; - {{status.title}}
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
              slot="name"
              slot-scope="text, record"
          >
            <a v-if="record.published && record.active" target="_blank" :href="`/stocks/${record.slug}`">{{record.name}}</a>
            <template v-else>
              {{record.name}}
            </template>
          </div>
          <div
              slot="company"
              slot-scope="text, record"
          >
            <a v-if="record.company.published && record.company.active" target="_blank" :href="`/company/${record.company.slug}`">{{record.company.name}}</a>
            <template v-else>
              {{record.company.name}}
            </template>
          </div>

          <div
              slot="status"
              slot-scope="text, record"
          >
              <span class="published">{{(record.published) ? 'Опубликована':''}}</span>
              <span class="completed">{{(record.end < today) ? 'Завершена':''}}</span>
              <span class="moderation">{{(!record.rejected && !record.published) ? 'На модерации':''}}</span>
              <span class="rejected">{{(record.rejected) ? 'Отклонена':''}}</span>
              <span class="disabled">{{(!record.active) ? 'Неактивна':''}}</span>
          </div>
          <div
              slot="start"
              slot-scope="text, record"
          >
              {{formatDate(text)}}
          </div>

          <div
              slot="end"
              slot-scope="text, record"
          >
              {{formatDate(text)}}
          </div>
          <template  
              slot="action"
              slot-scope="text, record"
          >
              <a :href="`/admin/event/${record.slug}/edit`">
                  <a-icon type="edit" />
              </a>
              <a
                  @click.prevent="destroy(record.slug)"
                  href="#"
                  title="Удалить"
              >
                  <a-icon type="delete" />
              </a>
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
          width: 20,
        },
        {
          title: 'Название',
          dataIndex: 'name',
          key: 'name',
          width: 300,
          scopedSlots: {customRender: 'name'},
        },
        {
          title: 'Компания', 
          dataIndex: 'company.name', 
          key: 'company.name', 
          scopedSlots: {customRender: 'company'},
          width: 200
        },
        {
          title: 'Статус', 
          dataIndex: 'status', 
          key: 'status',
          scopedSlots: {customRender: 'status'},
          width: 200
        },
        {
          title: 'Дата начала', 
          dataIndex: 'start', 
          key: 'start',
          scopedSlots: {customRender: 'start'},
          width: 200
        },
        {
          title: 'Дата окончания', 
          dataIndex: 'end', 
          key: 'end',
          scopedSlots: {customRender: 'end'},
          width: 200
        },
        {
          key: 'operation',
          // fixed: 'right',
          width: 100,
          scopedSlots: {customRender: 'action'}
        },
    ];

    export default {
        data() {
            return {
                today:moment().format('YYYY-MM-DD'),
                columns,
                searchText: '',
                searchInput: null,
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
                      city: 0
                    },
                    status: '',
                },
                statuses: [
                  {
                    name: 'published',
                    class: 'published',
                    title: 'Опубликована'
                  },
                  {
                    name: 'rejected',
                    class: 'rejected',
                    title: 'Отклонена'
                  },
                  {
                      name: 'moderation',
                      class: 'moderation',
                      title: 'На модерации'
                  },
                  {
                      name: 'completed',
                      class: 'completed',
                      title: 'Завершена'
                  },
                  {
                    name: 'disabled',
                    class: 'disabled',
                    title: 'Неактивна'
                  },
                  {
                    name: 'all',
                    class: 'all',
                    title: 'Все'
                  }
                ],
            }
        },
        created(){
          axios.get('/api/backend/city/all')
              .then(response => (
                      this.cityes = response.data
              ))
        },
        mounted() {
            // if (localStorage.getItem("newnewfiltersTableEvents")) {
                // this.filters = JSON.parse(localStorage.getItem("newnewfiltersTableEvents"))
            // } else {
                // localStorage.setItem("newnewfiltersTableEvents", this.filters);
            // }
            this.fetchData()
        },
        methods: {
            formatDate(value){
                if (value !== null) {
                  return moment(value).format('DD.MM.YYYY')
                } else {
                  return 'бессрочная'
                }
            },
            sortByStatus(value) {
              value !== 'all' ? this.filters.status = value : this.filters.status = ''
              this.filters.pagination.current_page = 1
              this.fetchData()
            },
            citychange(value) {
              this.filters.search.city = value
              this.fetchData()
            },
            fetchData() {
                this.data = []

                // localStorage.setItem("newnewfiltersTableEvents", JSON.stringify(this.filters));

                axios.post(`/api/backend/event/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
            // rowClassName(record, index) {

            //     if (!record.rejected && !record.published) {
            //         return 'moderation'
            //     } else if (record.published) {
            //         return 'published'
            //     } else if (record.rejected) {
            //         return 'rejected'
            //     } else if (!record.active) {
            //         return 'disabled'
            //     } else if (record.status == 'after') {
            //       return 'completed'
            //     }
            // },
            filter() {
              this.filters.pagination.current_page = 1
              this.fetchData()
            },
            destroy(slug) {

                if (!this.loading) {
                    this.loading = true
                    const message = this.$message.loading('Удаление', 0)
                    swal({
                        title: "Вы уверены?",
                        text: "Это необратимый процесс!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                axios.delete('/api/backend/event/'+slug)
                                    .then(response => {
                                        this.fetchData()
                                    })
                                    .catch(error => {
                                        this.errors = error.response.data.errors
                                    })
                            }
                        })
                        .then(() => {
                            setTimeout(message, 0)
                            this.loading = false

                        })
                }

            },
        }
    }
</script>

<style >
    .published {
        background: #e6ffe6;
    }

    .rejected {
        background: #fce2e3;
    }

    .moderation {
        background: #cccccc;
    }

    .all {
      background: #fff;
    }

    .completed{
        background: rgba(0,0,255,0.3);
    }

    .disabled {
      background: #e9e93e;
    }


    .green:hover,
    .red:hover,
    .black:hover,
    .white:hover {
        border-color: #000!important;
    }

    .highlight {
        background-color: rgb(255, 192, 105);
        padding: 0px;
    }

    .active {
      font-weight: bold;
    }
</style>
