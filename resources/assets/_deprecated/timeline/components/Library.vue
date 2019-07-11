<template>
    <div class="box yellow">
        <div class="box-header">
            {{ title }}
        </div>
        <div id="video-library" class="box-body library">
            <nav class="navbar navbar-expand-sm navbar-library yellow">
                <div class="w-100" id="navbarNav">
                    <ul class="nav navbar-nav nav-tabs customs" role="tablist">
                        <li class="nav-item" v-for="(library, i) in this.elementsParsed">
                            <a :id="'library-'+library.name+'-tab'" class="library-link nav-link" data-toggle="tab" :href="'#video-'+library.id+'-library'" v-if="i == 0">{{ library.name }}</a>
                            <a :id="'library-'+library.name+'-tab'" class="library-link nav-link" data-toggle="tab" :href="'#video-'+library.id+'-library'" v-else>{{ library.name }}</a>
                        </li>
                        <li class="nav-item" v-if="this.upload">
                            <a id="upload-tab" class="library-link nav-link" data-toggle="tab" href="#uploads">Upload</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div id="libraries" class="library-container tab-content" ref="library">
                <library-container
                    v-for="(library, i) in this.elementsParsed"
                    :key="i"
                    :library="library"
                    :idx="i"
                    @preview="preview"
                />
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
import LibraryContainer from './LibraryContainer.vue'
import UiModal from './UiModal.vue'
import UploadForm from './UploadForm.vue'

export default {
    name: 'Library',
    components: {
        LibraryContainer,
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
        console.log(this.elementsParsed);
    }
}
</script>

<style lang="scss">
.customs {
    width: auto !important;
    justify-content: space-between;

    .nav-item {
        flex-grow: 1;
        width: inherit !important;
    }
}
</style>
