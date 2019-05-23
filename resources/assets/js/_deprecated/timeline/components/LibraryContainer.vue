<template lang="html">
    <div :id="'video-'+library.id+'-library'" class="assets tab-pane fade" :class="isActive" role="tabpanel" aria-labelledby="video-tab">
        <div class="row scroller">
            <div class="col">
                <library-item
                    v-for="(item, j) in library.videos"
                    :key="j"
                    :title="item.title"
                    :obj="item"
                    @preview="preview"/>
            </div>
        </div>
    </div>
</template>

<script>
import LibraryItem from './LibraryItem.vue'
export default {
    name: 'LibraryContainer',
    components: {
        LibraryItem,
    },
    props: {
        library: {
            type: Object,
            default: function() {}
        },
        idx: {
            type: Number,
            default: 0,
        }
    },
    computed: {
        isActive: function() {
            if (this.idx == 0) {
                return 'show active'
            }
            return
        }
    },
    methods: {
        preview: function(src, poster) {
            this.$emit('preview', src, poster)
        }
    }
}
</script>

<style lang="css">
</style>
