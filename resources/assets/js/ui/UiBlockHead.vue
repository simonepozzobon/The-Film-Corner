<template>
<div
    class="ui-block-head"
    :class="[
                sizeClass,
                alignClass,
                justifyClass,
                directionClass,
                radiusClass,
                transparentClass,
                fullHeightClass,
                colorVariationClass,
            ]"
    ref="block"
    v-if="hasContainer"
>

    <div
        class="ui-block-head__container"
        :class="colorClass"
        ref="container"
    >

        <ui-title
            class="ui-block-head__head"
            :title="title"
            align="center"
            :color="titleColorClass"
        />

        <div class="ui-block-head__content">
            <slot></slot>
        </div>
    </div>
</div>

<div
    class="ui-block-head"
    :class="[
                sizeClass,
                alignClass,
                justifyClass,
                directionClass,
                radiusClass,
                transparentClass,
                fullHeightClass,
                colorVariationClass,
                colorClass,
            ]"
    ref="block"
    v-else
>

    <ui-title
        class="ui-block-head__head"
        :title="title"
        align="center"
    />

    <div class="ui-block-head__content">
        <slot></slot>
    </div>

</div>
</template>

<script>
import UiTitle from './UiTitle.vue'

export default {
    name: 'UiBlock',
    components: {
        UiTitle,
    },
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
        title: {
            type: String,
            default: null,
        },
    },
    computed: {
        sizeClass: function () {
            if (this.size == 'auto') {
                return 'col'
            }
            return 'col-md-' + this.size
        },
        colorClass: function () {
            if (this.color && this.transparent) {
                return 'ui-block-head--transparent-' + this.color
            }
            else if (this.color) {
                return 'bg-' + this.color
            }
        },
        titleColorClass: function () {
            if (this.color == 'dark-gray') {
                return 'white'
            }
            return null
        },
        colorVariationClass: function () {
            if (this.color && !this.transparent) {
                return 'ui-block-head--' + this.color
            }
        },
        alignClass: function () {
            if (this.align == 'start') {
                return 'ui-block-head--align-start'
            }
            else if (this.align == 'between') {
                return 'ui-block-head--align-between'
            }
            else if (this.align == 'end') {
                return 'ui-block-head--align-end'
            }
        },
        justifyClass: function () {
            if (this.justify == 'start') {
                return 'ui-block-head--justify-start'
            }
            else if (this.justify == 'between') {
                return 'ui-block-head--justify-between'
            }
            else if (this.justify == 'center') {
                return 'ui-block-head--justify-center'
            }
            else if (this.justify == 'end') {
                return 'ui-block-head--justify-end'
            }
        },
        directionClass: function () {
            if (this.direction == 'row') {
                return 'ui-block-head--flex-row'
            }
        },
        radiusClass: function () {
            if (this.radius && !this.radiusSize) {
                return 'ui-block-head--radius'
            }
            else if (this.radius && this.radiusSize) {
                return 'ui-block-head--radius-' + this.radiusSize
            }
        },
        radiusSizeClass: function () {
            if (this.radiusSize) {}
        },
        transparentClass: function () {
            if (this.transparent) {
                return 'ui-block-head--transparent'
            }
        },
        fullHeightClass: function () {
            if (this.fullHeight) {
                return 'ui-block-head--full-height'
            }
        },
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-block-head {
    $self: &;
    overflow: hidden;

    &__container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    &__head {
        width: 100%;
    }

    &__content {
        width: 100%;
    }

    &--orange & {
        &__head {
            background-color: lighten($orange, 25);
        }
    }

    &--green & {
        &__head {
            background-color: lighten($green, 25);
        }
    }

    &--yellow & {
        &__head {
            background-color: lighten($yellow, 25);
        }
    }

    &--red & {
        &__head {
            background-color: lighten($red, 25);
        }
    }

    &--radius & {
        @include border-radius(5px);

        &__container {
            @include border-radius(5px);
        }
    }

    &--radius-md & {
        @include border-radius(16px);

        &__container {
            @include border-radius(16px);
        }
    }

    &--align-start &__container {
        align-items: flex-start;
    }

    &--align-end &__container {
        align-items: flex-end;
    }

    &--flex-row &__container {
        flex-direction: row;
        align-items: center;
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
