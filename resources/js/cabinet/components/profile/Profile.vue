<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">
            Редактирование профиля
          </h4>
        </div>
        <div style="padding: 30px;
            background: rgb(29, 134, 224);
            margin-top: 20px;
            color: #fff;
            border-radius: 10px
        px
        ;">
          <span>
            Заполните пожалуйста всю недостающую информацию по вашему профилю.
          </span>
        </div>
        <div class="card-body px-0">
          <form
            v-if="!loading"
            class="form-horizontal"
          >
            <!--<div class="form-group row justify-content-md-center">
              <div class="col-md-3">
                Аватар
              </div>
              <div class="col-md-9">
                <small class="form-text text-muted mb-3">Вы можете сменить или удалить Ваш аватар</small>
                <avatar :user="user" />
              </div>
            </div>
            <hr class="my-3">
            -->
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Ваше Имя</label>
              <div class="col-md-9">
                <input
                  v-model="user.name"
                  class="form-control"
                  :class="{'is-invalid': errors.name}"
                  type="text"
                >
                <small class="form-text text-muted">Введите свое имя, чтобы быть узнаваемым</small>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Ваша фамилия</label>
              <div class="col-md-9">
                <input
                  v-model="user.last_name"
                  class="form-control"
                  :class="{'is-invalid': errors.last_name}"
                  type="text"
                >
                <small class="form-text text-muted">По желанию</small>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Дата рождения</label>
              <div class="col-md-9">
                <a-date-picker
                  @change="changedate"
                  v-model="birth_date"
                  placeholder=" "
                  format="DD-MM-YYYY"
                />
                <small class="form-text text-muted"></small>
              </div>
              <label class="col-md-3">Пол:</label>
              <div class="col-md-9">
                <a-radio-group v-model="user.gender">
                  <a-radio :value="1">муж</a-radio>
                  <a-radio :value="0">жен</a-radio>
                </a-radio-group>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Город</label>
              <div class="col-md-9">

                <a-select
                        show-search
                        :value="user.city"
                        placeholder="Начните вводить адрес и выберите подходящий"
                        style="width: 100%"
                        :default-active-first-option="false"
                        :show-arrow="false"
                        :filter-option="false"
                        :not-found-content="null"
                        @search="handleSearchAddress"
                        @change="handleChangeAddress"
                        class="form-control"
                        :class="{'is-invalid': errors.city}"
                >
                  <a-select-option
                          v-for="d in data"
                          :key="d.name"
                  >
                    {{ d.name }}
                  </a-select-option>
                </a-select>
                <small class="form-text text-muted">Укажите из какого вы города</small>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Телефон</label>
              <div class="col-md-9">
                <input
                  v-model="user.phone"
                  class="form-control"
                  :class="{'is-invalid': errors.phone}"
                  type="text"
                  v-mask="'+# (###) ###-##-##'"
                  @click="startTexting"
                >
                <small class="form-text text-muted">Ваш телефон не будет отображаться на сайте</small>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Email</label>
              <div class="col-md-9">
                <input
                  v-model="user.email"
                  class="form-control"
                  :class="{'is-invalid': errors.email}"
                  type="email"
                >
                <small class="form-text text-muted">Ваша почта не будет отображаться на сайте</small>
              </div>
            </div>
          </form>
          <div
            v-else
            class="row justify-content-md-center"
          >
            <div class="col-md-12">
              <content-placeholders>
                <content-placeholders-heading :img="true" />
                <content-placeholders-text />
              </content-placeholders>
            </div>
          </div>
        </div>

        <div class="card-header-actions d-flex justify-content-end">
          <a
                  :class="{'btn': true, 'btn-primary': !disableButtonValue, 'disabled': disableButtonValue, 'btn-secondary': disableButtonValue}"
                  href="#"
                  :disabled="disableButtonValue"
                  @click.prevent="updateAuthUser"
                  role="button" 
                  aria-pressed="true"
                  style="text-decoration: none;"
          >
            <!-- <i
                    v-if="submiting"
                    class="fas fa-spinner fa-spin"
            />
            <i
                    v-else
                    class="fas fa-check"
            /> -->
            <span class="ml-1">Сохранить</span>
          </a>
        </div>
        
      </div>
    </div>
  </div>
