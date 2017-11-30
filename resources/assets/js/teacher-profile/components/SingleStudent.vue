<template>
  <div id="single-student" @mouseover="showInfoIcon" @mouseleave="hideInfoIcon" @click="showUserDetail">
    <i ref="user" class="fa fa-user"/>
    <i id="info-icon" ref="info" class="fa fa-info"/>
  </div>
</template>
<script>
import {TimelineMax, Power4} from 'gsap'

export default {
  name: 'SingleStudent',
  props: {
    student: {
      type: Object,
      default: () => {}
    }
  },
  data: () => ({

  }),
  methods: {
    showInfoIcon: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.user, .2, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.info, .2, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2)
      master.play()
    },

    hideInfoIcon: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.user, .2, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.info, .2, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t2)
      master.add(t1)
      master.play()
    },

    showUserDetail: function()
    {
      this.$parent.$emit('show-user-detail', this.student)
    }
  },
}
</script>
<style lang="scss" scoped>
  @import '~styles/variables';

  #single-student {
    width: $spacer * 2;
    height: $spacer * 2;
    background-color: $tfc-dark-yellow;
    color: $black;
    border-radius: 50%;
    position: relative;

    > i {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    &:hover{
      background-color: $black;
      border: 2px solid $tfc-dark-yellow;

      > i {
        color: $tfc-yellow;
      }
    }
  }

  #info-icon {
    display: none;
    opacity: 0;
  }

</style>
