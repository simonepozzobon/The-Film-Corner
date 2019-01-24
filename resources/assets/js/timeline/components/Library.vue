<template lang="html">
    <div class="box yellow">
        <div class="box-header">
            {{ title }}
        </div>
        <div id="video-library" class="box-body library">
            <nav class="navbar navbar-expand-sm navbar-library yellow">
                <div class="w-100" id="navbarNav">
                    <ul class="nav navbar-nav nav-tabs" role="tablist">
                        <li class="nav-item w-50" v-if="this.upload">
                            <a id="video-tab" class="library-link nav-link active" data-toggle="tab" href="#video-editor-library">{{ videoText }}</a>
                        </li>
                        <li class="nav-item" v-else>
                            <a id="video-tab" class="library-link nav-link active" data-toggle="tab" href="#video-editor-library">{{ videoText }}</a>
                        </li>
                        <li class="nav-item w-50" v-if="this.upload">
                            <a id="upload-tab" class="library-link nav-link" data-toggle="tab" href="#uploads">Upload</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div id="libraries" class="library-container tab-content" ref="library">
                <div id="video-editor-library" class="assets tab-pane fade show active" role="tabpanel" aria-labelledby="video-tab">
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
                <div id="uploads" class="assets tab-pane fade" role="tabpanel" aria-labelledby="upload-tab" v-if="this.upload">
                    <div class="row scroller">
                        <div class="col">
                            <upload-form
                                :csrf_field="csrf_field"
                                :app_id="app_id"
                                :route="upload_route">
                            </upload-form>
                            <div class="">
                                <table id="upload-assets" class="table table-hover">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
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
import UploadForm from './UploadForm.vue'

export default {
    name: 'Library',
    components: {
        LibraryItem,
        UiModal,
        UploadForm,
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
        }
    },
    watch: {
        '$root.playerHeight': function(h) {
            console.log('hhhhh',h)
            this.$refs.library.style.height = h + 'px'
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
