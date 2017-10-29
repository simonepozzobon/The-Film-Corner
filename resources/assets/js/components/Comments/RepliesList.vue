<template>
  <div id="replies-list">
    <div v-for="reply in replies" :key="reply.key" class="row justify-content-center">
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
  }),
  mounted() {
    //do something after mounting vue instance
    this.$on('replyDelete', function(id) {
      this.deleteReply(id);
    });
  },
  methods: {
    deleteReply(id)
    {
      this.replies = this.replies.filter(function(value) {
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
