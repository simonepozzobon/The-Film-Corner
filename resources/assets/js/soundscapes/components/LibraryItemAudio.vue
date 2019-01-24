<template lang="html">
    <div class="row align-items-center">
        <div class="col-md-2">
            <i class="fa fa-file-audio-o fa-2x" />
        </div>
        <div class="col-md-6">
            <p class="pl-2 pr-2 mb-0">{{ title }}</p>
        </div>
        <div class="col-md-4">
            <div class="btn-group">
                <button
                    class="btn btn-secondary btn-yellow"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Preview"
                    @click="showPreview">
                    <i class="fa fa-play" aria-hidden="true"></i>
                </button>
                <button
                    class="btn btn-secondary btn-yellow"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Add To Timeline"
                    @click="addToTimeline">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LibraryItem',
    props: {
        title: {
            type: String,
            default: 'title'
        },
        obj: {
            type: Object,
            default: function() {}
        }
    },
    methods: {
        addToTimeline: function() {
            console.log(this.obj)
            this.$root.$emit('add-to-mixer', this.obj)
        },
        showPreview: function() {
            this.$emit('preview', this.obj.src, this.obj.img)
        }
    }
}
</script>

<style lang="scss">
</style>
