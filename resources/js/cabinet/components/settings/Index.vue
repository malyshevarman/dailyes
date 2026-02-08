<template>
  <!-- <a-table
    :row-selection="{selectedRowKeys: selectedRowKeys, onChange: onSelectChange}"
    :columns="columns"
    :data-source="notifications"
    :row-key="record => record.id"
    :locale="{ emptyText: '' }"
    :pagination="false"
  >
  </a-table> -->
  <div class="cabinet-notification-settings">
    <div class="cabinet-notification-settings-block">
        <a-switch
             class="cabinet-notification-settings-switcher"
            :checked="userRestrictedNotifications.length == 0" 
            @change="toggle(notifications)" />{{notifications.length == userRestrictedNotifications.length ? 'Включить' : 'Отключить'}} все уведомления
    </div>
    <div v-for="notification in notifications" class="cabinet-notification-settings-block">
        <a-switch
            class="cabinet-notification-settings-switcher"
            :checked="userRestrictedNotifications.find(not => not.id == notification.id) == undefined" 
            @change="toggle(notification)" />{{notification.name}}
    </div>
  </div>
</template>

<script>
    const columns = [
        {title: 'Уведомления', dataIndex: 'name', key: 'id'},
    ];

    export default {
        data() {
            return {
                columns,
                errors: {},
                loading: false,
                alert: false,
                notifications: [
                ],
                userRestrictedNotifications: []
            }
        },
        computed: {
        },
        watch: {
            errors: function (val) {
                this.alert = Object.keys(val).length > 0
            }
        },
        mounted() {
        	this.fetchNotificationSettings()
        	this.fetchUserRestrictedNotifications()
        },
        methods: {
            toggle(value) {
                let data = {}
                let array =[]
                if (Array.isArray(value)) {
                    data.all = true

                    if (this.notifications.length !== this.userRestrictedNotifications.length) {
                        value.forEach(not => {
                            array.push(not.id)
                        })
                    }
                } else {
                    array.push(value.id)
                    data.all = false
                }
                data.data = array
                axios.post(`/api/cabinet/settings/toggle`, data)
                    .then(response => {
                        this.userRestrictedNotifications = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            // onSelectChange (selectedRowKeys) {
            //     this.selectedRowKeys = selectedRowKeys
            // },
            fetchNotificationSettings () {
            	axios.get(`/api/cabinet/settings`)
            		.then(response => {
            			this.notifications = response.data
            		})
            		.catch(error => {
            			console.log(error)
            		})
            },
            fetchUserRestrictedNotifications () {
            	axios.get(`/api/cabinet/settings/user-settings`)
            		.then(response => {
            			this.userRestrictedNotifications = response.data
            			// this.notifications.forEach(not => {
            			// 	let found = this.userRestrictedNotifications.find(unot => unot.id == not.id)

            			// 	if (found) {
            			// 		not.active = false
            			// 	} else {
            			// 		not.active = true
            			// 	}
            			// })
            		})
            		.catch(error => {
            			console.log(error)
            		})
            }
        }
    }
</script>
<style lang="scss" scoped>
    /*.ant-table-footer {
        text-align: center;
    }*/
    .cabinet-notification-settings {
        margin-top: 20px;
    }
    .cabinet-notification-settings-block {
        margin-bottom: 20px;
    }

    .cabinet-notification-settings-switcher {
        margin-right: 20px;
    }
</style>
