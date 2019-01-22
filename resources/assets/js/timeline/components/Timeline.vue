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
                                v-for="(track, index) in tracks"
                                :key="index"
                                :track="track"
                                :data-index="index"
                                @delete_track="onDeleteTrack" />
                        </transition-group>
                        <div id="playhead" class="playhead"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TimelineTrack from './TimelineTrack.vue'
import {
    TimelineMax,
    Sine
} from 'gsap'

export default {
    name: 'Timeline',
    components: {
        TimelineTrack
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
        tracks: [
            // {
            //     'id': 1,
            //     'title': 'Titolo 1',
            //     'duration': 100,
            //     'start': 0,
            //     'src': 'file'
            // },
        ]
    }),
    methods: {
        playheadStart: function() {
            var playhead = document.getElementById('playhead')
        },
        onDeleteTrack: function(track) {
            var index = this.tracks.findIndex((singleTrack) => {
                return singleTrack.id == track.id
            })
            if (index >= 0) {
                // this.tracks.splice(index, 1) // local
                this.$root.timelines.splice(index, 1) // global
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

    > .playhead {
        position: absolute;
        height: 100%;
        border-right: 2px solid $red;
        top: 0;
        left: 190px;
    }
}
</style>
