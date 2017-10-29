<template>
  <div id="">
    <div class="row py-4">
      <div class="col">
        <h4 ref="eye" class="text-center"><i class="fa fa-eye" aria-hidden="true"></i></h4>
      </div>
      <div class="col">
        <h4 ref="heart" class="text-center" @click="heartClick"><i class="fa fa-heart" aria-hidden="true"></i></h4>
      </div>
      <div class="col">
        <h4 ref="comment" class="text-center">{{ this.comments }} <i class="fa fa-comment" aria-hidden="true"></i></h4>
      </div>
    </div>
  </div>
</template>
<script>
import mojs from 'mo-js'

export default {
  name: "network-icons",
  props: ['comments'],
  data: () => ({

  }),
  mounted() {
    //do something after mounting vue instance

  },
  methods: {
    heartClick (e)
    {
      var el = e.target;
      var blink = new mojs.Burst({
        parent: e.target,
        count: 8,
        y: -5,
        radius: {0 : 35},
        children: {
          stroke: 'red',
          strokeLinecap: 'round',
          shape: 'circle',
          strokeWidth: {0 : 15},
          radius: {0 : 10},
          opacity: {0 : 1}
        }
      }).play();

      var heart = new mojs.Tween({

      }).play();
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
