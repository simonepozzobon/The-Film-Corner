<template>
    <b-modal
        ref="modal"
        title="Select Channel"
        hide-footer>
        <ui-row justify="space-around">
            <selector-btn
                v-for="(player, i) in players"
                :key="i"
                :idx="i"
                :src="player.obj"
                @selected="selected"/>
        </ui-row>
    </b-modal>
</template>

<script>
import SelectorBtn from './SelectorBtn.vue'
import { UiRow } from '../../../ui'

export default {
    name: 'ChannelSelector',
    components: {
        SelectorBtn,
        UiRow,
    },
    props: {
        players: {
            type: Array,
            default: function() {}
        }
    },
    methods: {
        selected: function(idx) {
            this.$emit('channel-selected', idx)
            this.$refs.modal.hide()
        },
        show: function() {
            this.$refs.modal.show()
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
