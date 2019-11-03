<template>
    <div class="layer-item" :class="isActive">
        <div>
            {{ idx }}
        </div>
        <div class="layer-title">
            {{ parsedObj.originalObj.title }}
        </div>
        <div class="layer-tools">
            <button
                class="btn btn-secondary btn-orange"
                @click="selectItem"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Select">
                <i class="fa fa-check-circle"></i>
            </button>
            <button
                class="btn btn-secondary btn-orange"
                @click="deleteTrack"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Delete">
                <i class="fa fa-trash-o right-tool" />
            </button>
        </div>
    </div>
</template>

<script>
import {fabric} from 'fabric'
export default {
    name: 'LayerItem',
    props: {
        idx: {
            type: Number,
            default: 0,
        },
        obj: {
            type: Object,
            default: function() {}
        }
    },
    computed: {
        parsedObj: function() {
            return this.obj.toJSON()
        }
    },
    data: function() {
        return {
            isActive: '',
        }
    },
    methods: {
        selectItem: function() {
            this.$root.canvas.setActiveObject(this.$root.objs[this.idx])
            this.$root.canvas.renderAll()
        },
        deleteTrack: function() {
            this.$root.canvas.discardActiveObject()
            this.$root.canvas.remove(this.$root.objs[this.idx])
            this.isActive = null
            this.$root.canvas.renderAll()
            this.$root.objs.splice(this.idx, 1)
        }
    },
    mounted: function() {
        this.$root.$on('canvas-select', els => {
            let check = els.findIndex(el => el.uuid == this.parsedObj.uuid)
            if (check > -1) {
                this.isActive = 'selected'
            } else {
                this.isActive = null
            }
        })


        this.$root.$on('canvas-deselect', els => {
            let check = els.findIndex(el => el.uuid == this.parsedObj.uuid)
            if (check > -1) {
                this.isActive = null
            }
        })
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.layer-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: $spacer / 4;
    padding: $spacer / 4;
    cursor: pointer;

    &:hover {
        background-color: rgba($black, .2);
    }

    &.selected {
        background-color: rgba($tfc-dark-orange, .3);

        &:hover {
            background-color: rgba($tfc-dark-orange, .8);
        }
    }
}
</style>
