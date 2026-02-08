<template>
  <div class="card text-white bg-info">
    <div class="card-body">
      <div class="h1 text-muted text-right mb-4">
        <i class="icon-people" />
      </div>
      <div class="text-value">
        {{ companies }}
      </div>
      <small class="text-muted text-uppercase font-weight-bold">Companies count</small>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      companies: 0
    }
  },
  mounted () {
    this.getCompaniesCount()
  },
  methods: {
    getCompaniesCount () {
      axios.get(`/api/backend/company/count`)
      .then(response => {
        this.companies = response.data
      })
    },
  }
}
</script>
