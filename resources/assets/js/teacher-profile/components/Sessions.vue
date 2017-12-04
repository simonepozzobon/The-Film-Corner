<template>
  <div id="sessions">
    <div class="box blue">
      <div class="box-header">
        Sessions
      </div>
      <div class="box-body">
        <notification/>
        <notification/>
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
