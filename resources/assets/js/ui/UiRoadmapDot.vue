<template>
<div
    class="roadmap-dot"
    :class="[
        isActiveClass,
    ]"
    @click="clicked"
>
    <div class="roadmap-dot__wrapper">
        <div class="roadmap-dot__period">
            {{ point.year }}
        </div>
        <div
            class="roadmap-dot__circle"
            :class="bgClass"
        >
        </div>
        <div class="roadmap-dot__label">
            {{ point.title }}
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'UiRoadmapDot',
    props: {
        point: {
            type: Object,
            default: function () {
                return {}
            },
        },
        isActive: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        colorClass: function () {
            if (this.point.color) {
                return 'roadmap-dot--' + this.point.color
            }
            return null
        },
        isActiveClass: function () {
            if (this.isActive) {
                return 'roadmap-dot--is-active'
            }
            return null
        },
        bgClass: function () {
            if (this.point.color) {
                return 'bg-' + this.point.color
            }
            return null
        },
    },
    methods: {
        clicked: function () {
            this.$emit('click', this.point)
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
$size-close: $spacer * 2 !default;
$size-hover: $spacer * 4 !default;

.roadmap-dot {
    width: 100%;
    height: 100%;
    position: relative;
    // background-color: rgba($red, .4);

    &__wrapper {
        width: 100%;
        height: 100%;
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        // background-color: rgba($red, .4);
    }

    &__circle {
        position: absolute;
        content: '';
        cursor: pointer;
        width: $size-close;
        height: $size-close;
        @include border-radius($size-close);
        background-color: $light;
        border: 4px solid $black;
        transform-origin: 50% 50%;
        transition: $transition-base;
    }

    &__period {
        position: absolute;
        text-align: right;
        right: 50%;
        width: 100%;
        white-space: nowrap;
        font-size: $h4-font-size;
        font-weight: $font-weight-bolder;
        margin-right: $size-close;
        transition: $transition-base;
    }

    &__label {
        position: absolute;
        left: 50%;
        width: 100%;
        white-space: nowrap;
        font-size: $h4-font-size;
        font-weight: $font-weight-bolder;
        margin-left: $size-close;
        transition: $transition-base;
    }

    &--is-active &,
    &:hover & {
        &__circle {
            width: $size-hover;
            height: $size-hover;
            border: 6px solid $black;
            @include border-radius($size-hover);
            transition: $transition-base;
        }

        &__period {
            margin-right: $size-hover;
        }

        &__label {
            margin-left: $size-hover;
        }
    }

    &--red &__circle {
        background-color: $red;
    }

    &--green-var &__circle {
        background-color: $green-var;
    }

    &--teal &__circle {
        background-color: $teal;
    }

    &--orange &__circle {
        background-color: $orange;
    }
}
</style>
