<template>
    <div class="row mt">
        <div class="col">
            <div class="box green">
                <div class="box-body">
                    <div id="timeline" class="timeline-container">
                        <transition-group
                            :css="false"
                            tag="div"
                            @enter="transitionEnter"
                            @leave="transitionLeave">
                            <timeline-track
                                v-for="(track, idx) in tracks"
                                :key="idx"
                                :track="track"
                                :data-index="idx"
                                :idx="idx"
                                @delete_track="onDeleteTrack"
                                @on-drag="onDrag"
                                @on-resize="onResize"/>
                        </transition-group>
                        <!-- <vue-draggable-resizable
                            :parent="true"
                            axis="x"
                            :handles="['ml']"
                            :x="this.playheadPosition"
                            :w="1"
                            :h="this.playheadHeight">
                                <div class="">
                                    {{ this.playheadPosition }}
                                </div>
                                <div ref="playhead" id="playhead" class="playhead"></div>
                        </vue-draggable-resizable> -->
                        <div ref="playhead" id="playhead" class="playhead"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TimelineTrack from './TimelineTrack.vue'
import VueDraggableResizable from 'vue-draggable-resizable'
import {TimelineMax} from 'gsap'

export default {
    name: 'Timeline',
    components: {
        TimelineTrack,
        VueDraggableResizable
    },
    watch: {
        '$root.timelines': function(timelines) {
            this.tracks = timelines
        }
    },
    data: () => ({
        settings: {
            tick: '10', //1s = Npx
            max_length: 5000 // in px
        },
        tracks: [],
        playheadHeight: 300,
        playheadPosition: 200,
    }),
    methods: {
        playheadStart: function() {
            var playhead = document.getElementById('playhead')
        },
        onDrag: function(obj) {
            let cache = this.$root.timelines[obj.idx]
            if (cache) {
                cache.start = obj.start
                this.$root.timelines.splice(obj.idx, 1, cache)
            }
        },
        onResize: function(obj) {
            let cache = this.$root.timelines[obj.idx]
            if (cache) {
                cache.start = obj.start
                cache.duration = obj.duration
                this.$root.timelines.splice(obj.idx, 1, cache)
            }
        },
        onDeleteTrack: function(track) {
            var idx = this.tracks.findIndex((singleTrack) => {
                return singleTrack.id == track.id
            })
            if (idx >= 0) {
                this.$root.timelines.splice(idx, 1)
            }
        },
        transitionBeforeEnter: function(el, done) {
            var t1 = new TimelineMax()
            t1.set(el, {
                opacity: 0,
                yPercent: 100,
                position: 'relative',
                onComplete: done
            })
        },
        transitionEnter: function(el, done) {
            var del = el.dataset.index * .33
            var t1 = new TimelineMax()
            t1.to(el, .5, {
                opacity: 1,
                yPercent: 0,
                delay: del,
                ease: Sine.easeOut,
                onComplete: done
            })
        },
        transitionLeave: function(el, done) {
            var t1 = new TimelineMax()
            t1.to(el, .5, {
                    opacity: 0,
                    yPercent: 100,
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
    mounted: function() {
        this.playheadStart()
        this.$root.$on('player-time-update', time => {
            time = (time * this.$root.tick) + 200
            this.playheadPosition = parseInt(time)
            this.$refs.playhead.style.left = parseInt(time) + 'px'
        })
    },
}
</script>
<style lang="scss" scoped>
@import '~styles/shared';

#timeline {
    position: relative;
    background: $gray-lightest;
    border-top: 1px solid rgba($black, .1);

    &.timeline-container {
        padding: 0;
    }

    .playhead {
        position: absolute;
        border-right: 2px solid $red;
        height: 100%;
        top: 0;
        left: 200px;
    }
}
</style>
