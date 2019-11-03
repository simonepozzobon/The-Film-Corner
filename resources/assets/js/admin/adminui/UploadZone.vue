<template>
<div class="up-zone">
    <vue-dropzone
        ref="drop"
        :id="uuid"
        class="up-zone__content"
        :options="dropOpts"
        :use-custom-slot="true"
        :duplicate-check="true"
        :include-styling="useStyles"
        @vdropzone-upload-progress="uploadProgress"
        @vdropzone-file-added="fileAdded"
        @vdropzone-files-added="filesAdded"
        @vdropzone-sending="sendingRequest"
        @vdropzone-sending-multiple="sendingMultipleRequest"
        @vdropzone-success="success"
        @vdropzone-success-multiple="success"
        @vdropzone-error="manageErrors"
        @vdropzone-mounted="dropzoneMounted"
    >
        <span>
            Carica un nuovo file
        </span>
    </vue-dropzone>
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
        autoProcessQueue: {
            type: Boolean,
            default: true,
        },
        useStyles: {
            type: Boolean,
            default: false,
        },
    },
    data: function () {
        return {
            dropOpts: {
                url: this.url,
                uploadMultiple: this.multiple,
                maxFile: this.multiple ? null : 1,
                // maxFilesize: null,
                dictDefaultMessage: "Carica un nuovo file",
                previewsContainer: false,
                thumbnailWidth: 250,
                thumbnailHeight: 140,
                parallelUploads: this.multiple ? 2 : 1,
                acceptedFiles: this.accept,
                autoProcessQueue: this.autoProcessQueue,
                // addRemoveLinks: true,
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
        fileAdded: function (file) {
            toastr.info('file added')
            this.$emit('file-added', file)
        },
        filesAdded: function (files) {
            toastr.info('files added')
            this.$emit('files-added', files)
        },
        success: function (file, response) {
            toastr.success('aggiunto')
            this.$emit('success', response)
            console.log(response);
        },
        sendingRequest: function (file, xhr, formData) {
            for (let key in this.params) {
                if (this.params.hasOwnProperty(key)) {
                    formData.append(key, this.params[key])
                }
            }
            toastr.warning('sending')
        },
        sendingMultipleRequest: function () {

        },
        manageErrors: function (file, message, xhr) {
            console.log(message);
            toastr.error('errore')
        },
        dropzoneMounted: function () {
            if (this.multiple == false) {
                this.$refs.drop.dropzone.hiddenFileInput.removeAttribute('multiple')
            }
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
$base-color: $gray-400;
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.up-zone {
    &__content {
        padding: $spacer * 1.618;
        @include border-radius($border-radius * 2);
        cursor: pointer;

        color: $base-color;
        font-family: $font-family-base;
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 3px;
        border: 2px dashed $base-color;

        &:hover {
            color: darken($base-color, 5);
            border-color: darken($base-color, 5);
            background-color: rgba($base-color, .1);
        }
    }
}
</style>
