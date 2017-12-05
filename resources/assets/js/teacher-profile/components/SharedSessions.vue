<template>
  <div id="shared-sessions">
    <div class="box green mt">
      <div class="box-header">
        Shared Sessions
      </div>
      <div class="box-body">
        <shared-session-single
          v-for="session in sessions"
          :key="shared.key"
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
