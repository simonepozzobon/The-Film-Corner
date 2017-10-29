<template>
  <div class="col">
    <div id="single-comment" ref="comment">
      <h3>{{ comment.author.name }}</h3>
      <p>{{ comment.time }}</p>
      <p>{{ comment.comment }}</p>
      <div class="reply">
        <button @click="confirmation" type="button" name="button" class="btn btn-secondary btn-orange"><i class="fa fa-trash-o"></i> Delete</button>
        <button @click="newReply" type="button" name="button" class="btn btn-secondary btn-orange"><i class="fa fa-comments-o"></i> Reply</button>
      </div>
      <div id="reply" ref="newReply">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <button @click="closeReply" id="close" type="button" class="close mb-3">
              <span aria-hidden="true">&times;</span>
              <span class="sr-only">Close</span>
            </button>
            <div class="form-group">
              <textarea v-model="reply_msg" name="comment" class="form-control"></textarea>
            </div>
            <div class="form-group d-flex justify-content-center pt-2">
              <button @click="sendReply" type="button" name="button" class="btn btn-secondary btn-orange"><i class="fa fa-comment-o"></i> Send</button>
            </div>
          </div>
        </div>
      </div>
      <hr class="mt-5">
      <replies-list :replies="comment.replies" :user="user" :user_type="user_type"></replies-list>
    </div>
    <div id="confirmation" ref="confirmation">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-around">
            <button @click="destroy(comment.id)" type="button" name="button" class="btn btn-secondary btn-orange mx-5"><i class="fa fa-trash-o"></i> Confirm</button>
            <button @click="undo" type="button" name="button" class="btn btn-secondary btn-orange mx-5"><i class="fa fa-undo"></i> Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import _ from 'lodash'
import axios from 'axios'
import {TweenMax, Power4, TimelineMax} from "gsap"

import RepliesList from './Comments/RepliesList.vue'
import ReplyNew from './Comments/ReplyNew.vue'

export default {
  name: "comment-single",
  props: ['comment', 'user', 'user_type'],
  data: () => ({
      reply_msg: ''
  }),
  mounted() {
  },
  computed: {
    json_user: function()
    {
        return JSON.parse(this.user);
    }
  },
  methods: {
      confirmation ()
      {
          var vue = this;
          var t1 = new TimelineMax();
          t1.to(this.$refs['comment'], .4, {
              opacity: 0,
              ease: Power4.easeInOut,
              onComplete: function () {
                  vue.$refs['confirmation'].style.display = 'inherit';
              }
          })
          .to(this.$refs['confirmation'], .4, {
              opacity: 1,
              ease: Power4.easeInOut,
          });
      },
      undo ()
      {
          var vue = this;
          var t1 = new TimelineMax();
          t1.to(this.$refs['confirmation'], .4, {
              opacity: 1,
              ease: Power4.easeInOut,
              onComplete: function () {
                  vue.$refs['confirmation'].style.display = 'none';
              }
          })
          .to(this.$refs['comment'], .4, {
              opacity: 1,
              ease: Power4.easeInOut
          });
      },
      destroy (id)
      {
          var vue = this;

          var formData = new FormData();
          formData.append('id', id);
          formData.append('user_id', this.json_user.id);
          formData.append('user_type', this.user_type);

          axios.post('/api/v1/destroy-comment', formData)
          .then(function(response){
              // console.log(response);
              if (response.data.success) {
                  vue.$parent.$emit('commentDelete', id);
              }
          })
          .catch(function (error) {
              console.log(error);
          });
      },

      // reply
      newReply()
      {
          this.$refs['newReply'].style.display = 'inherit';
          var t1 = new TimelineMax();
          t1.to(this.$refs['newReply'], .4, {
              height: '100%',
              opacity: 1
          });
      },

      closeReply()
      {
          var vue = this;
          var t1 = new TimelineMax();
          t1.to(this.$refs['newReply'], .2, {
              opacity: 0,
          })
          .to(this.$refs['newReply'], .2, {
              height: 0,
              onComplete: function () {
                  vue.$refs['newReply'].style.display = 'none';
              }
          });
      },
      sendReply()
      {
          var vue = this;
          var formData = new FormData();
          formData.append('comment', this.reply_msg);
          formData.append('user', this.user);
          formData.append('user_type', this.user_type);
          formData.append('commentable_type', 'App\\Comment');
          formData.append('commentable_id', this.comment.id);

          axios.post('/api/v1/send-comment', formData)
          .then(function(response){
            console.log(response);
            vue.comment.replies.push(response.data);
            vue.closeReply();
          })
          .catch(function (error) {
            console.log(error);
            vue.loaderStop();
          });
      },
  },
  components: {
    RepliesList
  }
}
</script>
<style lang="scss" scoped>

  #confirmation {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
    opacity: 0;
  }

  #reply {
    display: none;
    height: 0;
    opacity: 0;
  }

</style>
