<template lang="html">
    <div class="box yellow">
        <div class="box-header">
            {{ title }}
        </div>
        <div id="video-library" class="box-body library">
            <nav class="navbar navbar-expand-sm navbar-library yellow">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav" role="tablist">
                        <li class="nav-item">
                            <a class="library-link nav-link active" data-toggle="tab" href="#video-editor-library">{{ videoText }}</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div id="libraries" class="library-container">
                <div id="video-editor-library" class="assets active">
                    <div class="row scroller">
                        <div class="col">
                            <library-item
                                v-for="(item, i) in this.elementsParsed"
                                :key="i"
                                :title="item.title"
                                :obj="item"
                                @preview="preview"/>
                        </div>
                    </div>
                </div>
            </div>
            <ui-modal
                ref="modal"
                title="Preview"
            />
        </div>
    </div>
</template>

<script>
import LibraryItem from './LibraryItem.vue'
import UiModal from './UiModal.vue'

export default {
    name: 'Library',
    components: {
        LibraryItem,
        UiModal,
    },
    props: {
        title: {
            type: String,
            default: 'title'
        },
        videoText: {
            type: String,
            default: 'Video'
        },
        elements: {
            type: String,
            default: null
        }
    },
    computed: {
        elementsParsed: function() {
            if (this.elements) {
                return JSON.parse(this.elements)
            }
            return []
        }
    },
    data: function() {
        return {
        }
    },
    methods: {
        preview: function(src, poster) {
            this.$refs.modal.changeSrc(src, poster)            
        }
    },
    mounted: function() {

    }
}
</script>

<style lang="css">
</style>
