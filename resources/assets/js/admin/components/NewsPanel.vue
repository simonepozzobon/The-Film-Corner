<template>
<container
    ref="container"
    class="admin-panel"
>
    <div class="form">
        <image-preview
            ref="image"
            label="Immagine di copertina"
            :src="imagePreview"
            @edit="showCropper"
        />
        <text-input
            label="Titolo"
            name="title"
            placeholder="Inserisci un titolo..."
            :value.sync="form.title"
        />
        <text-input
            label="Slug"
            name="slug"
            placeholder="La parte finale dell'url..."
            :value.sync="form.slug"
        />
        <div class="admin-panel__dynamic">
            <file-input
                ref="cropper"
                label="Immagine di copertina"
                name="image"
                accept="image/*"
                @update="cropped"
            />
        </div>
        <text-editor
            ref="editor"
            label="Contenuto"
            @update="updateContent"
        />
        <div class="admin-panel__actions">
            <ui-button
                class="action-button"
                :has-container="false"
                :has-margin="false"
                color="lightest-gray"
                title="Salva"
                @click="save"
            />
            <ui-button
                class="action-button"
                :has-container="false"
                :has-margin="false"
                color="warning"
                title="Annulla"
                @click="undo"
            />
        </div>
    </div>
</container>
</template>

<script>
import {
    Container,
    FileInput,
    ImagePreview,
    TextEditor,
    TextInput,
}
from '../adminui'

import {
    UiButton,
}
from '../../ui'

import Utility from '../../Utilities'
import mime from 'mime-types'

require('gsap/CSSPlugin')

import Dummy from './Dummy'

export default {
    name: 'NewsPanel',
    components: {
        Container,
        FileInput,
        ImagePreview,
        TextEditor,
        TextInput,
        UiButton,
    },
    data: function () {
        return {
            form: {
                title: null,
                slug: null,
                content: null,
            },
            imagePreview: null,
            cropperAnim: null,
            json: null,
        }
    },
    methods: {
        initCropperAnim: function () {
            let input = this.$refs.cropper.$el
            let image = this.$refs.image.$el

            this.cropperAnim = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.cropperAnim.fromTo(input, .6, {
                autoAlpha: 1,
                height: '100%'
            }, {
                autoAlpha: 0,
                height: 0,
            }, 0)

            this.cropperAnim.fromTo(image, .6, {
                autoAlpha: 0,
                height: '0',
            }, {
                autoAlpha: 1,
                height: '100%',
            }, 0)

            this.cropperAnim.progress(1).progress(0)
        },
        cropped: function (file, src) {
            this.form.file = file
            this.imagePreview = src

            this.$nextTick(() => {
                this.hideCropper()
            })
        },
        hideCropper: function () {
            if (this.cropperAnim) {
                this.cropperAnim.play()
            }
        },
        showCropper: function () {
            if (this.cropperAnim) {
                this.cropperAnim.reverse()
            }
        },
        updateContent: function (json, html) {
            this.form.content = html
            this.json = json
        },
        checkForImages: async function (Obj) {
            let buf
            if (Obj instanceof Array) {
                buf = [] // create an empty array
                let i = Obj.length
                while (i--) {
                    buf[i] = await this.checkForImages(Obj[i]) // recursively clone the elements
                }
                return buf
            }
            else if (Obj instanceof Object) {
                buf = {} // create an empty object
                for (let k in Obj) {
                    if (k == 'type' && Obj[k] == 'image') {
                        let id = Utility.uuid()
                        Obj = await this.saveImage(Obj, id)
                    }
                    buf[k] = await this.checkForImages(Obj[k]) // recursively clone the value
                }
                return buf
            }
            else {
                return Obj
            }
        },
        saveImage: async function (obj, id = null) {
            let ext, filename, file
            let attrs = obj.attrs
            let dataUri = attrs.src

            let blob = Utility.createBlobFromData(dataUri)
            ext = mime.extension(blob.type)
            filename = Utility.uuid() + '.' + ext
            file = new File([blob], filename)

            // formo la richiesta
            let data = new FormData()
            data.append('file', file)
            const request = await this.waitUpload(data, id)

            // Formo il nuovo oggetto
            const newObj = Object.assign({}, obj)
            // console.log(newObj);
            newObj.attrs.src = request.data.image

            return newObj
        },
        waitUpload: async function (fileData, id) {
            const request = await this.$http.post('/api/v2/admin/news/upload-image', fileData).then(response => {
                return response
            })
            return request
        },
        debug: async function () {
            let content = Dummy
            let test = await this.checkForImages(content)
            // console.log(content);
        },
        save: async function () {
            let comp = this.$refs.editor
            let editor = comp.editor

            if (this.json) {
                let formattedJson = await this.checkForImages(this.json)
                editor.setContent(formattedJson)
            }

            this.$nextTick(() => {
                let data = new FormData()

                for (let key in this.form) {
                    if (this.form.hasOwnProperty(key)) {
                        if (key === 'content') {
                            let html = editor.getHTML()
                            data.append(key, html)
                        }
                        else {
                            data.append(key, this.form[key])
                        }
                    }
                }

                this.$http.post('/api/v2/admin/news/save', data).then(response => {
                    console.log(response.data);
                })
            })

        },
        undo: function () {

        },
    },
    mounted: function () {
        this.initCropperAnim()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-panel {
    &__dynamic {
        position: relative;
        height: auto;
        overflow: hidden;
    }

    &__actions {
        display: flex;
        justify-content: center;

        .action-button {
            margin-left: $spacer / 2;
            margin-right: $spacer / 2;
        }
    }
}
</style>
