<template lang="html">
    <div class="ui-app-giroscope">
        <ui-title
            title="Scene"
            color="white"
            :has-padding="false"
            ref="title"/>
        <canvas class="ui-app-giroscope__canvas" id="image-editor" ref="canvas"></canvas>
    </div>
</template>

<script>
import { UiTitle } from '../ui'

export default {
    name: 'UiAppGiroscope',
    components: {
        UiTitle,
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-giroscope {
    width: 100%;
    height: 100%;
    background-color: $dark-gray;
    padding: $spacer;
    @include border-left-radius(24px);
    @include app-block-padding;

    &__canvas {
        width: 100%;
        height: 100%;
    }
}
</style>
