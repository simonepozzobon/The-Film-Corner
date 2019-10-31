<template>
  <div id="replies-list">
    <div v-for="reply in msgs" :key="reply.key" class="row mt">
      <reply-single :reply="reply" :user="user" :user_type="user_type">
      </reply-single>
    </div>
  </div>
</template>
<script>

import ReplySingle from './ReplySingle.vue'

export default {
  name: "replies-list",
  props: ['replies', 'user', 'user_type'],
  data: () => ({
    msgs: ''
  }),
  mounted() {
    //do something after mounting vue instance
    this.msgs = this.replies;
    this.$on('replyDelete', function(id) {
      this.deleteReply(id);
    });
  },
  methods: {
    deleteReply(id)
    {
      this.msgs = this.msgs.filter(function(value) {
          return value.id !== id;
      });
    }
  },
  components: {
    ReplySingle
  }
}
</script>
<style lang="scss" scoped>
</style>
