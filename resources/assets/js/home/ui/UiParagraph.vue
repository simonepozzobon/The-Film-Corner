<template lang="html">
    <div
        class="ui-paragraph"
        :class="alignClass">
        <p class="ui-paragraph__content">
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
        }
    },
    computed: {
        alignClass: function() {
            if (this.align == 'center') {
                return 'ui-paragraph--align-center'
            }

            return null
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

    &__content {
        padding: 0;
        margin: 0;
    }

    &#{$self}--align-center {
        text-align: center;
    }
}
</style>
