<template>
    <div
        class="ui-folder-corner"
        :class="[colorClass]">
        <svg
            class="ui-folder-corner__svg"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 341.05 88.03">
            <path
                class="ui-folder-corner__path"
                d="M54.89,0s-20,0-28.55,18.08L1.82,70S-6.73,88,13.27,88H321.05s20,0,20-20V20s0-20-20-20Z"/>
        </svg>
        <svg
            v-if="hasTimes"
            class="ui-folder-corner__times"
            @click.prevent="clicked"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.35 23.35">
            <path
                class="ui-folder-corner__cross"
                d="M22.49.86.86,22.48M.58.58,22.77,22.77"/>
        </svg>
    </div>
</template>

<script>
export default {
    name: 'UiFolderCorner',
    props: {
        hasTimes: {
            type: Boolean,
            default: false,
        },
        color: {
            type: String,
            default: 'green',
        }
    },
    computed: {
        colorClass: function() {
            return 'ui-folder-corner--' + this.color
        }
    },
    methods: {
        clicked: function() {
            this.$emit('click')
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-folder-corner {
    width: 33%;
    position: relative;
    transform: translateY(60%);

    &__svg {
    }

    &__path {
        fill: $green;
    }

    &__times {
        width: 18px;
        height: 18px;
        position: absolute;
        top: 25%;
        right: $spacer;
        z-index: 1;
        cursor: pointer;
        transform: translateY(-50%)
    }

    &__cross {
        fill: none;
        stroke: #1d1d1b;
        stroke-width: 1.6269999742507935px;
    }

    &--green &__path {
        fill: $green;
    }
    &--yellow &__path {
        fill: $yellow;
    }
    &--red &__path {
        fill: $red;
    }
}
</style>
