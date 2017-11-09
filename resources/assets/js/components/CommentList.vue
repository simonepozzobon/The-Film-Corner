<template>
  <div id="comment-list">
    <div v-for="comment in comments_list" :key="comment.key" :id="'comment-'+comment.id" class="comment row mt">
      <comment-single :comment="comment" :user="user" :user_type="user_type">
      </comment-single>
    </div>
  </div>
</template>
<script>

import CommentSingle from './CommentSingle.vue'

export default {
  name: "",
  props: ['comments', 'user', 'user_type'],
  data: () => ({
    comments_list: ''
  }),
  mounted() {
    var vue = this;
    this.comments_list = JSON.parse(this.comments);
    this.$parent.$on('newComment', function(comment) {
      vue.addComment(comment);
    });
    this.$on('commentDelete', function(id) {
      this.deleteComment(id);
    });
  },
  methods: {
    addComment(comment) {
      this.comments_list.push(comment);
    },
    deleteComment(id)
    {
      this.comments_list = this.comments_list.filter(function(value) {
          return value.id !== id;
      });
    }
  },
  components: {
    CommentSingle
  }
}
</script>
<style lang="scss" scoped>
</style>
