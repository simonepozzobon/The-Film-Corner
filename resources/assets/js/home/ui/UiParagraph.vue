<template lang="html">
    <div
        class="ui-paragraph"
        :class="[sizeClass, alignClass, noPaddingClass, padding]">
        <p
            class="ui-paragraph__content"
            :class="[colorClass]">
            <slot></slot>
        </p>
    </div>
</template>

<script>
export default {
    name: 'UiParagraph',
    props: {
        align: {
            type: String,
            default: null,
        },
        hasPadding: {
            type: Boolean,
            default: true,
        },
        padding: {
            type: String,
            default: null,
        },
        color: {
            type: String,
            default: null,
        },
        size: {
            type: String,
            default: null,
        }
    },
    computed: {
        alignClass: function() {
            if (this.align == 'center') {
                return 'ui-paragraph--align-center'
            }
            return null
        },
        noPaddingClass: function() {
            if (!this.hasPadding) {
                return 'ui-paragraph--no-padding'
            }
        },
        colorClass: function() {
            if (this.color) {
                return 'text-' + this.color
            }
        },
        sizeClass: function() {
            if (this.size) {
                return 'ui-paragraph--size-' + this.size
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-paragraph {
    $self: &;
    padding-left: $spacer * 4;
    padding-right: $spacer * 4;
    margin-bottom: $spacer * 1.5;
    z-index: 1;

    &__content {
        padding: 0;
        margin: 0;
    }

    &#{$self}--align-center {
        text-align: center;
    }

    &#{$self}--no-padding {
        padding-left: 0;
        padding-right: 0;
    }

    &#{$self}--size-small {
        font-size: $font-size-sm;
    }
}
</style>
