<template>
  <div>
    <div :style="{ marginBottom: '24px', display: 'flex', justifyContent: 'space-between' }">
      <div>
        <a
          class="btn btn-success"
          href="/admin/download/create"
        >Добавить в галерею</a>
      </div>
    </div>
    <a-table
      :columns="columns"
      :data-source="value"
      :scroll="{ x: 1300 }"
      size="small"
    >
      <div
        slot="image"
        slot-scope="text, record"
      >
        <img
          v-if="record.download"
          style="width: 48px; height: 48px;"
          :src="`/storage/${record.download.path}`"
        >
        <template v-else-if="record.link">
          Видео
        </template>
      </div>
      <div
        slot="name"
        slot-scope="text, record"
      >
        <template v-if="record.download">
          {{ record.download.original_name }}
        </template>
        <template v-else-if="record.link">
          {{ record.link }}
        </template>
      </div>
    </a-table>
    <image-gallery-add-item />
  </div>
</template>
<script>
    const columns = [
        {
            title: 'Превью',
            key: 'image',
            width: 100,
            scopedSlots: {customRender: 'image'},
        },
        {
            title: 'Название',
            key: 'name',
            scopedSlots: {customRender: 'name'},
        },
    ];

    export default {
        props: {
            value: {
                type: Array,
                default: null
            }
        },
        data() {
            return {
                columns,
                filters: {
                    pagination: {
                        from: 0,
                        to: 0,
                        total: 0,
                        per_page: 25,
                        current_page: 1,
                        last_page: 0
                    },
                    orderBy: {
                        column: 'id',
                        direction: 'asc'
                    },
                    search: ''
                },
            }
        }
    }
</script>

<style scoped>

</style>
