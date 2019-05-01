<template lang="html">
    <div class="ui-app-video-controls">
        <div class="ui-app-video-controls__container">
            <div class="ui-app-video-controls__control">
                <play
                    color="white"
                    :hoverable="true"
                    hover-color="darker"/>
            </div>
            <div class="ui-app-video-controls__control">
                <pause
                    color="white"
                    :hoverable="true"
                    hover-color="darker"/>
            </div>
            <div class="ui-app-video-controls__control">
                <stop
                    color="white"
                    :hoverable="true"
                    hover-color="darker"/>
            </div>
            <div class="ui-app-video-controls__control">
                <backward
                    color="white"
                    :hoverable="true"
                    hover-color="darker"/>
            </div>
            <div class="ui-app-video-controls__control">
                <forward
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
    name: 'UiAppVideoControls',
    components: {
        Backward,
        Forward,
        Pause,
        Play,
        Stop,
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-video-controls {
    background-color: $light-gray;
    z-index: 0;
    display: flex;
    justify-content: center;
    @include app-block-padding;
    margin-left: -$app-padding-x;
    margin-right: -$app-padding-x;
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
