<template>
  <div id="notification" class="row align-items-center" @mouseenter="showDelete" @mouseleave="hideDelete">
    <div class="col">
      <div class="wrapper">
        <div class="icons-left">
          <i v-if="this.status" class="fa fa-check text-success"></i>
          <i v-else class="fa fa-exclamation text-danger"></i>
        </div>
        <div class="description">
          {{ this.notification.data.session.student.name }} - {{ this.notification.data.session.app.title }}
        </div>
        <div class="icons-right" ref="icons_right">
          <i class="fa fa-times text-muted" @click="deleteNotification"></i>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {TweenMax, Power4} from 'gsap'
import axios from 'axios'

export default {
  name: 'Notification',
  props: {
    'notification': {
      default: function() {},
      type: [Object, Array]
    }
  },
  computed: {
    status: function()
    {
      if (this.notification.read_at != null)
      {
        return true
      }
      else {
        return false
      }
    }
  },
  data: () => ({

  }),
  methods: {
    showDelete: function()
    {
      TweenMax.to(this.$refs.icons_right, .4, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })
    },
    hideDelete: function()
    {
      TweenMax.to(this.$refs.icons_right, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })
    },
    deleteNotification: function()
    {
      var vue = this
      var data = new FormData()
      data.append('id', this.notification.id)

      axios.post('/teacher/notifications/destroy', data)
        .then(() => {
          vue.$root.$emit('notification-deleted', this.notification)
        })
    }
  }
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';

  #notification {
    margin-bottom: $spacer * 3 / 4;

    >.col {
      >.wrapper {
        display: flex;
        padding-bottom: $spacer / 3;
        border-bottom: 2px dashed $tfc-dark-blue;

        > .icons-left {
          margin-right: $spacer * 3 / 4;
          width: $spacer;
          text-align: center;
        }

        >.icons-right {
          margin-left: auto;
          display: none;
          opacity: 0;

          > i {
            margin-left: $spacer / 2;
          }
        }
      }
    }
  }

</style>
