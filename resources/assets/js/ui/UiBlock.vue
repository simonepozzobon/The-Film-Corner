<template>
    <div
        class="ui-block"
        :class="[
                sizeClass,
                alignClass, justifyClass,
                directionClass,
                radiusClass,
                transparentClass,
                fullHeightClass,
            ]"
        ref="block"
        v-if="hasContainer">

        <div
            class="ui-block__container"
            :class="colorClass"
            ref="container">
            <slot></slot>
        </div>
    </div>

    <div
        class="ui-block"
        :class="[sizeClass, colorClass, alignClass, justifyClass, directionClass, radiusClass, transparentClass]"
        ref="block"
        v-else>
            <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'UiBlock',
    props: {
        size: {
            type: [Number, String],
            default: 6,
        },
        hasContainer: {
            type: Boolean,
            default: true,
        },
        color: {
            type: String,
            default: null,
        },
        align: {
            type: String,
            default: null,
        },
        justify: {
            type: String,
            default: null,
        },
        direction: {
            type: String,
            default: null,
        },
        transparent: {
            type: Boolean,
            default: false,
        },
        radius: {
            type: Boolean,
            default: false,
        },
        radiusSize: {
            type: String,
            default: null,
        },
        fullHeight: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        sizeClass: function() {
            if (this.size == 'auto') {
                return 'col'
            }
            return 'col-md-' + this.size
        },
        colorClass: function() {
            if (this.color && this.transparent) {
                return 'ui-block--transparent-'+this.color
            } else if (this.color) {
                return 'bg-' + this.color
            }
        },
        alignClass: function() {
            if (this.align == 'start') {
                return 'ui-block--align-start'
            } else if (this.align == 'between') {
                return 'ui-block--align-between'
            } else if (this.align == 'end') {
                return 'ui-block--align-end'
            }
        },
        justifyClass: function() {
            if (this.justify == 'start') {
                return 'ui-block--justify-start'
            } else if (this.justify == 'between') {
                return 'ui-block--justify-between'
            } else if (this.justify == 'center') {
                return 'ui-block--justify-center'
            } else if (this.justify == 'end') {
                return 'ui-block--justify-end'
            }
        },
        directionClass: function() {
            if (this.direction == 'row') {
                return 'ui-block--flex-row'
            }
        },
        radiusClass: function() {
            if (this.radius && !this.radiusSize) {
                return 'ui-block--radius'
            } else if (this.radius && this.radiusSize) {
                return 'ui-block--radius-'+this.radiusSize
            }
        },
        radiusSizeClass: function() {
            if (this.radiusSize) {
            }
        },
        transparentClass: function() {
            if (this.transparent) {
                return 'ui-block--transparent'
            }
        },
        fullHeightClass: function() {
            if (this.fullHeight) {
                return 'ui-block--full-height'
            }
        },
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-block {
    $self: &;

    &__container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    &--radius {
        @include border-radius(5px);
    }

    &--radius-md {
        @include border-radius(16px);
    }

    &--radius &__container {
        @include border-radius(5px);
    }

    &--radius-md &__container {
        @include border-radius(16px);
    }

    &--align-start &__container {
        align-items: flex-start;
    }

    &--align-end &__container {
        align-items: flex-end;
    }


    &--flex-row &__container {
        flex-direction: row;
        align-items: center
    }

    &--flex-row#{&}--align-start &__container {
        justify-content: flex-start;
    }

    &--flex-row#{&}--align-end &__container {
        justify-content: flex-end;
    }

    &--flex-row#{&}--justify-end &__container {
        align-items: flex-end;
    }

    &--flex-row#{&}--justify-center &__container {
        align-items: center;
    }

    &--transparent-red {
        background-color: rgba($red, .8);
    }

    &--transparent-yellow {
        background-color: rgba($yellow, .8);
    }

    &--transparent-green {
        background-color: rgba($green, .8);
    }

    &--full-height &__container {
        height: 100%;
        justify-content: flex-start;
    }
}

</style>
