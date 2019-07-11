<template>
  <div id="notifications">
    <notification-single
      v-for="notification in notifications"
      :key="notification.key"
      :notification="notification"
    />
  </div>
</template>
<script>
import NotificationSingle from './NotificationSingle.vue'

export default {
  name: 'Notifications',
  props: {
    user: {
      default: function() {},
      type: Object
    },
    user_type: {
      default: '',
      type: String
    }
  },
  data: () => ({
    notifications: [],
  }),
  mounted() {
    this.$root.$on('notification-dismissed', notification => {
      this.dismissNotification(notification)
    })

    this.$root.$on('new-notification', content => {
      this.pushNotification(content)
    })
  },
  methods: {
    dismissNotification: function(notification)
    {
      this.notifications = this.notifications.filter((element) => {
        return element.id != notification.id
      })
    },
    pushNotification: function(content)
    {
      this.notifications.unshift(content)
    },
  },
  components: {
    NotificationSingle
  }
}
</script>
<style lang="scss" scoped>
</style>
