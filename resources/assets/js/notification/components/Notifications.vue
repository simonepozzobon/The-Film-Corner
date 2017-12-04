<template>
  <div id="notifications">
    <notification-single v-for="notification in notifications" :key="notification.key" :notification="notification"/>
  </div>
</template>
<script>
import NotificationSingle from './NotificationSingle.vue'

export default {
  name: 'Notifications',
  data: () => ({
    notifications: [
      {
        id: 1,
        from: 'Marc',
        message: 'sent you a new notification.'
      }
    ]
  }),
  mounted() {
    //do something after mounting vue instance
    this.$root.$on('notification-dismissed', notification => {
      this.dismissNotification(notification)
    })
  },
  methods: {
    dismissNotification: function(notification)
    {
      this.notifications = this.notifications.filter((element) => {
        return element.id != notification.id
      })
    },
  },
  components: {
    NotificationSingle
  }
}
</script>
<style lang="scss" scoped>
</style>
