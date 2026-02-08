<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">
            New subscriber
          </h4>
          <div class="card-header-actions mr-1">
            <a
              class="btn btn-primary"
              href="#"
              :disabled="submiting"
              @click.prsubscriber="create"
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
          <div class="form-group col-md-12">
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
                submiting: false
            }
        },
        methods: {
            create() {
                if (!this.submiting) {
                    this.submiting = true
                    axios.post(`/api/subscribers/store`, this.subscriber)
                        .then(response => {
                            this.$toasted.global.error('Created subscriber!')
                            location.href = '/admin/subscribers'
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                            this.submiting = false
                        })
                }
            },
        }
    }
</script>
