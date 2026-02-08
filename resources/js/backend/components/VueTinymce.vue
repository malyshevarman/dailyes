<template>
  <tinymce-editor
    ref="input"
    v-bind="$attrs"
    :value="value"
    :rows="rows"
    api-key="j5htocbxtsk0remok431lo03ljfokezyj0rfgqnaj9r747k6"
    :init="settings"
    @input="function(v){$emit('input',v)}"
  />
</template>

<script>
    import TinymceEditor from '@tinymce/tinymce-vue'

    let settings = {
        menubar: true,
        height: 450,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table directionality',
            'emoticons template paste textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        images_upload_url: '/uploads',
        block_formats: 'Paragraph=p; Header 4=h4',
        style_formats: [
          { title: 'Headings', items: [
            { title: 'Другой заголовок', format: 'h4' },
            { title: 'Заголовок для рассылки', format: 'h1' }
          ]},
          { title: 'Blocks', items: [
            { title: 'Текст', format: 'p' }
          ]},
          { title: 'Align', items: [
            { title: 'Left', format: 'alignleft' },
            { title: 'Center', format: 'aligncenter' },
            { title: 'Right', format: 'alignright' },
            { title: 'Justify', format: 'alignjustify' }
          ]}
        ]
    }

    export default {
        components: {
            TinymceEditor,
        },
        inheritAttrs: false,
        props: {
            id: {
                type: String,
                default() {
                    return `textarea-input-${this._uid}`
                },
            },
            rows: {
                type: Number,
                default: 10,
            },
            value: String,
            settings: {
                type: Object,
                default: function () {
                    return settings
                },
            },
        },
        methods: {
            focus() {
                this.$refs.input.focus()
            },
            select() {
                this.$refs.input.select()
            },
            setSelectionRange(start, end) {
                this.$refs.input.setSelectionRange(start, end)
            },
        },
    }
</script>
