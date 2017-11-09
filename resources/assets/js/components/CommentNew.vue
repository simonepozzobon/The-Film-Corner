<template>
  <div id="" class="row mt">
    <div class="col">
      <div class="box yellow">
        <div class="box-header">
          Join the discussion!
        </div>
        <div class="box-btns pt">
          <div id="loading" class="loading">
            <div id="square" class="square"></div>
          </div>
          <button id="new-comment-btn" @click="show" type="button" name="button" class="btn btn-yellow"><i class="fa fa-comment-o"></i> New Comment</button>
        </div>
      </div>
      <div id="new-comment" class="box mt blue">
        <div class="box-header">
          <div class="title">
            New comment
          </div>
          <div id="close" class="icon" @click="close">
            <i class="fa fa-times"></i>
          </div>
        </div>
        <div class="box-body">
          <textarea v-model="comment" name="comment" class="form-control"></textarea>
        </div>
        <div class="box-btns">
          <button @click="sendComment" type="button" name="button" class="btn btn-blue"><i class="fa fa-comment-o"></i> Send</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios'

import {TweenMax, Power4, TimelineMax} from "gsap"

export default {
  name: "new-comment",
  props: ['csrf_field', 'user', 'user_type', 'commentable_type', 'commentable_id'],
  data: () => ({
    comment: ''
  }),
  mounted() {
    // Timelines
    this.showForm = new TimelineMax();
    this.hideForm = new TimelineMax();
    this.sendForm = new TimelineMax();
    this.loading = new TimelineMax();

    // Elements
    this.newCommentBtn = document.getElementById('new-comment-btn');
    this.newCommentForm = document.getElementById('new-comment');
    this.closeBtn = document.getElementById('close');
    this.loadingEl = document.getElementById('loading');
    this.square = document.getElementById('square');

    // Styles setup
    this.newCommentForm.style.display = 'none';
  },
  methods: {
    // Actions
    sendComment()
    {
      var vue = this;

      this.loader();

      var formData = new FormData();
      formData.append('_token', this.csrf_field);
      formData.append('comment', this.comment);
      formData.append('user', this.user);
      formData.append('user_type', this.user_type);
      formData.append('commentable_type', this.commentable_type);
      formData.append('commentable_id', this.commentable_id);

      axios.post('/api/v1/send-comment', formData)
      .then(function(response){
        // console.log(response);
        vue.$parent.$emit('newComment', response.data);
        vue.loaderStop();
        vue.comment = '';
      })
      .catch(function (error) {
        console.log(error);
        vue.loaderStop();
      });
    },

    // Animations
    show()
    {
        var vue = this;

        this.showForm
        .to(this.newCommentBtn, .4, {
          opacity: 0,
          height: 0,
          ease: Power4.easeInOut,
          onComplete: function () {
            vue.newCommentForm.style.display = 'inherit';
          }
        })
        .fromTo(this.newCommentForm, .4, {
            opacity: 0,
            height: 0
          }, {
            opacity: 1,
            height: '100%',
            ease: Power4.easeInOut
        }).play();
    },
    close()
    {
        var vue = this;

        this.hideForm
        .to(this.newCommentForm, .4, {
          opacity: 0,
          height: 0,
          ease: Power4.easeInOut,
          onComplete: function () {
            vue.newCommentForm.style.display = 'none';
          }
        })
        .to(this.newCommentBtn, .4, {
          opacity: 1,
          height: '100%',
          ease: Power4.easeInOut,
        })
    },
    loader()
    {
        var vue = this;

        this.sendForm
        .to(this.newCommentForm, .4, {
            opacity: 0,
            ease: Power4.easeInOut,
            onComplete: function () {
                vue.loadingEl.style.display = 'inherit';
            }
        }).play();

        this.loading
        .to(this.square, 1, {
            rotation: 360,
            borderRadius: '5%'
        })
        .to(this.square, 1, {
            rotation: -360,
            borderRadius: '50%',
            onComplete: function () {
                vue.loading.restart();
            }
        }).play();
    },
    loaderStop()
    {
      var vue = this;

      this.loading.pause();
      TweenMax.to(this.square, 1, {
          rotation: 0,
          borderRadius: '50%',
          onComplete: function () {
              vue.loadingEl.style.display = 'none';
              var t1 = new TimelineMax();
              t1.to(vue.newCommentForm, .4, {
                  opacity: 0,
                  height: 0,
                  ease: Power4.easeInOut,
              })
              .to(vue.newCommentBtn, .4, {
                opacity: 1,
                height: '100%',
                ease: Power4.easeInOut,
                onComplete: function () {
                  vue.newCommentForm.style.display = 'none';
                }
              });
          }
      });
    }
  }
}
</script>
<style lang="scss" scoped>

  #new-comment {
    .box-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;

      > .icon {
        cursor: pointer;
      }
    }
  }

  .loading {
    position: relative;
    display: none;
  }

  .square {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 4rem;
    height: 4rem;
    background: #e8a360;
    border-radius: 50%;
  }
</style>
