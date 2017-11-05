<template>
  <div class="feedback-popup">
    <div @mouseover="hover" @mouseleave="leave" @click="openModal" id="info-btn" class="d-block pl-4" ref="btn">
      <svg id="svg-btn" width="130px" height="60px" viewBox="0 0 160 74" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <path id="Rectangle" d="M0,8.95230229 C0,6.76923102 1.72792468,5 3.86114055,5 C3.86114055,5 31.9305703,5 60,5 L116.138859,5 C118.270664,5 120,6.77092572 120,8.95230229 C120,8.95230229 120,19.4761511 120,30 C120,40.5238489 120,51.0476977 120,51.0476977 C120,53.230769 118.272075,55 116.138859,55 L60,55 C31.9305703,55 3.86114055,55 3.86114055,55 C1.729336,55 0,53.2290743 0,51.0476977 L0,30 L0,8.95230229 Z" stroke="none" fill-rule="evenodd"></path>
      </svg>
      <a id="btn" class="text-white text-align-center pl-5">
        <i class="fa fa-info"></i> <b>Info</b>
      </a>
    </div>
  </div>
</template>

<script>

import {TweenMax, Power4, Elastic, TimelineMax} from 'gsap'
import _ from 'lodash'

export default {
  name: "feedback-popup",
  data: () => ({

  }),
  mounted() {
      //do something after mounting vue instance
      var vue = this;
      _.delay(function() {
        vue.init();
      }, 500);
  },
  methods: {
      hover ()
      {
          TweenMax.to('#Rectangle', .2, {
              fill: 'rgb(254, 38, 40)',
              ease: Power4.easeInOut
          })
      },

      leave()
      {
          TweenMax.to('#Rectangle', .2, {
              fill: 'rgb(254, 89, 90)',
              ease: Power4.easeInOut
          });
      },

      init()
      {
          var rectangle = new TimelineMax();
          rectangle.fromTo('#Rectangle', .6, {
              opacity: 0.9,
              x: -100,
              scale: 1.05,
              attr: {
                  d: 'M0,8.95230229 C0,6.76923102 1.72792468,5 3.86114055,5 C3.86114055,5 31.9305703,2 60,2 L115.138859,2 C117.270664,2 122,4.77092572 125,9.95230229 C125,9.95230229 130,19.4761511 130,30 C130,40.5238489 125,50.0476977 125,50.0476977 C122,55.230769 117.272075,58 115.138859,58 L60,58 C31.9305703,58 3.86114055,55 3.86114055,55 C1.729336,55 0,53.2290743 0,51.0476977 L0,30 L0,8.95230229 Z'
              }
          }, {
              x: 0,
              scale: 1,
              opacity: 1,
              attr: {
                  d: 'M0,8.95230229 C0,6.76923102 1.72792468,5 3.86114055,5 C3.86114055,5 31.9305703,5 60,5 L116.138859,5 C118.270664,5 120,6.77092572 120,8.95230229 C120,8.95230229 120,19.4761511 120,30 C120,40.5238489 120,51.0476977 120,51.0476977 C120,53.230769 118.272075,55 116.138859,55 L60,55 C31.9305703,55 3.86114055,55 3.86114055,55 C1.729336,55 0,53.2290743 0,51.0476977 L0,30 L0,8.95230229 Z'
              },
              ease: Elastic.easeInOut.config(1.2, .8)
          })
          .to('#Rectangle', .6, {
              opacity: 1,
              x: 0,
              scaleX: 1,
              attr: {
                  d: 'M0,8.95230229 C0,6.76923102 1.72792468,5 3.86114055,5 C3.86114055,5 31.9305703,5 60,5 L116.138859,5 C118.270664,5 120,6.77092572 120,8.95230229 C120,8.95230229 120,19.4761511 120,30 C120,40.5238489 120,51.0476977 120,51.0476977 C120,53.230769 118.272075,55 116.138859,55 L60,55 C31.9305703,55 3.86114055,55 3.86114055,55 C1.729336,55 0,53.2290743 0,51.0476977 L0,30 L0,8.95230229 Z'
              },
              ease: Elastic.easeOut.config(1.2, .8)
          });

          var text = new TimelineMax();
          text.fromTo('#btn', .3, {
              opacity: 0
          },{
              opacity: 1,
              ease: Power4.easeInOut
          });

          var master = new TimelineMax();
          master.add(rectangle);
          master.add(text, .6);
          master.play();
      },

      openModal()
      {
          this.$parent.$emit('modalOpen', '#info');
      }
  }
}
</script>

<style lang="scss" scoped>

  #info-btn {
    // opacity: 0;
    margin-left: -2rem;
  }

  #Rectangle {
    fill: rgb(254, 89, 90);
    opacity: 0;
  }

  #btn {
    opacity: 0;
    position: absolute;
    top: calc(50% - 20px);
    left: -15px;
  }

  #btn, #Rectangle {
    cursor: pointer;
  }

  #svg-btn {
    width: inherit !important;
    height: inherit !important;
  }

</style>
