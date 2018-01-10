<template>
  <div id="shared-sessions">
    <div class="box green mt">
      <div class="box-header">
        {{ title }}
      </div>
      <div class="box-body">
        <shared-session-single
          v-for="session in sessions"
          :key="session.key"
          :session="session"
        />
      </div>
    </div>
  </div>
</template>
<script>
import SharedSessionSingle from './SharedSessionSingle.vue'
export default {
  name: 'SharedSessions',
  props: {
    title: {
      type: String,
      default: 'Network',
    },
    sessions: {
      default: function() {},
      type: Array
    }
  },
  data: () => ({

  }),
  components: {
    SharedSessionSingle
  }
}
</script>
<style lang="scss" scoped>
</style>
