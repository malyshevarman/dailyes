<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">
            Смена пароля
          </h4>
          
        </div>
        <div class="card-body px-0">
          <form class="form-horizontal">
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Текущий пароль</label>
              <div class="col-md-9">
                <input
                  v-model="password.current"
                  class="form-control"
                  :class="{'is-invalid': errors.current}"
                  type="password"
                >
                <small class="form-text text-muted">Вы должны ввести свой текущий пароль, чтобы его изменить</small>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Новый пароль</label>
              <div class="col-md-9">
                <input
                  v-model="password.password"
                  class="form-control"
                  :class="{'is-invalid': errors.password}"
                  type="password"
                >
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Повторите новый пароль</label>
              <div class="col-md-9">
                <input
                  v-model="password.password_confirmation"
                  class="form-control"
                  :class="{'is-invalid': errors.password_confirmation}"
                  type="password"
                >
              </div>
            </div>
            <div class="card-header-actions d-flex justify-content-end">
              <a
                :class="{'btn': true, 'btn-primary': !disableButtonValue, 'disabled': disableButtonValue, 'btn-secondary': disableButtonValue}"
                href="#"
                :disabled="submiting"
                @click.prevent="updatePasswordAuthUser"
                role="button" 
                  aria-pressed="true"
                  style="text-decoration: none;"
              >
                <span class="ml-1">Сохранить</span>
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      password: {
        current: '',
        password_confirmation: '',
        password: ''
      },
      errors: {},
      submiting: false,
      copyItem: {
        current: '',
        password_confirmation: '',
        password: ''
      },
    }
  },
  computed: {
    disableButtonValue: function() {
        if (JSON.stringify(this.copyItem) == JSON.stringify(this.password)) {
            return true
        } else {
            return false
        }
    },
  },
  methods: {
    updatePasswordAuthUser () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/cabinet/profile/update-password-auth-user`, this.password)
        .then(response => {
          this.password = {}
          this.errors = {}
          this.submiting = false
          // this.$toasted.global.error('Password changed!');
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    }
  }
}
</script>
