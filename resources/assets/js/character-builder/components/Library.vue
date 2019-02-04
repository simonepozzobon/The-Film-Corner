<template lang="html">
    <div class="col-md-4">
        <div class="box yellow">
            <div class="box-header">
                {{ title }}
            </div>
            <div id="video-library" class="box-body library" ref="container">
                <nav class="navbar navbar-expand-sm navbar-library yellow">
                    <div class="w-100" id="navbarNav">
                        <ul class="nav navbar-nav nav-tabs customs" role="tablist">
                            <li class="nav-item" v-for="(library, i) in this.libraries">
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
                        v-for="(library, i) in this.libraries"
                        :key="i"
                        :library="library"
                        :idx="i"
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
            </div>
        </div>
    </div>
</template>

<script>
import LibraryContainer from './LibraryContainer.vue'
import UploadForm from './UploadForm.vue'

export default {
    name: 'Library',
    components: {
        LibraryContainer,
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
        libraries: {
            type: Array,
            default: function() {}
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
        '$root.previewHeight': function(h) {
            this.$refs.container.style.height = h + 'px'
        }
    },
    computed: {
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
