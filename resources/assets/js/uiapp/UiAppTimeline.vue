<template>
    <ui-row :no-gutters="true" ref="container">
        <ui-block :size="12">
            <div class="ua-timeline" ref="timeline">
                <ui-title
                    :title="$root.getCmd(title)"
                    color="white"
                    :has-padding="false"
                />
                <div class="ua-timeline__container">
                    <div class="ua-timeline__playhead-top">
                        <vue-draggable-resizable
                            ref="masterPlayhead"
                            :parent="true"
                            axis="x"
                            :handles="['ml', 'mr']"
                            :x.sync="master.x"
                            :grid="[2, 20]"
                            :resizable="false"
                            class="my-class"
                            @dragging="onDragMaster"
                            @resizing="onResizeMaster"
                        >
                            <svg
                                width="12px"
                                height="12px"
                                viewBox="0 0 92 88"
                                version="1.1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                            >
                                <polygon
                                    class="ua-timeline__playhead-svg"
                                    points="0.03515625 0.40234375 92.0351562 0.40234375 46.0351562 88.4023438"
                                ></polygon>
                            </svg>
                        </vue-draggable-resizable>
                    </div>
                    <timeline-track
                        v-for="(track, idx) in timelines"
                        :key="track.uniqueid"
                        :track="track"
                        :idx="idx"
                        :color="color"
                        @delete-track="onDeleteTrack"
                        @duplicate-track="onDuplicate"
                        @on-drag="onDrag"
                        @on-resize="onResize"
                    />
                    <div ref="playhead" class="ua-timeline__playhead"></div>
                </div>
            </div>
        </ui-block>
    </ui-row>
</template>

<script>
import TimelineTrack from "./sub/timeline/TimelineTrack.vue";
import VueDraggableResizable from "vue-draggable-resizable";
import { UiBlock, UiTitle, UiRow } from "../ui";

import { gsap, TweenMax, TweenLite, ScrollToPlugin } from "gsap/all";

gsap.registerPlugin(ScrollToPlugin);

export default {
    name: "UiAppTimeline",
    components: {
        TimelineTrack,
        UiBlock,
        UiTitle,
        UiRow,
        VueDraggableResizable
    },
    props: {
        title: {
            type: String,
            default: "timeline"
        },
        timelines: {
            type: Array,
            default: function() {}
        },
        playheadPosition: {
            type: Number,
            default: 171
        },
        playheadHeight: {
            type: Number,
            default: 300
        },
        color: {
            type: String,
            default: "green"
        }
    },
    data: function() {
        return {
            settings: {
                tick: "10", //1s = Npx
                max_length: 5000 // in px
            },
            tracks: [],
            masterPlay: 0,
            master: {
                x: 0,
                y: 0,
                w: 12,
                h: 12
            }
        };
    },
    watch: {
        playheadPosition: function(x) {
            this.movePlayhead(x);
        }
    },
    computed: {},
    methods: {
        movePlayhead: function(x = null) {
            this.master.x = x;
            const updatedPlayheadPosition = Math.round(
                this.playheadPosition - 171
            );
            gsap.set(this.$refs.playhead, {
                left: this.playheadPosition
            });

            this.masterPlay = updatedPlayheadPosition;
            this.$refs.masterPlayhead.left = updatedPlayheadPosition;
            // console.log(this.masterPlay);
            // console.log("modePlayhead", x, this.masterPlay, this.master.x);

            // TweenLite.set(this.$refs.playheadTop, {
            //     left: this.playheadPosition - 5
            // });
        },
        onDrag: function(obj) {
            this.$emit("on-drag", obj);
        },
        onDragMaster: function(x, y) {
            // console.log(x);
            this.master.x = x;
            this.$emit("on-drag-master", x);
            // this.$emit("update:playheadPosition", x);
            // this.movePlayhead(x);
            // console.log(x + 171);
        },
        onResizeMaster: function(x, y, width) {
            this.master.x = x;
        },
        onResize: function(obj) {
            this.$emit("on-resize", obj);
        },
        onDeleteTrack: function(uniqueid) {
            this.$emit("delete-track", uniqueid);
        },
        onDuplicate: function(uniqueid) {
            this.$emit("duplicate-track", uniqueid);
        }
    },
    mounted: function() {
        this.$nextTick(() => {
            let timeline = this.$refs.timeline;
            if (timeline) {
                TweenMax.to(window, {
                    duration: 0.2,
                    scrollTo: {
                        y: timeline,
                        offsetY: 200
                    }
                });
            }
        });
    }
};
</script>

<style lang="scss">
@import "~styles/shared";

.my-class {
    // background-color: $red;
    width: 12px !important;
    height: 12px !important;
}

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

    &__playhead-top {
        position: relative;
        // position: absolute;
        // top: -16px;
        top: -16px;
        left: 166px;
        height: 12px;
        width: calc(100% - 166px);
        // left: 166px; // 171 - (12 / 2) + (2px / 2)
        // background-color: rgba(255, 145, 32, 0.5);
        cursor: pointer;
    }

    &__playhead-svg {
        fill: #ff0000;
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
