<template>
  <div :id="likeable_id">
    <div class="row">
      <div class="col">
        <h5 ref="eye" class="text-center">{{ this.views }} <i class="fa fa-eye" aria-hidden="true"></i></h5>
      </div>
      <div class="col">
        <h5 ref="heart" class="text-center" @click="heartClick(likeable_id, $event)">{{ this.counter }} <i class="fa fa-heart" aria-hidden="true"></i></h5>
      </div>
      <div class="col">
        <h5 ref="comment" class="text-center">{{ this.comments }} <i class="fa fa-comment" aria-hidden="true"></i></h5>
      </div>
    </div>
  </div>
</template>
<script>
import mojs from 'mo-js'
import {TweenMax, Power4, Elastic, TimelineMax} from 'gsap'

export default {
  name: "network-icons",
  props: ['views', 'comments', 'likes', 'liked', 'user', 'user_type', 'likeable_type', 'likeable_id'],
  data: () => ({
    counter: '',
    like_status: ''
  }),
  mounted() {
    this.counter = this.likes;

    if (this.liked) {
      this.$refs.heart.style.color = 'rgb(254, 89, 90)';
    }
    this.like_status = this.liked;

  },
  methods: {
    heartClick (likeable_id, e)
    {
        // if not liked yet
        if (!this.like_status) {
            this.counter++;
            this.like_status = true;
            this.addLike();

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
          this.like_status = false;
          this.removeLike();

          TweenMax.to(this.$refs.heart, 1, {
            color: 'rgb(37, 37, 37)',
            ease: Power4.easeOut
          });
        }
    },

    addLike()
    {
        var vue = this;

        var formData = new FormData();
        formData.append('user', this.user);
        formData.append('user_type', this.user_type);
        formData.append('likeable_id', this.likeable_id);
        formData.append('likeable_type', this.likeable_type);

        axios.post('/api/v1/add-like', formData);
    },

    removeLike()
    {
        var vue = this;

        var formData = new FormData();
        formData.append('user', this.user);
        formData.append('user_type', this.user_type);
        formData.append('likeable_id', this.likeable_id);
        formData.append('likeable_type', this.likeable_type);

        axios.post('/api/v1/destroy-like', formData);
    },
  },
}
</script>
<style lang="scss" scoped>
</style>
