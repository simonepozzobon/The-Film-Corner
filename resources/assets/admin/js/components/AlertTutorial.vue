<template>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="box container-fluid mb-4" ref="alert">
        <div class="row">
          <div :class="'col dark-'+color+' py-3 px-5'">
            <h3>{{title}}</h3>
          </div>
        </div>
        <div class="row">
          <div :class="'col '+color+' p-5'">
            <slot></slot>
            <div class="pt-5 d-flex justify-content-around">
              <a @click="removeAlert" href="#" :class="'btn btn-'+color+' btn-lg'">Ok ho capito</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import mojs from 'mo-js';
import _ from 'lodash'

export default {
  props: ['title', 'color', 'element', 'position'],
  data: () => ({
      el: '',
      pos: '',
  }),
  mounted() {
    var vue = this;

    this.el = document.getElementById(this.element);
    this.left = this.getOffsetLeft(this.el);
    this.top = this.getOffsetTop(this.el);

    this.burst = new mojs.Burst({
      top: 0,
      left: 0,
      count: 8,
      x: this.left + (this.el.offsetWidth / 2),
      y: this.top + (this.el.offsetHeight / 2),
      children: {
        shape: 'line',
        stroke: '#e9c845'
      },
      onComplete() {
        this.replay();
      }
    }).play();

  },
  methods: {
    removeAlert()
    {
      var vue = this;


      this.alert = new mojs.Html({
        el: this.$refs['alert'],
        opacity: {1 : 0}
      }).then({
        height: {[this.$refs['alert'].offsetHeight] : 0},
        onComplete() {
          vue.burst.stop();
          vue.deleteEl(this.el);
        }
      }).play();
    },

    getOffsetLeft (elem)
    {
        var offsetLeft = 0;
        do {
          if ( !isNaN( elem.offsetLeft ) )
          {
              offsetLeft += elem.offsetLeft;
          }
        } while( elem = elem.offsetParent );
        return offsetLeft;
    },

    getOffsetTop (elem)
    {
        var offsetTop = 0;
        do {
          if ( !isNaN( elem.offsetTop ) )
          {
              offsetTop += elem.offsetTop;
          }
        } while( elem = elem.offsetParent );
        return offsetTop;
    },

    deleteEl(el) {
        if (el) {
             el.parentNode.removeChild(el);
        }
    },
  }
}
</script>
<style lang="scss" scoped>
  // :not(#dont-blur-me-bro)
</style>
