<template>
  <a-layout :style="{ minHeight: '100%' }">
    <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '100%' }">
      <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
        <h4>Компании</h4>
        <div>
          <a
            class="btn btn-success"
            href="/admin/company/create"
          >Добавить компанию</a>
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
                  placeholder="Поиск"
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
            <a v-if="record.published && record.active" target="_blank" :href="`/company/${record.slug}`">{{record.name}}</a>
            <template v-else>
              {{record.name}}
            </template>
          </div>
          <div
              slot="status"
              slot-scope="text, record"
          >
              <span class="published">{{(record.published) ? 'Опубликована':''}}</span>
              <span class="moderation">{{(!record.rejected && !record.published) ? 'На модерации':''}}</span>
              <span class="rejected">{{(record.rejected) ? 'Отклонена':''}}</span>
              <span class="disabled">{{(!record.active) ? 'Неактивна':''}}</span>
          </div>
          <div
              slot="created_at"
              slot-scope="text, record"

          >
              {{formatDate(text)}}
          </div>
          <a
            slot="action"
            slot-scope="text, record"
            :href="`/admin/company/${record.slug}/edit`"
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
    import moment from 'moment';
  const columns = [
    {
      title: 'ID', 
      dataIndex: 'id', 
      key: 'id', 
      width: 20
    },
    {
      title: 'Название', 
      dataIndex: 'name', 
      key: 'name', 
      scopedSlots: {customRender: 'name'}, 
      width: 200
    },
    {
      title: 'Slug', 
      dataIndex: 'slug', 
      key: 'slug', 
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
      title: 'Дата создания', 
      dataIndex: 'created_at', 
      key: 'created_at',
      scopedSlots: {customRender: 'created_at'},
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
        searchname:'',
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
          },
          status: ''
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
      // if (localStorage.getItem("newnewfiltersTableCompanies")) {
        // this.filters = JSON.parse(localStorage.getItem("newnewfiltersTableCompanies"))
        // this.filters.search
      // } else {
        // localStorage.setItem("newnewfiltersTableCompanies", this.filters);
      // }
      this.fetchData()
    },
    methods: {
        formatDate(value){
            return moment(value).format('DD.MM.YYYY')
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
      filter(){
        this.filters.pagination.current_page = 1
        this.fetchData()
      },
      fetchData() {
        this.data = []

        // localStorage.setItem("newnewfiltersTableCompanies", JSON.stringify(this.filters));

        axios.post(`/api/backend/company/filter?page=${this.filters.pagination.current_page}`, this.filters)
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
      //       return 'disabled'
      //     }

      // }
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

  .disabled {
    background: #e9e93e;
  }

  .green:hover,
  .red:hover,
  .black:hover,
  .white:hover,
  .yellow {
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
