<template>
<div class="up-zone">
    <vue-dropzone
        ref="drop"
        :id="uuid"
        class="up-zone__content"
        :options="dropOpts"
        :use-custom-slot="true"
        :duplicate-check="true"
        :include-styling="false"
        @vdropzone-upload-progress="uploadProgress"
        @vdropzone-file-added="fileAdded"
        @vdropzone-sending="sendingRequest"
        @vdropzone-sending-multiple="sendingMultipleRequest"
        @vdropzone-success="success"
        @vdropzone-success-multiple="success"
        @vdropzone-error="manageErrors"
    ></vue-dropzone>
</div>
</template>

<script>
import toastr from 'toastr'
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
        params: {
            type: Object,
            default: function () {
                return {}
            }
        },
        url: {
            type: String,
            default: null,
            required: true,
        },
        multiple: {
            type: Boolean,
            default: false,
        },
    },
    data: function () {
        return {
            dropOpts: {
                url: this.url,
                maxFilesize: null,
                dictDefaultMessage: "Carica un nuovo file",
                previewsContainer: false,
                thumbnailWidth: 250,
                thumbnailHeight: 140,
                uploadMultiple: this.multiple,
                parallelUploads: this.multiple ? 2 : 1,
                acceptedFiles: this.accept,
            }
        }
    },
    computed: {
        uuid: function () {
            return this.$util.uuid()
        },
    },
    watch: {
        requestParams: function (params) {

        },
    },
    methods: {
        uploadProgress: function () {

        },
        fileAdded: function () {
            toastr.info('file added')
        },
        success: function () {

        },
        sendingRequest: function (file, xhr, formData) {
            toastr.info('sending request', formData)

            for (let key in this.params) {
                if (this.params.hasOwnProperty(key)) {
                    formData.append(key, this.params[key])
                }
            }
        },
        sendingMultipleRequest: function () {

        },
        manageErrors: function (file, message, xhr) {
            toastr.error('errore')
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.up-zone {
    &__content {
        background-color: transparent;
        font-family: $font-family-base;
    }
}
</style>
