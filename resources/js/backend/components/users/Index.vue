<template>
  <div class="container">
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">
        Пользователи
      </h4>
      <div class="card-header-actions mr-1">
        <a
          class="btn btn-success"
          href="/admin/users/create"
        >Новый пользователь</a>
      </div>
    </div>
    <div class="card-body px-0">
      <div class="row justify-content-between">
        <div class="col-7 col-md-5">
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

            <a-select placeholder="Город" style="width: 120px;margin-right: 15px;" @change="citychange">
              <a-select-option :key="0" :value="0">Все</a-select-option>
              <a-select-option v-for="city in cities" :key="city.id" :value="city.name">{{city.name}}</a-select-option>
            </a-select>
            <a-select placeholder="Роль" style="width: 120px;margin-right: 15px;" @change="rolechange">
              <a-select-option :key="0" :value="0">Все</a-select-option>
              <a-select-option v-for="role in roles" :key="role.id" :value="role.name">{{role.name}}</a-select-option>
            </a-select>
          </div>
        </div>
        <div class="col-auto">
          <multiselect
            v-model="filters.pagination.per_page"
            :options="[25,50,100,200]"
            :searchable="false"
            :show-labels="false"
            :allow-empty="false"
            placeholder="Поиск"
            @select="changeSize"
          />
        </div>
      </div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="d-none d-sm-table-cell">
              <a
                href="#"
                class="text-dark"
                @click.prevent="sort('id')"
              >ID</a>
              <i
                class="mr-1 fas"
                :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'id' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'id' && filters.orderBy.direction == 'desc'}"
              />
            </th>
            <th>
              <a
                href="#"
                class="text-dark"
                @click.prevent="sort('name')"
              >Пользователь</a>
              <i
                class="mr-1 fas"
                :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'name' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'name' && filters.orderBy.direction == 'desc'}"
              />
            </th>
            <th>Город</th>
            <th>Роли</th>
            <th>Компания</th>
            <th class="d-none d-sm-table-cell">
              <a
                href="#"
                class="text-dark"
                @click.prevent="sort('created_at')"
              >Зарегистрирован</a>
              <i
                class="mr-1 fas"
                :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'desc'}"
              />
            </th>
            <th class="d-none d-sm-table-cell" />
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in users"
          >
            <td class="d-none d-sm-table-cell">
              {{ user.id }}
            </td>
            <td>
              <div class="media">
                <div class="avatar float-left mr-3">
                  <img
                    class="img-avatar"
                    :src="user.avatar_url"
                  >
                  <span class="avatar-status badge-success" />
                </div>
                <div class="media-body">
                  <div>{{ user.name }}</div>
                  <div class="small text-muted">
                    {{ user.email }}
                  </div>
                </div>
              </div>
            </td>
            <td>
              {{user.city}}
            </td>
            <td>
              <span v-for="(role, index) in user.roles">
                {{ role.name }}<span v-if="index+1 < user.roles.length">, </span>
              </span>
            </td>
            <td class="d-none d-sm-table-cell">
              <template v-if="user.companies.length > 0 && user.roles.find(r => r.name === 'admin') == undefined">
                <a target="_blank" v-if="user.companies[0].active && user.companies[0].published && !user.companies[0].rejected" :href="`/company/${user.companies[0].slug}`"><template>{{ user.companies[0].name }}</template></a>
                <template v-else>{{ user.companies[0].name}}</template>
              </template>
            </td>
            <td class="d-none d-sm-table-cell">
              <small>{{ user.created_at | moment("LL") }}</small> - <small class="text-muted">{{ user.created_at | moment("LT") }}</small>
            </td>
            <td class="d-none d-sm-table-cell">
              <a
                href="#"
                class="text-muted"
                @click.prevent="editUser(user.id)"
              ><i class="fas fa-pencil-alt" /></a>
            </td>
          </tr>
        </tbody>
      </table>
      <div
        v-if="!loading && filters.pagination.total > 0"
        class="row"
      >
        <div class="col pt-2">
          {{ filters.pagination.from }}-{{ filters.pagination.to }} of {{ filters.pagination.total }}
        </div>
        <div
          v-if="filters.pagination.last_page>1"
          class="col"
        >
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
              <li
                class="page-item"
                :class="{'disabled': filters.pagination.current_page <= 1}"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="changePage(filters.pagination.current_page - 1)"
                ><i class="fas fa-angle-left" /></a>
              </li>
              <li
                v-for="page in filters.pagination.last_page"
                class="page-item"
                :class="{'active': filters.pagination.current_page == page}"
              >
                <span
                  v-if="filters.pagination.current_page == page"
                  class="page-link"
                >{{ page }}</span>
                <a
                  v-else
                  class="page-link"
                  href="#"
                  @click.prevent="changePage(page)"
                >{{ page }}</a>
              </li>
              <li
                class="page-item"
                :class="{'disabled': filters.pagination.current_page >= filters.pagination.last_page}"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="changePage(filters.pagination.current_page + 1)"
                ><i class="fas fa-angle-right" /></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div
        v-if="!loading && !users.length > 0"
        class="no-items-found text-center mt-5"
      >
        <i class="icon-magnifier fa-3x text-muted" />
        <p class="mb-0 mt-3">
          <strong>Пользователи не найдены</strong>
        </p>
        <p class="text-muted">
          Попробуйте применить фильтры или создать нового пользователя
        </p>
        <a
          class="btn btn-success"
          href="/admin/users/create"
          role="button"
        >
          <i class="fa fa-plus" />&nbsp; Новый пользователь
        </a>
      </div>
      <content-placeholders v-if="loading">
        <content-placeholders-text />
      </content-placeholders>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      users: [],
      cities:null,
      roles: null,
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
          city: '',
          role: ''
        }
      },
      loading: true
    }
  },
  mounted () {
    // if (localStorage.getItem("newfiltersTableUsers")) {
    //   this.filters = JSON.parse(localStorage.getItem("newfiltersTableUsers"))
    // } else {
    //   localStorage.setItem("newfiltersTableUsers", this.filters);
    // }
    this.getUsers()
  },
  created(){
    axios.get('/api/backend/city/all')
        .then(response => (
          this.cities = response.data
        ))
    axios.get('/api/roles/all')
        .then(response => (
          this.roles = response.data
        ))
  },
  methods: {
    citychange(value) {
      this.filters.search.city = value
      this.getUsers()
    },
    rolechange(value) {
      this.filters.search.role = value
      this.getUsers()
    },
    getUsers () {
      this.loading = true
      this.users = []

      // localStorage.setItem("newfiltersTableUsers", JSON.stringify(this.filters));

      axios.post(`/api/users/filter?page=${this.filters.pagination.current_page}`, this.filters)
      .then(response => {
        this.users = response.data.data
        delete response.data.data
        this.filters.pagination = response.data
        this.loading = false
      })
    },
    editUser (userId) {
      location.href = `/admin/users/${userId}/edit`
    },
    // filters
    filter() {
      this.filters.pagination.current_page = 1
      this.getUsers()
    },
    changeSize (perPage) {
      this.filters.pagination.current_page = 1
      this.filters.pagination.per_page = perPage
      this.getUsers()
    },
    sort (column) {
      if(column == this.filters.orderBy.column) {
        this.filters.orderBy.direction = this.filters.orderBy.direction == 'asc' ? 'desc' : 'asc'
      } else {
        this.filters.orderBy.column = column
        this.filters.orderBy.direction = 'asc'
      }

      this.getUsers()
    },
    changePage (page) {
      this.filters.pagination.current_page = page
      this.getUsers()
    }
  }
}
</script>
