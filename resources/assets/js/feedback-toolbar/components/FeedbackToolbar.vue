<template>
  <div id="feedback-toolbar">
    <div
      class="feedback-tooltip"
      ref="feedback_tooltip"
    >
      Leave your ideas or you comments
    </div>
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
      <div
        class="dialog-title"
        ref="dialog_title"
      >
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
          <button
            class="btn btn-danger"
            @click="setNegative"
          >
            <i class="fa fa-thumbs-down"/>
          </button>
          <button
            class="btn btn-success"
            @click="setPositive"
          >
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
            class="btn btn-custom"
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
import scrollMonitor from 'scrollmonitor'

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
    button_color: {
      type: Boolean,
      default: false
    }
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
        if (this.button_color) {
          TweenMax.to('.feedback-bg', .3, {
            backgroundColor: 'rgb(37, 37, 37)', // tfc-green-var
            color: 'rgb(149, 226, 218)',
            border: '1px solid rgba(37, 37, 37, 0)',
            ease: Power4.easeInOut
          })
        } else {
          var t1 = new TimelineMax()
          t1.to('.feedback-bg', .3, {
            backgroundColor: 'rgb(149, 226, 218)', // tfc-green-var
            color: 'rgb(37, 37, 37)',
            border: '1px solid rgba(37, 37, 37, 0)',
            ease: Power4.easeInOut
          })

          var t2 = new TimelineMax()
          t2.to(this.$refs.feedback_tooltip, .2, {
            color: 'rgb(183, 204, 94)',
            ease: Power4.easeInOut
          })
            .to(this.$refs.feedback_tooltip, .2, {
              color: 'rgb(233, 200, 69)',
              ease: Power4.easeInOut
            })
            .to(this.$refs.feedback_tooltip, .2, {
              color: 'rgb(166, 219, 226)',
              ease: Power4.easeInOut
            })
            .to(this.$refs.feedback_tooltip, .2, {
              color: 'rgb(232, 163, 96)',
              ease: Power4.easeInOut
            })
            .to(this.$refs.feedback_tooltip, .2, {
              color: 'rgb(149, 226, 218)',
              ease: Power4.easeInOut
            })

        }
      } else {
        return false
      }
    },
    mouseLeave: function()
    {
      if (!this.status) {
        if (this.button_color) {
          TweenMax.to('.feedback-bg', .4, {
            backgroundColor: 'rgb(149, 226, 218)', // tfc-dark-green-var
            color: 'rgb(37, 37, 37)',
            border: '1px solid rgba(37, 37, 37, 0)',
            ease: Power4.easeInOut
          })
        } else {
          TweenMax.to('.feedback-bg', .4, {
            backgroundColor: 'rgba(149, 226, 218, 0)', // tfc-dark-green-var
            color: 'rgb(37, 37, 37)',
            border: '1px solid rgba(37, 37, 37, 1)',
            ease: Power4.easeInOut
          })

          TweenMax.to(this.$refs.feedback_tooltip, .4, {
            color: 'rgb(37, 37, 37)',
            ease: Power4.easeInOut
          })
        }

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
        ease: Power4.easeInOut
      })
        .staggerTo([this.$refs.dialog_title, this.$refs.dialog_content], .4, {
          delay: .1,
          opacity: 1,
          display: 'flex'
        }, .1)

      this.status = true
    },
    closeDialog: function()
    {
      var t1 = new TimelineMax()
      t1.to([this.$refs.dialog_title, this.$refs.dialog_content], .4, {
        opacity: 0,
        display: 'none'
      })
        .to(this.$refs.feedback_dialog, .4, {
          width: '4rem',
          height: '4rem',
          ease: Power4.easeInOut
        })
        .to(this.$refs.feedback_dialog, .4, {
          opacity: 0,
          ease: Power4.easeInOut
        })
        .set(this.$refs.feedback_dialog, {
          display: 'none',
          onComplete: this.mouseLeave
        })

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
      data.append('location', window.location.href)

      var vue = this
      axios.post('/api/v1/send-feedback', data)
        .then(() => {
          vue.comment = ''
          vue.closeDialog()
        })
    },
    scrolling: function()
    {
      var elementWatcher = scrollMonitor.create('footer')

      elementWatcher.enterViewport(() => {
        this.button_color = false
        this.showTooltip()
        this.mouseLeave()
      })

      elementWatcher.exitViewport(() => {
        this.button_color = true
        this.hideTooltip()
        this.mouseLeave()
      })
    },
    showTooltip: function()
    {
      TweenMax.to(this.$refs.feedback_tooltip, .4, {
        opacity: 1,
        display: 'block',
        ease: Power4.easeInOut
      })
    },
    hideTooltip: function()
    {
      TweenMax.to(this.$refs.feedback_tooltip, .4, {
        opacity: 0,
        display: 'none',
        ease: Power4.easeInOut
      })
    }
  },
  mounted()
  {
    this.scrolling()
  }
}
</script>
<style lang="scss" scoped>
  @import '~styles/variables';

  #feedback-toolbar {
    position: relative;

    > .feedback-tooltip {
      position: relative;
      bottom: - ($spacer * 3 / 2);
      left: $spacer * 3;
      width: 100%;
      text-transform: uppercase;
      font-family: $font-family-base;
      font-weight: 900;

      display: none;
      opacity: 0;
    }

    > .feedback-bg {
      position: relative;
      margin-bottom: $spacer / 2;
      margin-left: $spacer / 2;
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
      bottom: 0;
      left: $spacer / 2;
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

        display: none;
        opacity: 0;

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
            background-color: $tfc-dark-green-var;
            color: $black;

            &:hover {
              color: $tfc-green-var;
              background-color: $black;
            }
          }
        }
      }
    }
  }

</style>
