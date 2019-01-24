<template lang="html">
    <div class="row mb-1 align-items-center">
        <div class="col-md-2">
            <img :src="'/storage/'+this.obj.thumb" width="57">
        </div>
        <div class="col-md-6">
            <p class="p-2 mb-0">{{ title }}</p>
        </div>
        <div class="col-md-4">
            <div class="btn-group">
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
            this.$root.imageSelected = '/storage/' + this.obj.src
        },
        showPreview: function() {
        }
    }
}
</script>

<style lang="scss">
</style>
