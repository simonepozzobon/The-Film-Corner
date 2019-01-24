<template lang="html">
    <div class="col-md-8">
        <div class="box blue">
            <div class="box-header">
                {{ title }}
            </div>
            <div class="box-body" ref="player">
                <div id="player" class="">
                <img id="image" :src="'/storage/'+this.$root.imageSelected" alt="" class="img-fluid w-100">
                    <div id="waveform-1" class="d-none"></div>
                    <div id="waveform-2" class="d-none"></div>
                    <div id="waveform-3" class="d-none"></div>
                    <div id="waveform-4" class="d-none"></div>
                    <div id="waveform-5" class="d-none"></div>
                    <div id="waveform-6" class="d-none"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Preview',
    props: {
        title: {
            type: String,
            default: ''
        },
    },
    watch: {
        '$root.window': function() {
            this.$root.playerHeight = this.$refs.player.offsetHeight
        }
    },
}
</script>

<style lang="css">
</style>
