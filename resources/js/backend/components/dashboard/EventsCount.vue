<template>
  <div class="card text-white bg-info">
    <div class="card-body">
      <div class="h1 text-muted text-right mb-4">
        <i class="icon-people" />
      </div>
      <div class="text-value">
        {{ events }}
      </div>
      <small class="text-muted text-uppercase font-weight-bold">Events count</small>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      events: 0
    }
  },
  mounted () {
    this.getEventsCount()
  },
  methods: {
    getEventsCount () {
      axios.get(`/api/backend/event/count`)
      .then(response => {
        this.events = response.data
      })
    },
  }
}
</script>
