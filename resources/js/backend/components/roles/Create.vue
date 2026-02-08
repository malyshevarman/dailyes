<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">
            New Role
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
        <div class="card-header px-0 bg-transparent">
          <strong>General</strong><br>
          <small class="text-muted">Create a new role and choose the permissions so you can assign it to users.</small>
        </div>
        <div class="card-body px-0">
          <div class="form-group">
            <label>Role name</label>
            <input
              v-model="role.display_name"
              type="text"
              class="form-control"
              :class="{'is-invalid': errors.display_name}"
              placeholder="Admin"
              autofocus
            >
          </div>
          <div class="form-group">
            <label>Role slug</label>
            <input
              v-model="role.slug"
              type="text"
              class="form-control"
              :class="{'is-invalid': errors.slug}"
              placeholder="admin"
              readonly
            >
          </div>
        </div>
        <div class="card-header px-0 bg-transparent">
          <strong>Permissions</strong><br>
          <small class="text-muted">Enable or disable permissions and choose access to modules.</small>
        </div>
        <div class="card-body">
          <form
            v-if="!loading"
            class="form-horizontal"
          >
            <div
              v-for="module in role.modulesPermissions"
              class="form-group row"
            >
              <label class="col-md-3"><strong>{{ module.display_name }}</strong></label>
              <div class="col-md-9">
                <div
                  v-for="permission in module.permissions"
                  class="clearfix"
                >
                  <span>{{ permission.display_name }}</span>
                  <label class="switch switch-pill switch-outline-success-alt float-right">
                    <input
                      v-model="permission.allow"
                      class="switch-input"
                      type="checkbox"
                    >
                    <span class="switch-slider" />
                  </label>
                  <hr>
                </div>
              </div>
            </div>
          </form>
          <content-placeholders v-else>
            <content-placeholders-heading :img="true" />
            <content-placeholders-heading :img="true" />
          </content-placeholders>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      role: {},
      errors: {},
      loading: true,
      submiting: false
    }
  },
  watch: {
    'role.display_name': function (val) {
      this.role.name = val.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');
    }
  },
  mounted() {
    this.getModulesPermissions()
  },
  methods: {
    create () {
      if (!this.submiting) {
        this.submiting = true
        axios.post('/api/roles/store', this.role)
        .then(response => {
          this.$toasted.global.error('Created role!')
          location.href = '/admin/roles'
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    getModulesPermissions () {
      this.loading = true
      axios.get('/api/modules/get-modules-permissions')
      .then(response => {
        this.role.modulesPermissions = response.data
        this.loading = false
        //this.$set(this.role, 'modules', response.data)
      })
    }
  }
}
</script>
