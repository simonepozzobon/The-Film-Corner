<template lang="html">
    <div class="selector-btn" :class="isAvailable" @click="select">
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
    },
    computed: {
        current: function() {
            return this.idx + 1
        },
    },
    data: function() {
        return {
            isAvailable: ''
        }
    },
    methods: {
        select: function() {
            this.$emit('selected', this.idx)
        }
    },
    mounted: function() {
        this.$root.$on('item-unavailable', idx => {
            if (idx == this.idx) {
                this.isAvailable = 'unavailable'
            }
        })

        this.$root.$on('item-available', idx => {
            if (idx == this.idx) {
                this.isAvailable = ''
            }
        })
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.selector-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: $tfc-green;
    font-weight: bold;
    min-width: $spacer * 2;
    min-height: $spacer * 2;
    cursor: pointer;

    &.unavailable {
        background-color: $tfc-orange;
    }
}

</style>
