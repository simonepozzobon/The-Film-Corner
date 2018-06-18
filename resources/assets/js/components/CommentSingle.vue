<template>
    <div class="col">
          <div :class="'box '+color">
              <div class="box-header">
                <div class="title">
                  {{ comment.author.name }}

                </div>
                <div class="time">
                  {{ comment.time }}
                </div>
              </div>
              <div class="box-body" ref="comment">
                {{ comment.comment }}
              </div>
              <div id="confirmation" class="box-btns pt" ref="confirmation">
                <button @click="destroy(comment.id)" type="button" name="button" :class="'btn btn-'+color"><i class="fa fa-trash-o"></i> Confirm</button>
                <button @click="undo" type="button" name="button" :class="'btn btn-'+color"><i class="fa fa-undo"></i> Cancel</button>
              </div>
              <div class="box-btns">
                <button @click="confirmation" type="button" name="button" :class="'btn btn-'+color"><i class="fa fa-trash-o"></i> Delete</button>
                <button @click="newReply" type="button" name="button" :class="'btn btn-'+color"><i class="fa fa-comments-o"></i> Reply</button>
              </div>
          </div>
          <div id="reply" :class="'box mt '+reply_color" ref="newReply">
            <div class="box-header">
              <div class="title">
                Reply to {{ comment.author.name }}
              </div>
              <div class="icon" ref="close" @click="closeReply">
                <i class="fa fa-times"></i>
              </div>
            </div>
            <div class="box-body">
              <textarea v-model="reply_msg" name="comment" class="form-control"></textarea>
            </div>
            <div class="box-btns">
              <button @click="sendReply" type="button" name="button" :class="'btn btn-'+reply_color"><i class="fa fa-comment-o"></i> Send</button>
            </div>
          </div>
          <replies-list :replies="comment.replies" :user="user" :user_type="user_type"></replies-list>
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
      reply_msg: '',
      color: '',
      reply_color: ''
  }),
  mounted() {
    this.colors = ['green', 'yellow', 'orange', 'blue'];
    this.index = Math.floor(Math.random() * 3);
    this.color = this.colors[this.index];
    this.reply_color = this.colors[(this.index + 1)];
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
          t1.to(this.$refs.comment, .4, {
              opacity: 0,
              ease: Power4.easeInOut,
              onComplete: function () {
                  vue.$refs.comment.style.display = 'none';
                  vue.$refs.confirmation.style.display = 'inherit';
              }
          })
          .to(this.$refs.confirmation, .4, {
              opacity: 1,
              ease: Power4.easeInOut,
              onComplete: function () {
              }
          });
      },
      undo ()
      {
          var vue = this;
          var t1 = new TimelineMax();
          t1.to(this.$refs.confirmation, .4, {
              opacity: 1,
              ease: Power4.easeInOut,
              onComplete: function () {
                  vue.$refs.confirmation.style.display = 'none';
                  vue.$refs.comment.style.display = 'inherit';
              }
          })
          .to(this.$refs.comment, .4, {
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

          // axios.post('/api/v1/destroy-comment', formData)
          // .then(function(response){
          //     // console.log(response);
          //     if (response.data.success) {
          //         vue.$parent.$emit('commentDelete', id);
          //     }
          // })
          // .catch(function (error) {
          //     console.log(error);
          // });
      },

      // reply
      newReply()
      {
          this.$refs.newReply.style.display = 'inherit';
          var t1 = new TimelineMax();
          t1.to(this.$refs.newReply, .4, {
              height: 'auto',
              opacity: 1
          });
      },
      closeReply()
      {
          var vue = this;
          var t1 = new TimelineMax();
          t1.to(this.$refs.newReply, .2, {
              opacity: 0,
          })
          .to(this.$refs.newReply, .2, {
              height: 0,
              onComplete: function () {
                  vue.$refs.newReply.style.display = 'none';
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
            // vue.loaderStop();
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
    display: none;
    opacity: 0;
  }

  .box-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;

    > .time {
      align-self: flex-end;
      font-size: 1rem;
      line-height: 1.62;
      font-weight: normal;
      text-transform: lowercase;
    }
  }

  #reply {
    display: none;
    height: 0;
    opacity: 0;

    > .box-header {
      display: flex;
      flex-direction: row;
      justify-content: space-between;

      >.icon {
        cursor: pointer;
      }
    }
  }

</style>
