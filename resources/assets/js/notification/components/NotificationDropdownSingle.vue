<template>
  <div id="notification-dropdown-single">
    <a :href="'/teacher/'+section_slug+'/'+app_cat_slug+'/'+app_slug+'/'+token" @click="markAsRead">
      <i class="fa fa-globe"/> -
      <span>{{ notification.data.session.student.name }}</span>, sent you a new notification
    </a>
  </div>
</template>
<script>
export default {
  name: 'NotificationDropdownSingle',
  props: {
    notification: {
      default: function() {},
      type: Object
    }
  },
  computed: {
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
  methods: {
    markAsRead: function()
    {
      this.$root.$emit('mark-as-read', this.notification)
    }
  },
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';

  #notification-dropdown-single {
    padding-bottom: $spacer / 4;
    border-bottom: 2px dashed $gray-lightest;
    font-size: $font-size-base;
    font-weight: $font-weight-normal;

    > a {
      color: $black;

      > span {
        text-transform: capitalize;
      }
    }
  }

</style>
