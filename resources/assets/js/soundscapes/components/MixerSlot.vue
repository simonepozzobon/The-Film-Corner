<template lang="html">
    <div class="col-md-2 d-flex flex-column align-items-center justify-content-center">
        <vue-slider
            v-model="volume"
            :value="50"
            :width="4"
            :height="100"
            direction="vertical"
            :disabled="isDisable"
        />

        <div class="pt-3" v-if="!this.isDisable">
            <button class="btn btn-green" @click="removeItem">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</template>

<script>
import vueSlider from 'vue-slider-component'

export default {
    name: 'MixerSlot',
    components: {
        vueSlider,
    },
    props: {
        player: {
            type: Object,
            default: function() {}
        },
        idx: {
            type: Number,
            default: 0,
        }
    },
    data: function() {
        return {
            volume: 50,
            isDisable: true,
        }
    },
    watch: {
        '$root.players': function(item) {
            if (!item[this.idx].src) {
                this.isDisable = true
            }
        },
        volume: function(vol) {
            this.setVolume(vol)
        }
    },
    methods: {
        setVolume: function(vol = 0) {
            this.$root.players[this.idx].player.setVolume(vol / 100)
            this.$root.players[this.idx].volume = vol
            this.$root.saveLocal()
        },
        removeItem: function() {
            this.$root.removeItem(this.idx)
            this.isDisable = true
        }
    },
    mounted: function() {
        this.$root.players[this.idx].player.on('ready', () => {
            console.log('player pronto ->'+this.idx)
            this.isDisable = false
            this.setVolume(this.volume)
            this.$root.$emit('item-unavailable', this.idx)
        })
    }
}
</script>

<style lang="css">
</style>
