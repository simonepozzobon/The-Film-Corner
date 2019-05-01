<template lang="html">
    <ui-row :no-gutters="true" ref="container">
        <ui-block :size="12">
            <div class="ui-app-timeline">
                <ui-title :title="title" color="white" :has-padding="false"/>
                <timeline-track
                    v-for="(track, idx) in timelines"
                    :key="track.uniqueid"
                    :track="track"
                    :idx="idx"
                    @delete-track="onDeleteTrack"
                    @duplicate-track="onDuplicate"
                    @on-drag="onDrag"
                    @on-resize="onResize"/>
                <div ref="playhead" id="playhead" class="playhead"></div>
            </div>
        </ui-block>
    </ui-row>
</template>

<script>
import TimelineTrack from './sub/timeline/TimelineTrack.vue'
import { UiBlock, UiTitle, UiRow } from '../ui'
import { TweenLite } from 'gsap'
require('gsap/ScrollToPlugin')

export default {
    name: 'UiAppTimeline',
    components: {
        TimelineTrack,
        UiBlock,
        UiTitle,
        UiRow,
        // VueDraggableResizable
    },
    props: {
        title: {
            type: String,
            default: 'Timeline',
        },
        timelines: {
            type: Array,
            default: function() {},
        },
    },
    data: function() {
        return {
            settings: {
                tick: '10', //1s = Npx
                max_length: 5000 // in px
            },
            tracks: [],
            playheadHeight: 300,
            playheadPosition: 200,
        }
    },
    methods: {
        onDrag: function(obj) {
            this.$emit('on-drag', obj)
        },
        onResize: function(obj) {
            this.$emit('on-resize', obj)
        },
        onDeleteTrack: function(uniqueid) {
            this.$emit('delete-track', uniqueid)
        },
        onDuplicate: function(uniqueid) {
            this.$emit('duplicate-track', uniqueid)
        },
    },
    mounted: function() {
        this.$nextTick(() => {
            TweenLite.to(window, .2, {
                scrollTo: {
                    y: '.ui-app-timeline',
                    offsetY: 200,
                }
            })
        })
        // this.$root.$on('player-time-update', time => {
        //     time = (time * this.$root.tick) + 200
        //     this.playheadPosition = parseInt(time)
        //     this.$refs.playhead.style.left = parseInt(time) + 'px'
        // })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-timeline {
    width: 100%;
    height: 100%;
    background-color: $dark-gray;
    @include border-radius($custom-border-radius);
    @include app-block-padding;
}

</style>
