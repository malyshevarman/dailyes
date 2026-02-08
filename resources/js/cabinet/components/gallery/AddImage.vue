<template>
  <div class="clearfix">
    <a-upload-dragger
      :file-list="fileList"
      :remove="handleRemove"
      :before-upload="beforeUpload"
      :multiple="true"
      name="file"
    >
      <p class="ant-upload-drag-icon">
        <a-icon type="inbox" />
      </p>
      <p class="ant-upload-text">
        Нажмите или перетащите изображение в эту область
      </p>
      <p class="ant-upload-hint">
        Вы можете выбрать сразу несколько файлов для загрузки
      </p>
    </a-upload-dragger>
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
                fileList: [],
            }
        },
        watch: {
            fileList: function (val) {
                this.$emit('input', val)
            },
            value: function (val) {
                if (this.fileList.length > 0 && val.length === 0) {
                    this.fileList = []
                }
            }
        },
        methods: {
            handleRemove(file) {
                const index = this.fileList.indexOf(file);
                const newFileList = this.fileList.slice();
                newFileList.splice(index, 1);
                this.fileList = newFileList
            },
            beforeUpload(file) {
                this.fileList = [...this.fileList, file]
                return false;
            },
        },
    }
</script>
<style>

</style>
