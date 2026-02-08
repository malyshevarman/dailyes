<template>
  <div>
    <a-button
      type="primary"
      @click="showDrawer"
    >
      <a-icon type="plus" /> New account
    </a-button>
    <a-drawer
      title="Добавить в галерею"
      :width="300"
      :visible="visible"
      :wrap-style="{height: 'calc(100% - 108px)',overflow: 'auto',paddingBottom: '108px'}"
      @close="onClose"
    >
      <a-form-item label="Name">
        <a-input
          placeholder="Please enter user name"
        />
      </a-form-item>
      <div
        :style="{
          position: 'absolute',
          left: 0,
          bottom: 0,
          width: '100%',
          borderTop: '1px solid #e9e9e9',
          padding: '10px 16px',
          background: '#fff',
          textAlign: 'right',
        }"
      >
        <a-button
          :style="{marginRight: '8px'}"
          @click="onClose"
        >
          Cancel
        </a-button>
        <a-button
          type="primary"
          @click="onClose"
        >
          Submit
        </a-button>
      </div>
    </a-drawer>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                form: this.$form.createForm(this),
                visible: false,
            }
        },
        methods: {
            showDrawer() {
                this.visible = true
            },
            onClose() {
                this.visible = false
            },
        },
    }
</script>

<style>
  .ant-drawer {
    z-index: 99999;
  }

</style>
