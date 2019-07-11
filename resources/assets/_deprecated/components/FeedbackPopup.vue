<template>
  <div id="info-popup">
    <a id="btn" href="#" class="btn btn-danger text-white" @click="openModal" ref="btn">
      <i class="fa fa-info"></i> <b>Info</b>
    </a>
  </div>
</template>

<script>

import {TweenMax, Power4, Elastic, TimelineMax} from 'gsap'
import _ from 'lodash'
import axios from 'axios'

export default {
  name: "feedback-popup",
  data: () => ({

  }),
  mounted() {
      var vue = this;
      _.delay(function() {
          vue.init();
      }, 500);
  },
  methods: {
      init()
      {
          var t1 = new TimelineMax();
          t1.fromTo(this.$refs.btn, .6, {
            opacity: 0,
            y: '-=100%',
            easing: Power4.easeInOut
          }, {
            opacity: 1,
            y: '+=105%',
            delay: 1,
            easing: Power4.easeInOut
          })
      },

      openModal()
      {
          this.$parent.$emit('modalOpen', '#info');
      },
  }
}
</script>

<style lang="scss" scoped>

  #info-popup {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
  }

  #btn {
    opacity: 0;
    width: 20rem;
  }

  #Rectangle {
    fill: rgb(254, 89, 90);
    opacity: 0;
  }

</style>
