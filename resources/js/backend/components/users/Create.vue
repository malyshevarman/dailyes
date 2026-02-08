<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">
            New User
          </h4>
          <div class="card-header-actions mr-1">
            <a
              class="btn btn-primary"
              href="#"
              :disabled="submiting"
              @click.prevent="create"
            >
              <i
                v-if="submiting"
                class="fas fa-spinner fa-spin"
              />
              <i
                v-else
                class="fas fa-check"
              />
              <span class="ml-1">Save</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="form-group">
            <label>Full Name</label>
            <input
              v-model="user.name"
              type="text"
              class="form-control"
              :class="{'is-invalid': errors.name}"
              placeholder="John Doe"
            >
          </div>
          <div class="form-group">
            <label>Email</label>
            <input
              v-model="user.email"
              type="email"
              class="form-control"
              :class="{'is-invalid': errors.email}"
              placeholder="john@modulr.io"
            >
          </div>
          <div class="form-group">
            <label>Password</label>
            <input
              v-model="user.password"
              type="password"
              class="form-control"
              :class="{'is-invalid': errors.password}"
            >
          </div>
          <div class="form-group">
            <label>Roles</label>
            <multiselect
              v-model="user.roles"
              :options="roles"
              :multiple="true"
              open-direction="bottom"
              track-by="id"
              label="display_name"
              :class="{'border border-danger rounded': errors.roles}"
            />
            <small
              v-if="errors.roles"
              class="form-text text-danger"
            >{{ errors.roles[0] }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: {
        roles: []
      },
      roles: [],
      errors: {},
      submiting: false
    }
  },
  mounted () {
    this.getRoles()
  },
  methods: {
    create () {
      if (!this.submiting) {
        this.submiting = true
        axios.post(`/api/users/store`, this.user)
        .then(response => {
          this.$toasted.global.error('Created user!')
          location.href = '/admin/users'
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    getRoles () {
      axios.get(`/api/roles/all`)
      .then(response => {
        this.roles = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    }
  }
}
</script>
