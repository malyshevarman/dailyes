<template>
  <div>
    <div style="text-align: center; margin-bottom: 15px;">
      Ссылки на видео YouTube
    </div>
    <div v-for="(link, index) in links">
      <a-input
        v-model="link.text"
        placeholder="https://www.youtube.com/watch?v=Bo0guUbL5uo"
        style="margin-bottom: 15px;"
      >
        <a-icon
          slot="addonAfter"
          type="delete"
          style="cursor: pointer;"
          @click="delField(index)"
        />
      </a-input>
    </div>
    <a-button
      type="dashed"
      style="width: 100%"
      @click="addField"
    >
      <a-icon type="plus" />
      Добавить еще
    </a-button>
  </div>
</template>
<script>
    export default {
        props: {
            value: {
                type: Array,
                required: true
            },
        },
        data() {
            return {
                links: []
            }
        },
        watch: {
            links: function (val) {
                this.$emit('input', val.filter(item => item.text.length > 0).map(item => item.text))
            },
            value: function (val) {
                if (this.links.filter(item => item.text.length > 0).length > 0 && val.length === 0) {
                    this.links = []
                }
            }
        },
        mounted() {
            this.addField()
        },
        methods: {
            addField() {
                this.links.push({text: ''})
            },
            delField(index) {
                this.links.splice(index, 1)
            }
        }
    }
</script>

<style>

</style>
