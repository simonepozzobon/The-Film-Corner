<template>
<div class="timeline-track">
    <div id="heading" class="title" @click="editTitle">
        <span ref="title">{{ track.title }}</span>
        <div class="tools" ref="tools">
            <input
                class="form-control"
                v-model="title"
                @keyup.enter="saveTitle">
            <i class="fa fa-files-o" @click="duplicateTrack" />
            <i class="fa fa-trash-o" @click="deleteTrack" />
        </div>
    </div>
    <div id="media" class="timeline-element col-md-10">
        <vue-draggable-resizable
            :parent="true"
            axis="x"
            :handles="['ml','mr']"
            :x="track.start"
            :w="track.duration"
            @dragging="onDrag"
            @resizing="onResize">
                <div class="media-element"></div>
        </vue-draggable-resizable>
    </div>
</div>
</template>
<script>
import TimelineElement from './TimelineElement.vue'
import VueDraggableResizable from 'vue-draggable-resizable'
import {
    TimelineMax,
    Power4
} from 'gsap'
export default {
    name: 'TimelineTrack',
    components: {
        TimelineElement,
        VueDraggableResizable,
    },
    props: {
        track: {
            type: Object,
            default: function() {},
        },
        idx: {
            type: Number,
            default: 0,
        }
    },
    data: () => ({
        length: {
            x: 0,
            y: 0,
            w: 0,
        },
        position: {
            x: 0,
            y: 0,
        },
        cut: {
            start: 0,
            end: 0,
        },
        title: '',
    }),
    watch: {
        track: function(track) {
            // console.log(track)
        }
    },
    methods: {
        editTitle: function() {
            this.title = this.track.title
            var t1 = new TimelineMax()
            t1.to(this.$refs.title, .2, {
                    opacity: 0,
                    display: 'none',
                    ease: Power4.easeInOut,
                })
                .to(this.$refs.tools, .2, {
                    opacity: 1,
                    display: 'flex',
                    ease: Power4.easeInOut
                })
        },
        saveTitle: function(isDelete = false) {
            return new Promise(resolve => {
                this.$root.timelines[this.idx].title = this.title
                var t1 = new TimelineMax()
                t1.to(this.$refs.tools, .2, {
                        opacity: 0,
                        display: 'none',
                        ease: Power4.easeInOut,
                    })
                    .to(this.$refs.title, .2, {
                        opacity: 1,
                        display: 'block',
                        ease: Power4.easeInOut,
                        onComplete: () => {
                            console.log('completat')
                            resolve()
                        }
                    })
            })
        },
        deleteTrack: function() {
            this.$emit('delete_track', this.track.uniqueid)
        },
        duplicateTrack: function() {
            let obj = Object.assign({}, this.track)
            obj = {
                ...obj,
                originalDuration: obj.originalDuration / this.$root.tick,
                duration: obj.duration / this.$root.tick,
                start: obj.start / this.$root.tick,
                cutStart: obj.cutStart / this.$root.tick,
                cutEnd: obj.cutEnd / this.$root.tick,
            }
            this.$root.$emit('add-to-timeline', obj)
        },
        onDrag: function(x, y) {
            this.position.x = x
            this.length.x = x
            this.position.y = y
            // console.log('Drag', x)
            this.$emit('on-drag', {
                idx: this.idx,
                start: x,
            })
        },
        onResize: function(x, y, width) {
            if (this.length.x != x && this.length.w != width) {
                // taglia l'inizio
                // console.log('taglia inizio')
                let delta = x - this.length.x
                this.cut.start = this.cut.start + delta
            } else if (this.length.w != width) {
                // taglia la fine
                // console.log('taglia la fine')
                let delta = width - this.length.w
                this.cut.end = this.cut.end + delta
            }

            this.length.x = x
            this.length.y = y
            this.length.w = width

            this.$emit('on-resize', {
                idx: this.idx,
                start: x,
                cutStart: this.cut.start,
                cutEnd: this.cut.end,
                duration: width
            })

            // console.log('Resize', this.track.start, x, this.track.duration, width)
        },
    },
    mounted: function() {
    },
    beforeDestroy: function() {
        // this.$refs.title.style.display = 'none'
    }
}
</script>
<style lang="scss" scoped>
@import '~styles/shared';

.timeline-track {
    height: $spacer * 1.5;
    display: flex;
    border-bottom: 1px solid rgba($black, .1);

    > .title {
        width: 200px;
        padding: ($spacer / 4) $spacer / 2;
        font-weight: $font-weight-bold;
        text-transform: uppercase;
        line-height: 2;
        border-right: 1px solid rgba($black, .05);
        background-color: rgba($black, .05);
        cursor: text;

        > .tools {
            display: none;
            align-items: center;
            opacity: 0;

            > i {
                cursor: pointer;
                padding-left: $spacer / 2;
            }
        }
    }

    > .timeline-element {

        > .draggable {
            > .media-element {
                height: 100%;
                background-color: $tfc-yellow;
                border: 2px solid $tfc-dark-yellow;
                @include border-radius($border-radius);

            }
        }
    }
}
</style>
