<template>
	<div>
		<a-modal
            v-model="show"
            :closable="false"
            :width="540"
            :centered="true"
            :bodyStyle="{padding: '36px'}"
            :footer="null"
        >
            <img src="/icon/safari-pinned-tab.svg" width="110" height="70" style="margin: auto;display: block;">
            <h4 v-if="title" style="margin:0;text-align: center;">{{title}}</h4>
            <p v-if="text" style="margin:0;margin-bottom: 1rem;text-align: center;">
                {{text}}
            </p>
            <a-button style="padding: 14px 74px;display: block;margin: auto;min-height: 55px;" key="submit"
                      type="primary" :loading="loading" @click="closeModal()">
                Хорошо
            </a-button>
        </a-modal>
	</div>
</template>

<script>
    export default {
        props: {
            message: {
                default: null,
                type: Object
            },
        },
        data() {
            return {
                loading: false,
                show: false,
                title: '',
                text: '',

            }
        },
        mounted() {
        	this.$bus.$on('showModal', (data) => {
                this.title = data.title
        		this.text = data.text
        		this.showModal()
            })
            if (this.message !== null) {
                this.text = this.message.text
                this.showModal()
            }
        },
        methods: {
            showModal() {
                this.show = true
            },
            closeModal() {
            	this.show = false
                this.title = ''
                this.text = ''
            }
        }
    };
</script>