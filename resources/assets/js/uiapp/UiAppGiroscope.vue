<template>
    <div class="ua-giroscope">
        <ui-title
            title="Scene"
            color="white"
            :has-padding="false"
            ref="title"/>
        <div class="ua-giroscope__canvas" id="panorama" ref="content"></div>
    </div>
</template>

<script>
import 'pannellum/src/css/pannellum.css'
import { UiTitle } from '../ui'

export default {
    name: 'UiAppGiroscope',
    components: {
        UiTitle,
    },
    props: {
        color: {
            type: String,
            default: 'green'
        }
    },
    data: function() {
        return {
            viewer: null,
        }
    },
    methods: {
        init: function() {
            this.$emit('loaded')
        }
    },
    mounted: function() {
        this.$nextTick(this.init)
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-giroscope {
    width: 100%;
    height: 100%;
    background-color: $dark-gray;
    padding: $spacer;
    @include border-left-radius(24px);
    @include app-block-padding;

    &__canvas {
        width: 100%;
        height: 80%;
        min-height: 480px;
    }
}
</style>
