<template>
<div class="up-zone">
    <vue-dropzone
        ref="drop"
        :id="uuid"
        class="up-zone__content"
        :options="dropOpts"
        :use-custom-slot="true"
        :duplicate-check="false"
        :include-styling="useStyles"
        @vdropzone-total-upload-progress="uploadProgress"
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
    <div
        v-if="progress >= 0"
        class="progress"
    >
        <div
            class="progress-bar progress__bar"
            role="progressbar"
            :style="`width: ${percentProgress};`"
            :aria-valuenow="progress"
            aria-valuemin="0"
            aria-valuemax="100"
        >
            <span class="progress__text">{{ percentProgress }}</span>
        </div>
    </div>
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
            progress: -1,
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
        percentProgress: function () {
            return `${this.progress}%`
        },
    },
    watch: {
        requestParams: function (params) {

        },
        progress: function (v) {
            if (v >= 100) {
                setTimeout(() => {
                    this.progress = -1
                }, 500)
            }
        },
    },
    methods: {
        uploadProgress: function (totaluploadprogress, totalBytes, totalBytesSent) {
            this.progress = Math.floor(totaluploadprogress);
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
            this.$refs.drop.removeAllFiles()
            this.$emit('success', response)
            toastr.success('aggiunto')
            // console.log(response);
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

.progress {
    margin-top: $spacer;
    height: $spacer * 1.618;
    position: relative;
    box-shadow: none;

    &__bar {
        // background-color: darken($base-color, 5);
        // @include gradient-directional(darken($base-color, 5), lighten($base-color, 5), -10deg);
        @include gradient-directional(lighten($green-light, 1), darken($green-light, 5), -10deg);
        @include custom-box-shadow-single($darken, 2px, 0.02);
        z-index: 1;
    }

    &__text {
        position: static;
        display: block;
        font-size: $font-size-base;
        font-weight: 600;
        letter-spacing: 1px;

        background-image: linear-gradient(-10deg, darken($base-color, 20), darken($base-color, 25));
        -webkit-background-clip: text;
        background-clip: text;
        text-fill-color: transparent;
        color: transparent;
    }

    &:after {
        position: absolute;
        content: '';
        @include custom-inner-shadow(darken($gray-100, 30), 6px, 0.3);
        z-index: 1;
        width: 100%;
        height: $spacer * 1.618;
    }
}
</style>
