<template lang="html">
    <div class="col-md-4">
        <div class="box yellow">
            <div class="box-header">
                {{ title }}
            </div>
            <div id="video-library" class="box-body library">
                <nav class="navbar navbar-expand-sm navbar-library yellow">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="nav navbar-nav nav-tabs" role="tablist">
                            <li class="nav-item w-50">
                                <a id="audio-tab" class="nav-link active" data-toggle="tab" href="#audio-editor-library" role="tab" aria-controls="audio-editor-library" aria-selected="true">{{ audio_text }}</a>
                            </li>
                            <li class="nav-item w-50">
                                <a id="image-tab" class=" nav-link" data-toggle="tab" href="#image-editor-library" role="tab" aria-controls="image-editor-library" aria-selected="false">{{ image_text }}</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div id="libraries" class="library-container tab-content" ref="library">
                    <div id="audio-editor-library" class="assets tab-pane fade show active" role="tabpanel" aria-labelledby="audio-tab">
                        <div class="row scroller">
                            <div class="col">
                                <library-item-audio
                                    v-for="(item, i) in library_audio"
                                    :key="i"
                                    :title="item.title"
                                    :obj="item"
                                    @preview="preview"/>
                            </div>
                        </div>
                    </div>
                    <div id="image-editor-library" class="assets tab-pane fade" role="tabpanel" aria-labelledby="image-tab">
                        <div class="row scroller">
                            <div class="col">
                                <library-item
                                    v-for="(item, i) in library_media"
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
    </div>
</template>

<script>
import LibraryItem from './LibraryItem.vue'
import LibraryItemAudio from './LibraryItemAudio.vue'
import UiModal from './UiModal.vue'

export default {
    name: 'Library',
    components: {
        LibraryItem,
        LibraryItemAudio,
        UiModal,
    },
    props: {
        title: {
            type: String,
            default: 'title'
        },
        audio_text: {
            type: String,
            default: 'Audio'
        },
        image_text: {
            type: String,
            default: 'Image'
        },
        elements: {
            type: String,
            default: null
        },
        csrf_field: {
            type: String,
            default: null,
        },
        upload_route: {
            type: String,
            default: null,
        },
        app_id: {
            type: String,
            default: null,
        },
        upload: {
            type: Boolean,
            default: false
        },
        library_media: {
            type: Array,
            default: function() {}
        },
        library_audio: {
            type: Array,
            default: function() {}
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
    watch: {
        '$root.window': function(size) {
            this.$refs.library.style.height = this.$root.playerHeight + 'px'
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
