<template lang="html">
    <div>
        <transition-group>
            <single-frame
                v-for="(frame, i) in frames"
                :key="frame.id"
                :idx="i"
                :uuid="frame.id"
                :img="frame.img"
                @changed="changed"
                @delete-frame="deleteFrame"/>
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
            default: function() {}
        }
    },
    methods: {
        deleteFrame: function(id) {
            this.$emit('delete-frame', id)
        },
        changed: function(value, uuid) {
            this.$emit('changed', value, uuid)
        }
    },
    filters: {
        formatFrameTitle: function(idx) {
            return 'Frame ' + (idx + 1)
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

</style>
