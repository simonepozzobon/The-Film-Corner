<template>
  <div id="notification-single" ref="notification_bg">
    <div class="notification-content">
      <div class="icon-left">
        <div class="icon_bg" ref="icon_bg">
          <i class="fa fa-exclamation" ref="icon"/>
        </div>
      </div>
      <div class="divider" ref="divider"/>
      <div class="notification" ref="notification">
        <div class="name">
          {{ notification.notification.data.sender.name }},
        </div>
        <div class="message">
          {{ notification.message }}
        </div>
      </div>
      <div class="close-notification" ref="close_btn">
        <i class="fa fa-times" @click="dismissNotification"/>
      </div>
    </div>
  </div>
</template>
<script>
import {TimelineMax, Power4} from 'gsap'

export default {
  name: 'NotificationSingle',
  props: {
    notification: {
      default: function() {},
      type: [Array, Object]
    }
  },
  data: () => ({

  }),
  mounted() {
    this.showNotification()
    // setTimeout(this.dismissNotification, 10000)
  },
  methods: {
    showNotification: function() {
      var icon_bg = new TimelineMax()
      icon_bg.to(this.$refs.icon_bg, .4, {
        opacity: 1,
        width: '4rem',
        height: '4rem',
      })

      var icon = new TimelineMax()
      icon.to(this.$refs.icon, .4, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })

      var divider = new TimelineMax()
      divider.to(this.$refs.divider, .8, {
        height: '4rem',
        easing: Power4.easeInOut
      })

      var close_btn = new TimelineMax()
      close_btn.fromTo(this.$refs.close_btn, .6, {
        x: '+=100px',
        opacity: 0,
      }, {
        x: 0,
        rotation: '-=360',
        opacity: 1,
        display: 'inherit'
      })

      var notification_content = new TimelineMax()
      notification_content.to(this.$refs.notification, .4, {
        opacity: 1,
      })

      var notification_bg = new TimelineMax()
      notification_bg.to(this.$refs.notification_bg, .4, {
        opacity: 1,
      })

      var master = new TimelineMax()
      master.add(notification_bg)
      master.add(notification_content)
      master.add(divider, .4)
      master.add(close_btn, .4)
      master.add(icon_bg, .4)
      master.add(icon, .8)
      master.play()
    },
    dismissNotification: function()
    {
      var vue = this

      var icon_bg = new TimelineMax()
      icon_bg.to(this.$refs.icon_bg, .4, {
        opacity: 0,
        width: 0,
        height: 0,
      })

      var icon = new TimelineMax()
      icon.to(this.$refs.icon, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var divider = new TimelineMax()
      divider.to(this.$refs.divider, .8, {
        height: 0,
        easing: Power4.easeInOut
      })

      var close_btn = new TimelineMax()
      close_btn.to(this.$refs.close_btn, .6, {
        x: '+=100px',
        opacity: 0,
        rotation: '+=360',
        display: 'none'
      })

      var notification_content = new TimelineMax()
      notification_content.to(this.$refs.notification, .4, {
        opacity: 0,
      })

      var notification_bg = new TimelineMax()
      notification_bg.to(this.$refs.notification_bg, .4, {
        opacity: 0,
      })

      var callback = new TimelineMax()
      callback.to(this, 1, {
        onComplete: () => {
          vue.$root.$emit('notification-dismissed', this.notification)
        }
      })

      var master = new TimelineMax()
      master.add(icon)
      master.add(icon_bg)
      master.add(close_btn)
      master.add(divider)
      master.add(notification_content, .8)
      master.add(notification_bg, .8)
      master.add(callback, 1)
      master.play()

    },
  }

}
</script>
<style lang="scss" scoped>
@import '~styles/variables';

  #notification-single {
    position: fixed;
    top: ($spacer / 2) + 5.625;
    right: $spacer / 2;
    background: $tfc-green;
    z-index: 9;
    opacity: 0;

    >.notification-content {
      display: flex;
      padding: $spacer;
      align-items: center;

      >.icon-left {
        margin-right: $spacer / 2;

        >.icon_bg {
          position: relative;
          width: 0;
          height: 0;
          opacity: 0;
          border-radius: 50%;
          background-color: $tfc-dark-green;

          > i  {
            position: absolute;
            color: $tfc-green;
            font-size: ($font-size-base / 2) * 3;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
          }
        }
      }

      >.divider {
        height: 0;
        border-left: 1px solid $tfc-dark-green;
        margin-right: $spacer / 2;
      }

      >.notification {
        margin-right: $spacer / 2;
        opacity: 0;

        >.name {
          font-size: 1.125rem;
          font-weight: bold;
          text-transform: uppercase;
        }
      }

      >.close-notification {
        display: none;
        opacity: 0;
        color: $tfc-dark-green;
        font-size: 1.25rem;
        align-self: flex-start;
      }
    }
  }

</style>
