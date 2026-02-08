<template>
  <div class="gallery">
    <span>{{ galleryItems.length }} из {{ max_count }}</span>
    <a-row
      :gutter="16"
      type="flex"
    >
      <template v-for="(item, index) in galleryItems">
        <a-col :span="2">
          <a-card
            hoverable
          >
            <img
              slot="cover"
              :alt="item.name"
              :src="item.url"
            >
            <template
              slot="actions"
              class="ant-card-actions"
            >
              <a-icon
                type="delete"
                @click="deleteItem(index, item)"
              />
            </template>
          </a-card>
        </a-col>
      </template>
      <a-col :span="2" v-if="galleryItems.length < max_count">
        <a-card
          hoverable
        >
          <div
            style="text-align: center;"
            @click="dialogVisible = true"
          >
            <a-icon type="plus" />
            <div class="ant-upload-text">
              Загрузить
            </div>
          </div>
        </a-card>
      </a-col>
    </a-row>
    <a-modal
      :visible="dialogVisible"
      @ok="handleOkDialog"
      @cancel="handleCancelDialog"
    >
      <div>
        <a-tabs default-active-key="1">
          <a-tab-pane
            key="1"
            tab="Изображения"
          >
            <add-image v-model="images" />
          </a-tab-pane>
          <a-tab-pane
            key="2"
            tab="Видео YouTube"
            force-render
          >
            <add-video v-model="videos" />
          </a-tab-pane>
        </a-tabs>
      </div>
    </a-modal>
  </div>
</template>

<script>
    import reqwest from 'reqwest'

    import addVideo from './AddVideo.vue'
    import addImage from './AddImage.vue'

    export default {
        components: {
            addVideo,
            addImage
        },
        props: {
            value: {
                type: Array,
                default: () => ([])
            }
        },
        data() {
            return {
                videos: [],
                images: [],
                dialogVisible: false,
                max_count: 6
            }
        },
        computed: {
            galleryItems() {
                return this.value.map(item => {
                    return {
                        id: item.id,
                        name: item.attachable.id,
                        url: item.attachable.url
                    }
                })
            }
        },
        methods: {
            handleOkDialog() {
              this.upload()
              this.dialogVisible = false
            },
            handleCancelDialog() {
                this.dialogVisible = false
            },
            upload() {
                const {videos, images} = this;
                if (!images.length && !videos.length) {
                    return;
                }
                const formData = new FormData();
                images.forEach((file) => {
                    formData.append('downloads[]', file);
                });
                videos.forEach((file) => {
                    formData.append('videos[]', file);
                });

                reqwest({
                    url: '/api/cabinet/gallery-item/store-multiple',
                    method: 'post',
                    processData: false,
                    data: formData,
                    success: (response) => {
                        this.$emit('input', this.value.concat(response))
                        this.images = []
                        this.videos = []
                    },
                    error: () => {
                    },
                });
            },
            deleteItem(i, item) {
                // this.counter--
                axios.get(`/api/cabinet/gallery-item/remove-multiple/${item.id}`)
                      .then(response => {
                          this.$emit('input', this.value.filter((item, index) => {
                              return index !== i
                          }))
                      })
                      .catch(error => {
                          console.log(error)
                      })
            }
        },
    }
</script>

<style>
    .gallery [class^="ant-col-"] {
        height: 100%;
        min-width: 135px;
        overflow: hidden;
        padding: 8px;
    }

    .gallery .ant-card {
        height: 100%;
    }

    .gallery .ant-card-cover {
        height: 100%;
        width: 100%;
    }

    .gallery .ant-card-cover > img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ant-upload-text {
        margin-top: 8px;
        color: #666;
    }

    @media(max-width: 500px) {
        .gallery [class^="ant-col-"] {
            width: 100%;
        }
    }
</style>
