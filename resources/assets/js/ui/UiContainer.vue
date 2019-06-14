<template>
    <div class="ui-container"
        ref="container"
        :class="[
            bgColorClass,
            containClass,
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
        minWidth: {
            type: String,
            default: null,
        },
        align: {
            type: String,
            default: null,
        },
        direction: {
            type: String,
            default: null,
        },
        fullWidth: {
            type: Boolean,
            default: false,
        },
        contain: {
            type: Boolean,
            default: false,
        },
        bgColor: {
            type: String,
            default: null,
        }
    },
    computed: {
        alignClass: function() {
            if (this.align == 'center') {
                return 'ui-container--align-center'
            }

            if (this.align == 'left') {
                return 'ui-container--align-left'
            }

            if (this.align == 'around') {
                return 'ui-container--around'
            }
        },
        directionClass: function() {
            if (this.direction == 'row') {
                return null
            }

            return 'ui-container--column'
        },
        fullClass: function() {
            if (this.fullWidth) {
                return 'ui-container--full-width'
            }
        },
        containClass: function() {
            if (this.contain) {
                return 'container'
            }
        },
        bgColorClass: function() {
            if (this.bgColor) {
                return 'bg-' + this.bgColor
            }
        }
    },
    mounted: function() {
        if (this.minWidth) {
            this.$refs.container.style.minWidth = this.minWidth
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-container {
    $self: &;
    display: flex;

    &--align-center {
        justify-content: center;
        align-items: center;
    }

    &--around {
        justify-content: space-around;
        align-items: center;
    }

    &--column {
        flex-direction: column;
    }

    &--full-width {
        width: 100%;
    }
}
</style>
