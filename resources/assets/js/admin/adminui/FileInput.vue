<template>
<div class="file-input">
    <div class="form-group row">
        <label :class="labelSize">{{ label }}</label>
        <div :class="inputSize">
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input
                        ref="file"
                        type="file"
                        class="custom-file-input"
                        :id="name"
                        :accept="accept"
                        @change="previewFile"
                    />

                    <label
                        class="custom-file-label"
                        :for="name"
                        aria-describedby="inputGroupFileAddon02"
                    >
                        {{ placeholder }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div
        class="crop form-group row"
        v-if="this.hasCrop && this.accept === 'image/*' && this.showCrop"
    >
        <label :class="labelSize">
            Taglia l'immagine
        </label>
        <div :class="inputSize">
            <div class="row">
                <div class="col-md-6">
                    <clipper-fixed
                        ref="cropper"
                        :ratio="ratio"
                        :preview="name"
                        :src="src"
                    />
                </div>
                <div class="col-md-6">
                    <clipper-preview
                        :name="name"
                        ref="preview"
                    />
                </div>
            </div>
            <ui-button
                title="Ritaglia"
                class="mt-3"
                size="sm"
                color="primary"
                @click="crop"
            />
        </div>
    </div>
</div>
</template>

<script>
import {
    clipperFixed,
    clipperPreview
}
from 'vuejs-clipper'

import {
    UiButton,
}
from '../../ui'

export default {
    name: 'FileInput',
    components: {
        clipperFixed,
        UiButton,
    },
    props: {
        label: {
            type: String,
            default: 'label',
        },
        labelSize: {
            type: String,
            default: 'col-md-2',
        },
        inputSize: {
            type: String,
            default: 'col-md-10',
        },
        name: {
            type: String,
            default: 'fileinput',
        },
        accept: {
            type: String,
            default: null,
        },
        ratio: {
            type: Number,
            default: 16 / 9
        },
        hasCrop: {
            type: Boolean,
            default: true,
        },
        hasPreview: {
            type: Boolean,
            default: true,
        },
    },
    data: function () {
        return {
            showCrop: false,
            file: null,
            src: null,
        }
    },
    watch: {
        src: function () {
            this.toggleCrop()
        },
    },
    computed: {
        placeholder: function () {
            if (this.file) {
                return this.file.name
            }
            else {
                return 'Seleziona File'
            }
        },
    },
    methods: {
        toggleCrop: function () {
            if (this.src) {
                this.showCrop = true
            }
            else {
                this.showCrop = false
            }
        },
        previewFile: function () {
            this.file = this.$refs.file.files[0]
            if (this.file) {
                let reader = new FileReader()
                // console.log('preview');
                reader.addEventListener('load', () => {
                    if (this.hasPreview) {
                        if (this.hasCrop) {
                            this.src = reader.result
                            // console.log(this.src);
                        }
                        else {
                            let src = reader.result
                            let file = this.file
                            this.$emit('update', file, src)
                        }
                    }
                    else {
                        let src = reader.result
                        let file = this.file
                        this.$emit('update', file, src)
                    }

                })
                reader.readAsDataURL(this.file)
            }
        },
        crop: function () {
            // https://developer.mozilla.org/it/docs/Web/API/HTMLCanvasElement/toBlob

            let canvas = this.$refs.cropper.clip()
            canvas.toBlob(blob => {
                // blob.lastModifiedDate = new Date()
                let file = new File([blob], this.file.name)

                this.getSrc(file).then(src => {
                    this.$emit('update', file, src)
                })
            })
        },
        getSrc: function (file) {
            return new Promise(resolve => {
                let reader = new FileReader()
                // console.log('preview');
                let src = reader.addEventListener('load', event => {
                    resolve(reader.result)
                })
                reader.readAsDataURL(file)
            })
        },
        reset: function () {
            this.$refs.file.value = ''
            this.file = null
            this.src = null
            if (this.hasCrop) {
                this.toggleCrop()
            }
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
