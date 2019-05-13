<template>
    <div
        class="timeline-track"
        :class="[
            colorClass,
            blobColorClass,
        ]"
        ref="container">
        <div
            class="timeline-track__head"
            @click="editTitle">
            <span
                ref="title"
                class="timeline-track__title">
                {{ title }}
            </span>
            <div
                class="timeline-track__input tools"
                ref="tools">
                <input
                    class="form-control"
                    v-model="title"
                    @keyup.enter="saveTitle">
            </div>
        </div>
        <div id="media" class="timeline-track__track timeline-element col-md-10">
            <vue-draggable-resizable
                v-if="track"
                :parent="true"
                axis="x"
                :handles="['ml','mr']"
                :x="track.start"
                :w="track.duration"
                @dragging="onDrag"
                @resizing="onResize">
                    <div class="timeline-track__media-element"></div>
            </vue-draggable-resizable>
            <div
                class="timeline-track__toolbar">

                <i class="fa fa-files-o timeline-track__left-tool"
                    @click="duplicateTrack"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Duplicate"/>

                <i class="fa fa-trash-o timeline-track__right-tool"
                    @click="deleteTrack"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Delete"/>
            </div>
        </div>
    </div>
</template>
<script>
import SizeUtility from '../../../Sizes'
import VueDraggableResizable from 'vue-draggable-resizable'
import { TimelineMax, Power4 } from 'gsap'

export default {
    name: 'TimelineTrack',
    components: {
        VueDraggableResizable,
    },
    props: {
        track: {
            type: Object,
            default: null,
        },
        idx: {
            type: Number,
            default: 0,
        },
        color: {
            type: String,
            default: 'green'
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
    computed: {
        colorClass: function() {
            let odd = Boolean(this.idx % 2)
            if (odd) {
                return 'timeline-track--light'
            }
        },
        blobColorClass: function() {
            return 'timeline-track--' + this.color
        }
    },
    watch: {
        track: function(track) {
            // console.log(track)
        }
    },
    methods: {
        getTitleSize: function(title = false ) {
            this.title = title ? title : this.track.title
            this.$nextTick(() => {
                let el = SizeUtility.get(this.$refs.title)
                let container = SizeUtility.get(this.$refs.container)
                if (el.h > container.h) {
                    let title = this.title.substring(0, this.title.length -1)
                    this.getTitleSize(title)
                } else {
                    return false
                }
            })

        },
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
            this.$emit('delete-track', this.track.uniqueid)
        },
        duplicateTrack: function() {
            this.$emit('duplicate-track', this.track.uniqueid)
        },
        onDrag: function(x, y) {
            this.position.x = x
            this.length.x = x
            this.position.y = y
            // console.log('Drag', x)
            this.$nextTick(() => {
                this.$emit('on-drag', {
                    idx: this.idx,
                    start: x,
                })
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

            this.$nextTick(() => {
                this.$emit('on-resize', {
                    idx: this.idx,
                    start: x,
                    cutStart: this.cut.start,
                    cutEnd: this.cut.end,
                    duration: width
                })
            })
            // console.log('Resize', this.track.start, x, this.track.duration, width)
        },
    },
    mounted: function() {
        this.$nextTick(this.getTitleSize)
    },
    beforeDestroy: function() {
        // this.$refs.title.style.display = 'none'
    }
}
</script>
<style lang="scss" scoped>
@import '~styles/shared';

.timeline-track {
    position: relative;
    height: 26px;
    width: 100%;
    display: flex;
    margin-bottom: 1px;

    &__media-element {
        height: 100%;
        background-color: $green;
        @include border-radius($border-radius);
    }

    &__head {
        width: 200px;
        padding: ($spacer / 4) $spacer / 2;
        cursor: text;
    }

    &__title {
        color: $white;
    }

    &__track {
        background-color: rgba($white, .08)
    }

    &--light &__track {
        background-color: rgba($white, .18)
    }

    &__input {
        display: none;
        align-items: center;
        opacity: 0;
        max-width: 100%;
        flex-wrap: wrap;
    }

    &__toolbar {
        position: absolute;
        right: $spacer / 2;
        top: 50%;
        transform: translateY(-50%);
    }

    &__right-tool {
        cursor: pointer;
        color: rgba($white, .6);
    }

    &__left-tool {
        cursor: pointer;
        color: rgba($white, .6);
        margin-right: $spacer / 2;
    }

    &--green &__media-element {
        background-color: $green;
    }

    &--yellow &__media-element {
        background-color: $yellow;
    }

    &--red &__media-element {
        background-color: $red;
    }
}
</style>
