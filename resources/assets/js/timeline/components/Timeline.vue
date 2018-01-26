<template>
  <div
    id="timeline"
    class="container timeline-container">
    <transition-group
      :css="false"
      tag="div"
      @enter="transitionEnter"
      @leave="transitionLeave">
      <timeline-track
        v-for="(track, index) in tracks"
        :key="track.id"
        :track="track"
        :data-index="index"
        @delete_track="onDeleteTrack"/>
    </transition-group>
    <div class="playhead">
    </div>
    <div class="test">
      <button
        class="btn btn-primary"
        @click="addDemoTrack">
        add track
      </button>
    </div>
  </div>
</template>
<script>
import TimelineTrack from './TimelineTrack.vue'
import {TimelineMax, Sine} from 'gsap'

export default {
  name: 'Timeline',
  components: {
    TimelineTrack
  },
  data: () => ({
    settings: {
      tick: '10', //1s = Npx
      max_length: 5000 // in px
    },
    tracks: [
      {
        'id': 1,
        'title': 'Titolo 1',
        'duration': 100,
        'start': 0,
        'src': 'file'
      },
      {
        'id': 2,
        'title': 'Titolo 2',
        'duration': 200,
        'start': 50,
        'src': 'file'
      },
    ]
  }),
  methods: {
    addDemoTrack: function()
    {
      var demoTrack = {
        'id': Math.random().toString(36).substr(2, 9),
        'title': 'Titolo '+(this.tracks.length + 1),
        'duration': Math.floor(Math.random() * 400) + 1,
        'start': Math.floor(Math.random() * 400) + 1,
        'src': 'file'
      }

      this.tracks.push(demoTrack)
    },
    onDeleteTrack: function(track){
      var index = this.tracks.findIndex((singleTrack) => {
        return singleTrack.id == track.id
      })
      if (index >= 0) {
        this.tracks.splice(index, 1)
      }
    },
    transitionBeforeEnter: function(el, done){
      var t1 = new TimelineMax()
      t1.set(el, {
        opacity: 0,
        y: '-400',
        position: 'relative',
        onComplete: done
      })
    },
    transitionEnter: function(el, done){
      var del = el.dataset.index * .33
      var t1 = new TimelineMax()
      t1.to(el, .5, {
        opacity: 1,
        y: 0,
        delay: del,
        ease: Sine.easeOut,
        onComplete: done
      })
    },
    transitionLeave: function(el, done){
      var t1 = new TimelineMax()
      t1.to(el, .5, {
        opacity: 0,
        y: '+400',
        position: 'relative',
        ease: Sine.easeOut,
      })
        .to(el, .2, {
          height: 0,
          ease: Sine.easeOut,
          onComplete: done
        })
    },
  },
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';
@import '~styles/mixins';

  #timeline {
    position: relative;
    background: $gray-lightest;
    border-top: 1px solid rgba($black, .1);

    &.container {
      padding: 0;
    }

    > .playhead {
      position: absolute;
      height: 100%;
      border-right: 2px solid $red;
      top: 0;
      left: 190px;
    }
  }

</style>
