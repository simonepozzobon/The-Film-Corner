<template>
    <div class="ua-preview">
        <ui-title
            title="Preview"
            color="white"
            :has-padding="false"
            ref="title"/>
        <canvas class="ua-preview__canvas" id="image-editor" ref="canvas"></canvas>
    </div>
</template>

<script>
import { UiTitle } from '../ui'

export default {
    name: 'UiAppPreview',
    components: {
        UiTitle,
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-preview {
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
