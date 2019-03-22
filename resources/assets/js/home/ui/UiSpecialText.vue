<template lang="html">
    <div class="ui-special-text"
        ref="text"
        :class="[
            colorClass,
            alignClass,
        ]">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'UiSpecialText',
        props: {
            fontSize: {
                type: String,
                default: null,
            },
            color: {
                type: String,
                default: null,
            },
            align: {
                type: String,
                default: null,
            },
        },
        computed: {
            colorClass: function() {
                if (this.color) {
                    return 'text-' + this.color
                }
            },
            alignClass: function() {
                if (this.align == 'center') {
                    return 'ui-special-text--align-center'
                }
            },
        },
        mounted: function() {
        }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-special-text {
    $self: &;
    font-size: $font-size-base * 1.618;
    font-weight: 200;
    padding-top: $spacer * 1;
    padding-bottom: $spacer * 3;

    &#{$self}--align-center {
        text-align: center;
    }
}
</style>
