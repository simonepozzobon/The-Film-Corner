<template lang="html">
    <div class="ui-container"
        :class="[
            alignClass,
            directionClass
        ]">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'UiContainer',
    props: {
        align: {
            type: String,
            default: null,
        },
        direction: {
            type: String,
            default: null,
        }
    },
    computed: {
        alignClass: function() {
            if (this.align == 'center') {
                return 'ui-container--align-center'
            }

            return null
        },
        directionClass: function() {
            if (this.direction == 'row') {
                return null
            }

            return 'ui-container--column'
        },
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-container {
    $self: &;
    display: flex;
    justify-content: center;
    align-items: center;

    &#{$self}--column {
        flex-direction: column;
    }
}
</style>
