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
    &__title {
        @include title-text-shadow(12px, 1px, 1px, 2px, 0.33);
    }

    &__container {
        background-color: $gray-200;
        padding: ($spacer * 2 * 1.618);
        @include border-radius($border-radius * 2);
        @include gradient-directional($gray-200, lighten($gray-200, 5), -10deg);
        @include custom-box-shadow(lighten($black, 25));
    }
}
</style>
