<template lang="html">
    <div
        class="ui-library-item"
        :data-delay="delay"
        :data-index="index">
        <div
            class="ui-library-item__preview"
            @mouseover="mouseEnter"
            @mouseleave="mouseLeave"
            @click="selected">
            <library-hover
                class="ui-library-item__cross"
                ref="hover"
                @ready="initialized"/>
            <div class="ui-library-item__overlay"></div>
            <img :src="img" alt="" class="ui-library-item__img" ref="image">
        </div>
        <div class="ui-library-item__title">
            {{ title }}
        </div>
    </div>
</template>

<script>
import LibraryHover from './LibraryHover.vue'
export default {
    name: 'LibraryItemVideo',
    components: {
        LibraryHover,
    },
    props: {
        title: {
            type: String,
            default: 'Titolo',
        },
        img: {
            type: String,
            default: '/img/test-app/1.png',
        },
        delay: {
            type: Number,
            default: 0,
        },
        index: {
            type: Number,
            default: 0,
        },
    },
    data: function() {
        return {
            ready: false
        }
    },
    methods: {
        initialized: function() {
            this.ready = true
        },
        mouseEnter: function() {
            if (this.ready) {
                this.$refs.hover.play()
            }
        },
        mouseLeave: function() {
            if (this.ready) {
                this.$refs.hover.reverse()
            }
        },
        selected: function() {
            this.$emit('selected', this.index)
        },
    },
    mounted: function() {
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-library-item {
    width: 100%;
    display: flex;
    align-items: center;
    margin-bottom: $spacer / 2;

    &__preview {
        position: relative;
        max-width: 39%;
        flex: 0 0 39%;
        cursor: pointer;
    }

    &__cross {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
    }

    &__overlay {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        background-color: rgba($dark-gray, .3);
        z-index: 1;
    }

    &__img {
        max-width: 100%;
        max-height: 100%;
    }

    &__title {
        margin-left: $spacer;
        flex-basis: 61%;
        max-width: 61%;
    }
}
</style>
