<template lang="html">
    <div class="col-md-8">
        <div class="box blue">
            <div class="box-header">
                {{ character_text }}
            </div>
            <div id="canvas-wrapper" class="box-body" ref="container">
                <div id="container-canvas">
                    <canvas class="image-editor" id="image-editor" ref="canvas"></canvas>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Preview',
    props: {
        character_text: {
            type: String,
            default: ''
        }
    },
    watch: {
        '$root.window': function(value) {
            this.getSize()
        }
    },
    methods: {
        getSize: function() {
            this.$root.previewHeight = this.$refs.container.offsetHeight
            this.$root.previewWidth = this.$refs.container.offsetWidth - 64
        }
    },
    mounted: function() {
        this.$root.$on('trigger-resize', () => {
            console.log('triggered')
            this.getSize()
        })
    }
}
</script>

<style lang="css">
</style>
