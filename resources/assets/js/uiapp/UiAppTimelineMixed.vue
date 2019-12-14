<template>
<ui-row
    :no-gutters="true"
    ref="container"
>
    <ui-block :size="12">
        <div class="ua-timeline">
            <ui-title
                :title="title"
                color="white"
                :has-padding="false"
            />
            <div class="ua-timeline__container">
                <timeline-track
                    v-for="(track, idx) in timelines"
                    :key="track.uniqueid"
                    :track="track"
                    :idx="idx"
                    :color="track.color"
                    @delete-track="onDeleteTrack"
                    @duplicate-track="onDuplicate"
                    @on-drag="onDrag"
                    @on-resize="onResize"
                />
                <div
                    ref="playhead"
                    class="ua-timeline__playhead"
                ></div>
            </div>
        </div>
    </ui-block>
</ui-row>
</template>

<script>
import TimelineTrack from './sub/timeline/TimelineTrack.vue'
import {
    UiBlock,
    UiTitle,
    UiRow
}
from '../ui'
import {
    gsap,
    TweenMax,
    TweenLite,
    ScrollToPlugin
}
from 'gsap/all'

gsap.registerPlugin(ScrollToPlugin);


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
            default: function () {},
        },
        playheadPosition: {
            type: Number,
            default: 171,
        },
        playheadHeight: {
            type: Number,
            default: 300,
        },
        color: {
            type: String,
            default: 'green'
        }
    },
    data: function () {
        return {
            settings: {
                tick: '10', //1s = Npx
                max_length: 5000 // in px
            },
            tracks: [],
        }
    },
    watch: {
        playheadPosition: function (x) {
            this.movePlayhead()
        }
    },
    methods: {
        movePlayhead: function () {
            TweenLite.set(this.$refs.playhead, {
                left: this.playheadPosition
            })
        },
        onDrag: function (obj) {
            this.$emit('on-drag', obj)
        },
        onResize: function (obj) {
            this.$emit('on-resize', obj)
        },
        onDeleteTrack: function (uniqueid) {
            this.$emit('delete-track', uniqueid)
        },
        onDuplicate: function (uniqueid) {
            this.$emit('duplicate-track', uniqueid)
        },
    },
    mounted: function () {
        this.$nextTick(() => {
            let timeline = this.$refs.timeline
            if (timeline) {
                TweenLite.to(window, .2, {
                    scrollTo: {
                        y: timeline,
                        offsetY: 200,
                    }
                })
            }
        })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-timeline {
    // position: relative;
    width: 100%;
    height: 100%;
    background-color: $dark-gray;
    @include border-radius($custom-border-radius);
    @include app-block-padding;

    &__container {
        position: relative;
    }

    &__playhead {
        position: absolute;
        border-right: 2px solid #ff0000;
        height: 100%;
        top: 0;
        left: 171px;
    }
}
</style>
