<template>
  <div id="">
    <!-- New Comment -->
      <div id="new-comment-btn">
        <div class="form-group d-flex justify-content-center">
          <button @click="show" type="button" name="button" class="btn btn-secondary btn-orange"><i class="fa fa-comment-o"></i> New Comment</button>
        </div>
      </div>
      <!-- New Comment Form -->
      <div id="loading" class="loading">
        <div id="square" class="square"></div>
      </div>
        <div id="new-comment">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <button @click="close" id="close" type="button" class="close mb-3">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
              <div class="form-group">
                <textarea v-model="comment" name="comment" class="form-control"></textarea>
              </div>
              <div class="form-group d-flex justify-content-center pt-2">
                <button @click="sendComment" type="button" name="button" class="btn btn-secondary btn-orange"><i class="fa fa-comment-o"></i> Send</button>
              </div>
            </div>
          </div>
        </div>
        <hr class="mt-5">
      <!-- End of new comment Form -->
    <!-- End of new comment -->
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
