<template lang="html">
    <div class="ui-button">
        <button
            class="btn ui-button__content"
            :class="[
                colorClass,
                blockClass,
            ]"
            :disabled="disable">
            <slot></slot>
        </button>
    </div>
</template>

<script>
export default {
    name: 'UiButton',
    props: {
        color: {
            type: String,
            default: null,
        },
        block: {
            type: Boolean,
            default: false,
        },
        disable: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        colorClass: function() {
            if (this.color) {
                return 'btn-'+this.color
            }
        },
        blockClass: function() {
            if (this.block) {
                return 'btn-block'
            }
        },
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-button {
    margin-bottom: $spacer;

    &__content {
        text-transform: uppercase;
        font-size: $font-size-base * 0.75;
        font-weight: 600;
        letter-spacing: 3px;
    }
}
</style>
