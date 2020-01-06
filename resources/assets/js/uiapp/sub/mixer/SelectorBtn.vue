<template>
    <div class="selector-btn"
        :class="isAvailable"
        @click="select">
        {{ current }}
    </div>
</template>

<script>
export default {
    name: 'SelectorBtn',
    props: {
        idx: {
            type: Number,
            default: 0,
        },
        src: [String, Object]
    },
    data: function() {
        return {
            isAvailable: ''
        }
    },
    watch: {
        src: function(src) {
            this.toggleAvailable()
        }
    },
    computed: {
        current: function() {
            return this.idx + 1
        },
    },
    methods: {
        toggleAvailable: function() {
            if (this.src && this.src != null) {
                this.isAvailable = 'unavailable'
            } else {
                this.isAvailable = ''
            }
        },
        select: function() {
            this.$emit('selected', this.idx)
        },
    },
    mounted: function() {
        this.toggleAvailable()
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.selector-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: $green;
    font-weight: bold;
    min-width: $spacer * 2 * 1.618;
    min-height: $spacer * 2 * 1.618;
    cursor: pointer;
    @include border-radius($border-radius);
    transition: $transition-base;

    &:hover {
        background-color: $light-gray;
        transition: $transition-base;
    }

    &.unavailable {
        background-color: $tfc-orange;
    }
}

</style>
