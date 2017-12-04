<template>
  <a
    id="notifications-menu"
    :class="'nav-link '+menu_class"
    href="#"
    @click="toggleDropdown"
  >
    <div class="notification-container">
      <i class="fa fa-bell"/>
      <div class="notification-badge" v-if="this.notifications.length > 0">
        <div class="notification-text">
          {{ this.notifications.length }}
        </div>
      </div>
    </div>
  </a>
</template>
<script>

export default {
  name: 'NotificationsMenu',
  props: {
    notifications: {
      default: function() {},
      type: Array
    }
  },
  computed: {
    menu_class: function()
    {
      if (this.notifications.length == 0) {
        return 'disabled'
      }
    }
  },
  methods: {
    toggleDropdown: function()
    {
      this.$root.$emit('toggle-notifications-dropdown')
    },
  }
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';

  .notification-container {
    position: relative;

    >.notification-badge {
      position: absolute;
      width: ($spacer / 3) * 2;
      height: ($spacer / 3) * 2;
      background-color: $tfc-dark-red;
      border-radius: 50%;
      top: -.5rem;
      right: -.75rem;

      >.notification-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: ($font-size-base / 3) * 2;
        color: $nav-gray;
      }
    }
  }

</style>
