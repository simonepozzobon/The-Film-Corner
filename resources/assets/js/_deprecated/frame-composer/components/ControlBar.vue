<template lang="html">
    <div class="row mt">
        <div class="col">
            <div class="box orange">
                <div class="box-header">
                    Layers
                </div>
                <div class="box-body">
                    <layer-item
                        v-for="(item, i) in this.$root.objs"
                        :key="i"
                        :idx="i"
                        :obj="item"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayerItem from './LayerItem.vue'
export default {
    name: 'ControlBar',
    components: {
        LayerItem,
    },
    props: {
        deselect_all: {
            type: String,
            default: '',
        },
        move_back: {
            type: String,
            default: '',
        },
        move_backward: {
            type: String,
            default: '',
        },
        move_forward: {
            type: String,
            default: '',
        },
        move_to_front: {
            type: String,
            default: '',
        },
        remove: {
            type: String,
            default: '',
        },
    },

}
</script>

<style lang="css">
</style>
