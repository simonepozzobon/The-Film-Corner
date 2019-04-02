<template lang="html">
    <div class="ui-image"
        :class="[ fullWidthClass, fullHeightClass ]"
        :title="alt">
        <img :src="src" :alt="alt" class="ui-image__content"/>
    </div>
</template>

<script>
export default {
    name: 'UiImage',
    props: {
        alt: {
            type: String,
            default: null
        },
        src: {
            type: String,
            default: null
        },
        altTitle: {
            type: String,
            default: null
        },
        fullWidth: {
            type: Boolean,
            default: false,
        },
        fullHeight: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        fullWidthClass: function() {
            if (this.fullWidth) {
                return 'ui-image--full-width'
            }
        },
        fullHeightClass: function() {
            if (this.fullHeight) {
                return 'ui-image--full-height'
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-image {
    $self: &;
    overflow: hidden;
    @include border-radius($spacer / 2.8);
    margin-bottom: $spacer;

    &__content {
        max-width: 100%;
    }

    &--full-width {
        width: 100%;
    }

    &#{$self}--full-width & {
        &__content {
            width: 100%;
            height: auto;
        }
    }
}
</style>
