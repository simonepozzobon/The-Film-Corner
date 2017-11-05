<template>
  <div :id="token">
    <div class="row py-4">
      <div class="col">
        <h4 ref="eye" class="text-center">1234 <i class="fa fa-eye" aria-hidden="true"></i></h4>
      </div>
      <div class="col">
        <h4 ref="heart" class="text-center" @click="heartClick(token, $event)">{{ this.counter }} <i class="fa fa-heart" aria-hidden="true"></i></h4>
      </div>
      <div class="col">
        <h4 ref="comment" class="text-center">{{ this.comments }} <i class="fa fa-comment" aria-hidden="true"></i></h4>
      </div>
    </div>
  </div>
</template>
<script>
import mojs from 'mo-js'
import {TweenMax, Power4, Elastic, TimelineMax} from 'gsap'

export default {
  name: "network-icons",
  props: ['comments', 'token', 'likes'],
  data: () => ({
    liked: '',
    counter: ''
  }),
  mounted() {
    this.counter = this.likes;
  },
  methods: {
    heartClick (token, e)
    {
        // if not yet liked
        if (!this.liked) {
            this.counter++;
            this.liked = true;

            var t1 = new TimelineMax();
            t1.to(this.$refs.heart, .4, {
                color: 'rgb(254, 89, 90)'
            });

            var t2 = new TimelineMax();
            t2.to(this.$refs.heart, .2, {
                scale: 1.2,
                ease: Power4.easeOut
            })
            .to(this.$refs.heart, .2, {
                scale: 1,
                ease: Power4.easeOut
            });

            var blink = new mojs.Burst({
                parent: e.target,
                count: 8,
                radius: {20 : 45},
                duration: 600,
                children: {
                    stroke: 'rgb(254, 89, 90)',
                    strokeLinecap: 'round',
                    shape: 'circle',
                    strokeWidth: {5 : 0},
                    radius: {2 : 0},
                    opacity: {0 : 1, easing: 'quint.out'}
                }
            });

            var master = new TimelineMax();
            master.add(t1);
            master.add(function() {
                blink.play();
            }, .3)

        // if already liked -> remove like
        } else {
          this.counter--;
          this.liked = false;

          TweenMax.to(this.$refs.heart, 1, {
            color: 'rgb(37, 37, 37)',
            ease: Power4.easeOut
          });
        }




    }
  },
}
</script>
<style lang="scss" scoped>
</style>
