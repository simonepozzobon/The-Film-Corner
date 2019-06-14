<template>
    <div
        class="layer-single"
        :class="activeClass">
        <div class="layer-single__idx">
            {{ idx }}
        </div>
        <div class="layer-single__title">
            {{ title }}
        </div>
        <div class="layer-single__tools">
            <ui-button
                color="white"
                display="inline-block"
                :has-container="false"
                :has-margin="false"
                @click.native="selectLayer">
                Select
            </ui-button>
            <ui-button
                color="white"
                display="inline-block"
                :has-container="false"
                :has-margin="false"
                @click.native="deleteLayer">
                Delete
            </ui-button>
        </div>
    </div>
</template>

<script>
import { fabric } from 'fabric'
import { UiButton } from '../../../ui'

export default {
    name: 'LayerSingle',
    components: {
        UiButton,
    },
    props: {
        idx: {
            type: Number,
            default: 0,
        },
        layer: {
            type: Object,
            default: function() {}
        },
    },
    data: function() {
        return {
            active: false,
            uuid: null,
        }
    },
    computed: {
        activeClass: function() {
            if (this.active) {
                return 'layer-single--active'
            }
        },
        obj: function() {
            return this.layer.toJSON()
        },
        title: function() {
            return this.obj.originalObj.title
        }
    },
    methods: {
        setUuid: function() {
            this.uuid = this.obj.uuid
        },
        selectLayer: function() {
            this.$emit('select-layer', this.idx)
        },
        deleteLayer: function() {
            this.$emit('delete-layer', this.idx)
        },
        setActive: function() {
            this.active = true
        },
        unsetActive: function() {
            this.active = false
        }
    },
    mounted: function() {
        this.setUuid()
        // console.log(this.obj);
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.layer-single {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
    transition: $transition-base;
    padding: $spacer / 2;

    &:hover {
        background-color: rgba($white, .2);
        transition: $transition-base;
    }

    &__idx {
        color: $white;
        line-height: 0;
    }

    &__title {
        color: white;
    }

    &--active {
        background-color: rgba($green, .2);
        transition: $transition-base;
    }
}
</style>
