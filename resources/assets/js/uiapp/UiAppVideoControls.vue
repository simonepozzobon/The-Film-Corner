<template>
<div
    class="ua-video-controls"
    ref="controls"
>
    <div class="ua-video-controls__container">
        <div class="ua-video-controls__control">
            <play
                @click.native="play"
                color="white"
                :hoverable="true"
                hover-color="darker"
            />
        </div>
        <div class="ua-video-controls__control">
            <pause
                @click.native="pause"
                color="white"
                :hoverable="true"
                hover-color="darker"
            />
        </div>
        <div class="ua-video-controls__control">
            <stop
                @click.native="stop"
                color="white"
                :hoverable="true"
                hover-color="darker"
            />
        </div>
        <div class="ua-video-controls__control">
            <backward
                @click.native="backward"
                color="white"
                :hoverable="true"
                hover-color="darker"
            />
        </div>
        <div class="ua-video-controls__control">
            <forward
                @click.native="forward"
                color="white"
                :hoverable="true"
                hover-color="darker"
            />
        </div>
    </div>
</div>
</template>

<script>
import {
    Backward,
    Forward,
    Pause,
    Play,
    Stop
}
from '../icons'

import ElementMeasurer from 'element-measurer'

export default {
    name: 'UiAppVideoControls',
    components: {
        Backward,
        Forward,
        Pause,
        Play,
        Stop,
    },
    data: function () {
        return {
            height: 0,
        }
    },
    watch: {
        height: function (height) {
            this.$emit('update-size', height)
        }
    },
    methods: {
        play: function () {
            this.$emit('play')
        },
        pause: function () {
            this.$emit('pause')
        },
        stop: function () {
            this.$emit('stop')
        },
        backward: function () {
            this.$emit('backward')
        },
        forward: function () {
            this.$emit('forward')
        },
        getSize: function () {
            const size = new ElementMeasurer(this.$refs.controls)
            this.height = size.clientHeight
        },
    },
    mounted: function () {
        this.$nextTick(() => {
            this.getSize()
        })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-video-controls {
    background-color: $light-gray;
    z-index: 1;
    display: flex;
    justify-content: center;
    @include app-block-padding;
    // margin-left: -$app-padding-x;
    // margin-right: -$app-padding-x;
    // position: absolute;
    // bottom: 0;
    width: 100%;
    // transform: translateY($spacer);

    &__container {
        flex: 0 0 80%;
        max-width: 80%;
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    &__control {
        margin-left: $spacer;
        margin-right: $spacer;
    }
}
</style>
