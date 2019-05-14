<template lang="html">
    <div class="net-players-controls">
        <div class="net-players-controls__container">
            <div class="net-players-controls__control">
                <play
                    @click.native="play"
                    color="white"
                    :hoverable="true"
                    hover-color="darker"/>
            </div>
            <div class="net-players-controls__control">
                <pause
                    @click.native="pause"
                    color="white"
                    :hoverable="true"
                    hover-color="darker"/>
            </div>
            <div class="net-players-controls__control">
                <stop
                    @click.native="stop"
                    color="white"
                    :hoverable="true"
                    hover-color="darker"/>
            </div>
            <div class="net-players-controls__control">
                <backward
                    @click.native="backward"
                    color="white"
                    :hoverable="true"
                    hover-color="darker"/>
            </div>
            <div class="net-players-controls__control">
                <forward
                    @click.native="forward"
                    color="white"
                    :hoverable="true"
                    hover-color="darker"/>
            </div>
        </div>
    </div>
</template>

<script>
import { Backward, Forward, Pause, Play, Stop } from '../icons'

export default {
    name: 'NetPlayerControls',
    components: {
        Backward,
        Forward,
        Pause,
        Play,
        Stop,
    },
    methods: {
        play: function() {
            this.$emit('play')
        },
        pause: function() {
            this.$emit('pause')
        },
        stop: function() {
            this.$emit('stop')
        },
        backward: function() {
            this.$emit('backward')
        },
        forward: function() {
            this.$emit('forward')
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.net-players-controls {
    background-color: $light-gray;
    display: flex;
    justify-content: center;
    @include app-block-padding;
    margin-top: $spacer * 1.618;
    margin-left: $spacer;
    margin-right: $spacer;
    @include border-radius(16px);
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
