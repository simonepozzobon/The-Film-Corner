<template>
    <div class="row mt">
        <div class="col">
            <div class="box green">
                <div class="box-body">
                    <div id="timeline" class="timeline-container">
                        <timeline-track
                            v-for="(track, idx) in this.tracks"
                            :key="track.uniqueid"
                            :track="track"
                            :idx="idx"
                            @delete_track="onDeleteTrack"
                            @on-drag="onDrag"
                            @on-resize="onResize"/>
                        <div ref="playhead" id="playhead" class="playhead"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TimelineTrack from './TimelineTrack.vue'
// import VueDraggableResizable from 'vue-draggable-resizable'
import {TimelineMax} from 'gsap'

export default {
    name: 'Timeline',
    components: {
        TimelineTrack,
        // VueDraggableResizable
    },
    watch: {
        '$root.timelines': function(timelines) {
            this.tracks = []
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
        onDrag: function(obj) {
            let cache = Object.assign({}, this.$root.timelines[obj.idx]) // clone
            if (cache) {
                cache.start = obj.start
                this.$root.timelines.splice(obj.idx, 1, cache)
            }
        },
        onResize: function(obj) {
            // console.log(obj)
            let cache = Object.assign({}, this.$root.timelines[obj.idx]) // clone
            if (cache) {
                cache.start = obj.start
                cache.duration = obj.duration
                cache.cutStart = obj.cutStart
                cache.cutEnd = obj.cutEnd
                this.$root.timelines.splice(obj.idx, 1, cache)
            }
        },
        onDeleteTrack: function(uniqueid) {
            let idx = this.$root.timelines.findIndex(item => item.uniqueid == uniqueid)

            if (idx >= 0) {
                this.$root.timelines.splice(idx, 1)
            }
        },
    },
    mounted: function() {
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
