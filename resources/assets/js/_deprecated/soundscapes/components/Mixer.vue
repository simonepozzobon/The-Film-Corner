<template>
    <div class="row mt">
        <div class="col">
            <div class="box green">
                <div class="box-body">
                    <div id="mixer" class="mixer-container row">
                        <mixer-slot
                            v-for="(slot, i) in this.$root.players"
                            :key="i"
                            :player="slot"
                            :idx="i"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MixerSlot from './MixerSlot.vue'

export default {
    name: 'Mixer',
    components: {
        MixerSlot,
    },
    data: function() {
        return {
            slot: 6,
        }
    }
}
</script>

<style lang="scss">
</style>
