<template>
  <div id="notification" class="row align-items-center" @mouseenter="showDelete" @mouseleave="hideDelete">
    <div class="col">
      <div class="wrapper">
        <div class="icons-left">
          <i class="fa fa-exclamation text-danger"></i>
        </div>
        <div class="description">
          Randy Casey - Frame Composer
        </div>
        <div class="icons-right" ref="icons_right">
          <i class="fa fa-times text-muted"></i>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {TweenMax, Power4} from 'gsap'

export default {
  name: 'Notification',
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
