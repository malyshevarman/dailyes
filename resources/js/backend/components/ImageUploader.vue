<template>
  <div class="clearfix">
    <a-upload
      action="/api/backend/download"
      list-type="picture"
      :file-list="fileList"
      :before-upload="beforeUpload"
      :remove="handleRemove"
      :accept="'image/*'"
      @preview="handlePreview"
      @change="handleChange"
    >
      <div v-if="fileList.length < count">
        <a-button>
          <a-icon type="upload" />
          Загрузить
        </a-button>
      </div>
    </a-upload>
    <a-modal
      :visible="previewVisible"
      :footer="null"
      @cancel="handleCancelPreview"
    >
      <img
        alt="example"
        style="width: 100%"
        :src="previewImage"
      >
    </a-modal>
    <a-modal
      :visible="visible"
      title="Изменить изображение"
      @ok="handleOk"
      @cancel="handleCancel"
    >
      <vue-cropper
        ref="cropper"
        :guides="true"
        :view-mode="2"
        drag-mode="crop"
        :auto-crop-area="1"
        :aspect-ratio="aspectRatio"
        :background="true"
        :src="tempImage"
        alt="Source Image"
        :img-style="{ 'width': '100%', 'height': 'auto' }"
      />
    </a-modal>
  </div>
</template>

<script>
    import VueCropper from 'vue-cropperjs';
    import 'cropperjs/dist/cropper.css';

    export default {
        components: {
            VueCropper,
        },
        props: {
            value: {
                type: Number,
                default: null
            },
            count: {
                type: Number,
                default: 1
            },
            width: {
                type: Number,
                default: NaN
            },
            height: {
                type: Number,
                default: NaN
            },
        },
        data() {
            return {
                previewVisible: false,
                previewImage: '',
                fileList: [],
                tempImage: null,
                visible: false,
                confirmLoading: false
            }
        },
        computed: {
            aspectRatio: function () {
                if (this.width && this.height) {
                    return this.width / this.height
                }
                return NaN
            }
        },
        mounted() {
            if (this.value) {
                axios.get(`/api/backend/download/${this.value}`)
                    .then(response => {
                        this.fileList.push({
                            uid: response.data.id,
                            name: response.data.original_name,
                            status: 'done',
                            url: '/storage/' + response.data.path
                        })
                    })
            }
        },
        methods: {
            handleRemove(file) {
                const id = file.response ? file.response.id : file.uid
                // axios.delete(`/api/download/${id}`)
                this.$emit('input', null)
            },
            beforeUpload(file, fileList) {
                // кропаем только png или jpeg
                if (this.aspectRatio && (file.type === 'image/jpeg' || file.type === 'image/png')) {
                    return new Promise((resolve, reject) => {
                        this.resolve = resolve
                        this.reject = reject

                        this.oldFile = file;

                        const reader = new FileReader();
                        reader.addEventListener('load', () => {
                            if (this.$refs.cropper) {
                                this.$refs.cropper.replace(reader.result);
                            }
                            this.tempImage = reader.result
                            this.visible = true
                        });
                        reader.readAsDataURL(this.oldFile); // then -> `onImageLoaded`
                    })
                }
            },
            handleOk(e) {
                const {name, type, uid} = this.oldFile;
                this.$refs.cropper.getCroppedCanvas().toBlob(async (blob) => {
                    const croppedFile = new File([blob], name, {
                        type,
                        lastModified: Date.now(),
                    });
                    croppedFile.uid = uid;
                    this.visible = false;
                    this.resolve(croppedFile)
                }, type);
            },
            handleCancel() {
                this.visible = false
            },
            handleCancelPreview() {
                this.previewVisible = false
            },
            handlePreview(file) {
                this.previewImage = file.url || file.thumbUrl
                this.previewVisible = true
            },
            handleChange({file, fileList}) {
              if(file.status === 'done') {
                this.$emit('input', file.response.id)
              }
                this.fileList = fileList
            }
        }
    }
</script>

<style scoped>
    /* you can make up upload button and sample style by using stylesheets */
    .ant-upload-select-picture-card i {
        font-size: 32px;
        color: #999;
    }

    .ant-upload-select-picture-card .ant-upload-text {
        margin-top: 8px;
        color: #666;
    }
</style>