</template>

<script>
import avatar from './Avatar.vue'
import moment from 'moment';

let timeout;
let currentValue;

let str = window.location.pathname
let res = str.split("/")


export default {
  components: {
    avatar
  },
  data () {
    return {
      cities: [], // список всех городов для селекта
      data: [], // список адресов из dadata
      // value: undefined, // текущий адрес dadata
      // citySelect: false, // виден ли выпадающий список городов
      user: {},
      errors: {},
      loading: false,
      copyItem: {},
      // isItemEdited: false
    }
  },
  computed: {
    birth_date: {
      get: function () {
        return this.user.birth_date ? moment.utc(this.user.birth_date) : moment.utc()
      },
      set: function (value) {
        this.user.birth_date = value.format('YYYY-MM-DD HH:mm:ss')
        console.log('start',this.user.birth_date)
      }
    },
    disableButtonValue: function() {
      console.log('JSON.stringify(this.copyItem) == JSON.stringify(this.user)', JSON.stringify(this.copyItem) == JSON.stringify(this.user))
        if (JSON.stringify(this.copyItem) == JSON.stringify(this.user)) {
          console.log('hi')
            return true
        } else {
            return this.loading
        }
    },
  },
  mounted () {
    this.getAuthUser()
  },
  methods: {
    changedate(date, dateString){
      console.log(date, dateString);
    },
    startTexting() {
      if (this.user.phone == null) {
        this.user.phone = "+7 ("
      }
    },
    searchbase(value){
      axios.get(`/api/cabinet/city/all`,)
              .then(response => {
                let allcity
                allcity = response.data;
                this.data = allcity.filter(citi => citi.name.toLowerCase().indexOf(value.toLowerCase()) != -1)
                console.log('=>', this.data)
                if (this.data.length > 0) {
                  // this.citySelect = true
                } else {
                  // this.citySelect = false
                }

              })
              .catch(error => {

              })
    },
    handleSearchAddress(value) {

   this.searchbase(value)

    },
    handleChangeAddress(value) {
      console.log(value)
      this.value = value
      this.user.city = value
    },
    getAuthUser () {
      this.loading = true
      const message = this.$message.loading('Загрузка данных', 0)
      axios.get(`/api/cabinet/profile/get-auth-user`)
      .then(response => {
        this.user = response.data
        this.copyItem = JSON.parse(JSON.stringify(this.user))
        // this.loading = false
      })
      .catch(error => {
          this.$message.error('Ошибка')
      })
      .then(() => {
          setTimeout(message, 0)
          this.loading = false
      })
    },
    updateAuthUser () {
      if (!this.loading) {
        this.loading = true
        const message = this.$message.loading('Сохранение', 0)
        axios.put(`/api/cabinet/profile/update-auth-user`, this.user)
        .then(response => {
          this.errors = {}
          this.user = response.data
          this.copyItem = JSON.parse(JSON.stringify(this.user))
          this.$message.success('Успешно сохранено!')

          // this.$toasted.global.error('Profile updated!');
        })
        .catch(error => {
            this.$message.error('Ошибка')
            this.errors = error.response.data.errors
        })
        .then(() => {
            setTimeout(message, 0)
            this.loading = false
            location.reload()
        })
      }
    }
  }
}
</script>

<style>
    /*.ant-select-selection__rendered{
        line-height: 38px!important;
    }
    .ant-select-selection--single, .ant-calendar-picker-input{
        height: 38px!important;
    }*/
    .ant-select-selection {
      border: none;
      /*height: 32px !important;*/
    }

   /* @media(max-width: 500px) {
      .card-header-actions {
        display: block !important;
      }

      .card-header-actions a {
        float: right;
      }

      .form-text-bottom {
        display: block;
        margin-bottom: 10px;
      }
    }*/
</style>
