<template>
  <div id="feedback-toolbar">
    <div
      class="feedback-bg"
      data-toggle="tooltip"
      data-placement="right"
      data-html="true"
      title="Leave a feedback"
      @mouseenter="mouseEnter"
      @mouseleave="mouseLeave"
      @click="toggleDialog"
    >
      <div class="feedback-content">
        <i class="fa fa-envelope-o"/>
      </div>
    </div>
    <div
      class="feedback-dialog"
      ref="feedback_dialog"
    >
      <div class="dialog-title">
        <div class="text">
          Leave a Feedback to The Film Corner
        </div>
        <div
          class="icon"
          @click="toggleDialog"
        >
          <i class="fa fa-times"/>
        </div>
      </div>
      <div
        class="dialog-content"
        ref="dialog_content"
      >
        <div class="valutation">
          <button class="btn btn-danger" @click="setNegative">
            <i class="fa fa-thumbs-down"/>
          </button>
          <button class="btn btn-success" @click="setPositive">
            <i class="fa fa-thumbs-up"/>
          </button>
        </div>
        <div class="comment">
          <div class="form-group">
            <textarea
              class="form-control"
              placeholder="Your comment or idea..."
              v-model="comment"
            />
          </div>
        </div>
        <div class="btns">
          <button
            class="btn btn-primary"
            @click="sendFeedback"
          >
            <i class="fa fa-paper-plane"/>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {TimelineMax, TweenMax, Power4} from 'gsap'
import axios from 'axios'

export default {
  name: 'FeedbackToolbar',
  props: {
    user: {
      default: '',
      type: String
    },
    user_type: {
      default: '',
      type: String
    }
  },
  data: () => ({
    status: false,
    valutation: 'positive',
    comment: '',
  }),
  computed: {
    userParsed: function()
    {
      return JSON.parse(this.user)
    }
  },
  methods: {
    mouseEnter: function()
    {
      if (!this.status) {
        TweenMax.to('.feedback-bg', .4, {
          backgroundColor: 'rgb(189, 237, 231)', // tfc-green-var
          easing: Power4.easeInOut
        })
      } else {
        return false
      }
    },
    mouseLeave: function()
    {
      if (!this.status) {
        TweenMax.to('.feedback-bg', .4, {
          backgroundColor: 'rgb(149, 226, 218)', // tfc-dark-green-var
          easing: Power4.easeInOut
        })
      } else {
        return false
      }
    },
    toggleDialog: function()
    {
      if (!this.status) {
        // open dialog
        this.openDialog()
      } else {
        // close dialog
        this.closeDialog()
      }
    },
    openDialog: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.feedback_dialog, .4, {
        opacity: 1,
        width: '44rem',
        height: '24rem',
        display: 'flex',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.dialog_content, .4, {
        opacity: 1,
        display: 'flex'
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2, .4)
      master.play()

      this.status = true
    },
    closeDialog: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.feedback_dialog, .4, {
        opacity: 0,
        width: 0,
        height: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.dialog_content, .4, {
        opacity: 0,
        display: 'none'
      })

      var master = new TimelineMax()
      master.add(t2)
      master.add(t1, .4)
      master.play()
      this.status = false
    },
    setPositive: function()
    {
      this.valutation = 'positive'
    },
    setNegative: function()
    {
      this.valutation = 'negative'
    },
    sendFeedback: function()
    {
      var data = new FormData()
      data.append('valutation', this.valutation)
      data.append('comment', this.comment)
      data.append('user_id', this.userParsed.id)
      data.append('user_type', this.user_type)

      var vue = this
      axios.post('/api/v1/send-feedback', data)
        .then(() => {
          vue.comment = ''
          vue.closeDialog()
        })
    }
  }
}
</script>
<style lang="scss" scoped>
  @import '~styles/variables';

  #feedback-toolbar {
    position: relative;

    > .feedback-bg {
      position: relative;
      margin-top: $spacer;
      margin-left: $spacer;
      width: $spacer * 2;
      height: $spacer * 2;
      background-color: $tfc-dark-green-var;

      > .feedback-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
    }

    > .feedback-dialog {
      position: absolute;
      top: 0;
      left: $spacer;
      // display: flex;
      flex-direction: column;
      background-color: $tfc-green-var;
      z-index: 1031;

      display: none;
      opacity: 0;

      > .dialog-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: $tfc-dark-green-var;
        padding: $spacer;

        > .text {
          font-family: $font-family-serif;
          font-size: $font-size-h3;
          font-weight: $headings-font-weight;
          text-transform: uppercase;
          color: $black;
          margin-right: $spacer;
        }

        > .icon {
          font-size: $font-size-h3;
          color: $black;
        }
      }

      > .dialog-content {
        // display: flex;
        flex-direction: column;
        padding: $spacer;

        display: none;
        opacity: 0;

        > .valutation {
          display: flex;
          justify-content: center;
          align-items: center;
          padding-bottom: $spacer;

          > button {
            min-width: $spacer * 4;
            color: $white;
            margin-left: $spacer / 2;
            margin-right: $spacer / 2;
          }
        }

        > .comment {
          // padding-bottom: $spacer;
        }

        > .btns {
          display: flex;
          justify-content: center;
          align-items: center;

          > button {
            min-width: $spacer * 4;
          }
        }
      }
    }
  }

</style>
