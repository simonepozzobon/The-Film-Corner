<template lang="html">
    <div
        class="ui-block"
        :class="[
                sizeClass,
                alignClass,
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
        :class="[sizeClass, colorClass, alignClass, directionClass, radiusClass, transparentClass]"
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
            }
        },
        directionClass: function() {
            if (this.direction == 'row') {
                return 'ui-block--flex-row'
            }
        },
        radiusClass: function() {
            if (this.radius) {
                return 'ui-block--radius'
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

    &--radius &__container {
        @include border-radius(5px);
    }

    &--align-start &__container {
        align-items: flex-start;
    }

    &--flex-row &__container {
        flex-direction: row;
        align-items: center
    }

    &--flex-row#{&}--align-start &__container {
        justify-content: flex-start;
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
