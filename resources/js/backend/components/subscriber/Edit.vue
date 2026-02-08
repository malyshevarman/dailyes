<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">
            {{subscriber.email}}
          </h4>
          <div class="card-header-actions mr-1">
            <a
              class="btn btn-primary"
              href="#"
              :disabled="submiting"
              @click.prsubscriber="update"
            >
              <i
                v-if="submiting"
                class="fas fa-spinner fa-spin"
              />
              <i
                v-else
                class="fas fa-check"
              />
              <span class="ml-1">Обновить</span>
            </a>
            <a
              class="card-header-action ml-1"
              href="#"
              :disabled="submitingDestroy"
              @click.prsubscriber="destroy"
            >
              <i
                v-if="submitingDestroy"
                class="fas fa-spinner fa-spin"
              />
              <i
                v-else
                class="far fa-trash-alt"
              />
              <span class="d-md-down-none ml-1">Удалить</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <div
            v-if="!loading"
            class="row"
          >
            <div class="form-group col-md-9">
              <label>Email</label>
              <input
                v-model="subscriber.email"
                type="email"
                class="form-control"
                :class="{'is-invalid': errors.email}"
                placeholder="email@example.com"
              >
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-12">
              <content-placeholders>
                <content-placeholders-text />
              </content-placeholders>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                subscriber: {},
                errors: {},
                loading: true,
                submiting: false,
                submitingDestroy: false
            }
        },
        mounted() {
            this.getSubscriber()
        },
        methods: {
            getSubscriber() {
                this.loading = true
                let str = window.location.pathname
                let res = str.split("/")
                axios.get(`/api/backend/subscriber/${res[3]}`)
                    .then(response => {
                        this.subscriber = response.data[0]
                    })
                    .catch(error => {
                        this.$toasted.global.error('Subscriber does not exist!')
                        // location.href = '/admin/subscribers'
                    })
                    .then(() => {
                        this.loading = false
                    })
            },
            update() {
                if (!this.submiting) {
                    this.submiting = true
                    axios.put(`/api/backend/subscriber/${this.subscriber.id}`, this.subscriber)
                        .then(response => {
                            this.$toasted.global.error('Updated subscriber!')
                            location.href = '/admin/subscriber'
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                            this.submiting = false
                        })
                }
            },
            destroy() {
                if (!this.submitingDestroy) {
                    this.submitingDestroy = true
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this subscriber!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                axios.delete(`/api/backend/subscriber/${this.subscriber.id}`)
                                    .then(response => {
                                        this.$toasted.global.error('Deleted subscriber!')
                                        location.href = '/admin/subscriber'
                                    })
                                    .catch(error => {
                                        this.errors = error.response.data.errors
                                    })
                            }
                            this.submitingDestroy = false
                        })
                }
            }
        }
    }
</script>
