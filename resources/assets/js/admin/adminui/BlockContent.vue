<template>
<div
    class="block-content"
    ref="container"
>
    <div
        class="block-content__content"
        ref="element"
    >
        <panel-title
            v-if="title"
            :title="title"
            size="h4"
            class="block-content__title"
            letter-spacing="6px"
        />
        <slot></slot>
    </div>
</div>
</template>

<script>
import PanelTitle from './PanelTitle.vue'
import {
    ThrottleEvent,
    BlockContentAnimation,
}
from './mixins'

export default {
    name: 'BlockContent',
    components: {
        PanelTitle,
    },
    mixins: [ThrottleEvent, BlockContentAnimation],
    props: {
        title: {
            default: null,
        },
    },
    mounted: function () {
        this.$nextTick(() => {
            this.initAnim()
        })
    },
}
</script>

<style lang="scss">
@import '~styles/shared';
.block-content {
    &__title {
        padding-top: $spacer * 1.618 !important;
        padding-bottom: $spacer * 1.618 !important;
    }
}
</style>

<style lang="scss" scoped>
@import '~styles/shared';
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.block-content {
    margin-bottom: $spacer * 2.5;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    &__content {
        background-color: $gray-100;
        @include gradient-directional($color, lighten($color, 2), -11deg);
        @include border-radius($border-radius * 2);
        padding: ($spacer * 1.618) ($spacer * 1.618) ($spacer * 1.618) ($spacer * 1.618);
        // @include custom-box-shadow($darken, 2px, 0.02);
    }
}
</style>
