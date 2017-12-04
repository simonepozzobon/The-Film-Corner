<template>
  <div
    id="notifications-dropdown"
    ref="dropdown"
  >
    <notification-dropdown-single
      v-for="notification in notifications"
      :key="notification.key"
      :notification="notification"
      class="notif"
    />
  </div>
</template>
<script>
import NotificationDropdownSingle from './NotificationDropdownSingle.vue'

import {TweenMax, Power4} from 'gsap'

export default {
  name: 'NotificationsDropdown',
  props: {
    notifications: {
      default: function() {},
      type: Array
    }
  },
  data: () => ({
    status: false,
  }),
  created: function()
  {
    this.$root.$on('toggle-notifications-dropdown', () => {
      this.toggleDropdown()
    })
  },
  methods: {
    toggleDropdown: function()
    {
      if (this.status) {
        this.hideDropdown()
      } else {
        this.showDropdown()
      }
    },
    hideDropdown: function()
    {
      TweenMax.to(this.$refs.dropdown, .6, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      this.status = false
    },
    showDropdown: function()
    {
      TweenMax.to(this.$refs.dropdown, .6, {
        opacity: 1,
        display: 'block',
        easing: Power4.easeInOut
      })
      this.status = true
    }
  },
  components: {
    NotificationDropdownSingle
  }
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';

  #notifications-dropdown {
    position: absolute;
    top: ($spacer / 2) + 5.625;
    right: $spacer / 2;
    background: $nav-gray;
    padding-left: $spacer;
    padding-right: $spacer;
    padding-top: $spacer / 2;
    padding-bottom: $spacer / 2;
    z-index: 8;
    border: 2px solid $gray-lightest;
    display: none;
    opacity: 0;

    >.notif {
      margin-bottom: $spacer / 2;
      margin-top: $spacer / 2;
    }
  }

  #notifications-dropdown::before {
    position: absolute;
    content: '';
    top: -($spacer / 4) - 0.1;
    right: ($spacer * 2) + 0.75;
    width: $spacer / 2;
    height: $spacer / 2;
    background-color: $nav-gray;
    transform: rotate(-45deg);
    border-top: 2px solid $gray-lightest;
    border-right: 2px solid $gray-lightest;
  }

</style>
