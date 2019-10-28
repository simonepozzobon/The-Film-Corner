<template>
<div class="up-zone">
    <vue-dropzone
        ref="drop"
        :useCustomSlot="true"
        id="dropzone"
        @vdropzone-upload-progress="uploadProgress"
        :options="dropOpts"
        @vdropzone-file-added="fileAdded"
        @vdropzone-sending-multiple="sendingFiles"
        @vdropzone-success-multiple="success"
    ></vue-dropzone>
</div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';

export default {
    name: 'UploadZone',
    components: {
        vueDropzone: vue2Dropzone
    },
    props: {
        accept: {
            type: String,
            default: null,
        },
    },
    data: function () {
        return {
            dropOpts: {
                url: `the server url, where you want your filesto be sent`,
                maxFilesize: 500,
                // headers: {
                //     // Authorization: `<your application access-token>`
                // },
                paramName: function (n) {
                    return "file[]";
                },
                dictDefaultMessage: "Carica un nuovo file",
                includeStyling: false,
                previewsContainer: false,
                thumbnailWidth: 250,
                thumbnailHeight: 140,
                uploadMultiple: false,
                parallelUploads: 1,
                acceptedFiles: this.accept,
            }
        }
    },
    methods: {
        uploadProgress: function () {

        },
        fileAdded: function () {

        },
        sendingFiles: function () {

        },
        success: function () {

        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
