<template>
<div
    class="step"
    :class="isCompleted"
>
    <div class="step__circle">
        <span class="step__number">
            {{ number }}
        </span>
    </div>
</div>
</template>

<script>
export default {
    name: 'Step',
    props: {
        number: {
            type: Number,
            default: 0,
        },
        completed: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        isCompleted: function () {
            if (this.completed) {
                return 'step--completed'
            }
            else {
                return null
            }
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.step {
    margin-left: $spacer / 2;

    &__circle {
        position: relative;
        width: $spacer * 3;
        height: $spacer * 3;
        background-color: $red;
        @include border-radius($spacer * 1.5);
        @include custom-inner-shadow(darken($red, 15));
        cursor: pointer;
    }

    &__number {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        color: $white;
        font-size: $font-size-lg;
        font-weight: bold;
        @include custom-text-shadow(darken($red, 60));
        cursor: pointer;
    }

    &__circle:hover {
        background-color: darken($red, 5);
        @include custom-inner-shadow(darken($red, 20));
    }

    &--completed & {
        &__circle {
            background-color: $teal;
            @include custom-inner-shadow(darken($teal, 15));
        }

        &__circle:hover {
            background-color: darken($teal, 5);
            @include custom-inner-shadow(darken($teal, 20));
        }

        &__number {
            @include custom-text-shadow(darken($teal, 60));
        }
    }
}
</style>
