<template>
  <div id="notification" class="row align-items-center" @mouseenter="showDelete" @mouseleave="hideDelete" @click="markAsRead">
    <div class="col">
      <div class="wrapper">
        <div class="icons-left">
          <i v-if="this.status" class="fa fa-check text-success"></i>
          <i v-else class="fa fa-exclamation text-danger"></i>
        </div>
        <div class="description">
          <span>{{ this.notification.data.sender.name }}</span> - {{ this.notification.data.session.app.title }}
        </div>
        <div class="icons-right" ref="icons_right">
          <a :href="'/teacher/'+section_slug+'/'+app_cat_slug+'/'+app_slug+'/'+token" class="btn btn-sm btn-blue">Open</a>
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
    },
    section_slug: function()
    {
      return this.notification.data.session.app.category.section.slug
    },
    app_cat_slug: function()
    {
      return this.notification.data.session.app.category.slug
    },
    app_slug: function()
    {
      return this.notification.data.session.app.slug
    },
    token: function()
    {
      return this.notification.data.session.token
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
    },
    markAsRead: function()
    {
      this.$root.$emit('notification-mark-as-read', this.notification)
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
        align-items: center;
        padding-bottom: $spacer / 3;
        border-bottom: 2px dashed $tfc-dark-blue;

        > .icons-left {
          margin-right: $spacer * 3 / 4;
          width: $spacer;
          text-align: center;
        }

        >.description {
          >span {
            text-transform: capitalize;
          }
        }

        >.icons-right {
          margin-left: auto;
          align-self: center;
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
