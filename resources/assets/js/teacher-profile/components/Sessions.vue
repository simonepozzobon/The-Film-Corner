<template>
  <div id="sessions">
    <div class="box blue">
      <div class="box-header">
        Activities
      </div>
      <div class="box-body">
        <notification v-for="notification in notifications" :key="notification.key" :notification="notification"/>
      </div>
    </div>
  </div>
</template>
<script>
import Notification from './Notification.vue'
export default {
  name: 'Sessions',
  props: {
    notifications: {
      default: function() {},
      type: Array
    }
  },
  data: () => ({

  }),
  components: {
    Notification
  }
}
</script>
<style lang="scss" scoped>
</style>
