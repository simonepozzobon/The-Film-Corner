<template lang="html">
    <div
        class="ui-block"
        :class="[sizeClass, alignClass, directionClass]"
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
        :class="[sizeClass, colorClass, alignClass, directionClass]"
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
        }
    },
    computed: {
        sizeClass: function() {
            if (this.size == 'auto') {
                return 'col'
            }
            return 'col-md-' + this.size
        },
        colorClass: function() {
            if (this.color) {
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
        }
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
}

</style>
