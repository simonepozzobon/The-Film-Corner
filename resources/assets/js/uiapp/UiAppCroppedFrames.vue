<template>
<div>
    <transition-group>
        <single-frame
            v-for="(frame, i) in frames"
            :key="frame.id"
            :color="color"
            :idx="i"
            :text="frame.text"
            :uuid="frame.id"
            :img="frame.img"
            @changed="changed"
            @delete-frame="deleteFrame"
            @loaded="$emit('loaded')"
        />
    </transition-group>
</div>
</template>

<script>
import SingleFrame from './sub/cropped/SingleFrame.vue'
export default {
    name: 'UiAppCroppedFrames',
    components: {
        SingleFrame,
    },
    props: {
        frames: {
            type: Array,
            default: function () {}
        },
        color: {
            type: String,
            default: 'green',
        }
    },
    methods: {
        deleteFrame: function (id) {
            this.$emit('delete-frame', id)
        },
        changed: function (value, uuid) {
            this.$emit('changed', value, uuid)
        }
    },
    filters: {
        formatFrameTitle: function (idx) {
            return 'Frame ' + (idx + 1)
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
