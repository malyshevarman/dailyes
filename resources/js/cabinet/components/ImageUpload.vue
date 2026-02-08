<template>
  <div class="clearfix">
    <a-upload
      name="file"
      list-type="picture-card"
      class="avatar-uploader"
      :show-upload-list="false"
      action="/api/cabinet/download"
      :accept="'image/*'"
      :before-upload="beforeUpload"
      @change="handleChange"
    >
      <img
        v-if="imageUrl"
        :src="imageUrl"
        alt="image"
      >
      <div v-else>
        <a-icon :type="loading ? 'loading' : 'plus'" />
        <div class="ant-upload-text">
          Загрузить
        </div>
      </div>
    </a-upload>
    <a-modal
      :visible="cropperVisible"
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
                type: Object,
                default: null
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
                cropperVisible: false,
                tempImage: null,
                loading: false
            }
        },
        computed: {
            aspectRatio: function () {
                if (this.width && this.height) {
                    return this.width / this.height
                }
                return NaN
            },
            imageUrl: function () {
                return this.value ? this.value.url : ''
            }
        },
        methods: {
            handleChange(info) {
                if (info.file.status === 'uploading') {
                    this.loading = true
                    return
                }
                if (info.file.status === 'done') {
                    this.$emit('input', info.file.response)
                }
            },
            beforeUpload(file) {
                const isJPG = (file.type === 'image/jpeg' || file.type === 'image/png')
                if (!isJPG) {
                    this.$message.error('You can only upload JPG file!')
                }
                const isLt2M = file.size / 1024 / 1024 < 2
                if (!isLt2M) {
                    this.$message.error('Image must smaller than 2MB!')
                }
                if(isJPG && isLt2M) {
                    if (this.aspectRatio) {
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
                                this.cropperVisible = true
                            });
                            reader.readAsDataURL(this.oldFile); // then -> `onImageLoaded`
                        })
                    }
                } else {
                    return false;
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
                    this.cropperVisible = false;
                    this.resolve(croppedFile)
                }, type);
            },
            handleCancel() {
                this.cropperVisible = false
            },
        },
    }
</script>
<style>
    .avatar-uploader > .ant-upload img {
        width: 86px;
        height: 86px;
    }

    .ant-upload-select-picture-card i {
        font-size: 32px;
        color: #999;
    }

    .ant-upload-select-picture-card .ant-upload-text {
        margin-top: 8px;
        color: #666;
    }
    @media(max-width: 500px) {
        .ant-upload.ant-upload-select-picture-card {
            width: 100%;
        }
    }
</style>
