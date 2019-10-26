<template>
<div class="block-panel">
    <ui-title
        :title="title"
        tag="h2"
        font-size="h2"
        class="block-panel__title"
    />
    <div class="block-panel__container">
        <slot></slot>
    </div>
</div>
</template>

<script>
import {
    UiTitle
}
from '../../ui'

export default {
    name: 'BlockPanel',
    components: {
        UiTitle
    },
    props: {
        title: {
            type: String,
            default: null,
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.block-panel {
    $color: $gray-100;

    &__title {
        @include title-text-shadow(12px, 1px, 1px, 2px, 0.33);
    }

    &__container {
        background-color: $color;
        padding: ($spacer * 2 * 1.618) ($spacer * 2 * 1.618) ($spacer * 1.618) ($spacer * 2 * 1.618);
        border: 3px solid darken($color, 6);
        @include border-radius($border-radius * 2);
        @include custom-inner-shadow(darken($color, 30), 8px, 0.2);
        // @include gradient-directional($color, lighten($color, 2), -10deg);
        // @include custom-box-shadow(lighten($dark, 25), 1px, 0.3);
    }
}
</style>
