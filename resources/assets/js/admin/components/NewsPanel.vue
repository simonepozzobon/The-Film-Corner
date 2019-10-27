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
        <div class="admin-panel__dynamic">
            <file-input
                ref="cropper"
                label="Immagine di copertina"
                name="image"
                accept="image/*"
                @update="cropped"
            />
        </div>
        <text-input
            label="Titolo"
            name="title"
            placeholder="Inserisci un titolo..."
            :initial="this.form.title"
            @update="value => { this.form.title = value}"
        />
        <text-input
            label="Slug"
            name="slug"
            placeholder="La parte finale dell'url..."
            :initial="this.form.slug"
            @update="value => { this.form.slug = value}"
        />
        <text-editor
            ref="editor"
            label="Contenuto"
            @update="updateContent"
        />
        <text-input
            label="Testo del link in home"
            name="read_text"
            placeholder="Read more"
            :initial="this.form.read_text"
            @update="value => { this.form.read_text = value}"
        />
        <switch-input
            label="Pubblicata"
            :initial="Boolean(form.active)"
            @update="value => { this.form.active = value}"
        />
        <div class="admin-panel__actions">
            <ui-button
                class="action-button"
                :has-container="false"
                :has-margin="false"
                :has-spinner="isSaving"
                :update-spinner-size="true"
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
    SwitchInput,
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

import {
    TweenMax,
    Power4,
    RoundPropsPlugin,
    CSSPlugin,
}
from 'gsap/all'

const plugins = [
    Power4,
    RoundPropsPlugin,
    CSSPlugin,
]

import Dummy from './Dummy'

export default {
    name: 'NewsPanel',
    components: {
        Container,
        FileInput,
        ImagePreview,
        SwitchInput,
        TextEditor,
        TextInput,
        UiButton,
    },
    props: {
        initial: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            form: {
                title: null,
                slug: null,
                content: null,
                read_text: null,
                active: true,
            },
            imagePreview: null,
            cropperAnim: null,
            json: null,
            master: null,
            hasCropper: false,
            isSaving: false,
        }
    },
    watch: {
        initial: {
            handler: function (obj) {
                if (obj && Object.keys(obj).length != 0 && obj.constructor === Object) {
                    this.form = obj

                    if (obj.content && obj.content != '') {
                        this.$refs.editor.editor.setContent(obj.content)
                    }
                    else {
                        this.$refs.editor.editor.clearContent(false)
                    }

                    if (obj.img && obj.img != '') {
                        this.imagePreview = obj.img
                        this.hideCropper()
                    }
                    else {
                        this.imagePreview = null
                        this.showCropper()
                    }

                    if (this.form.hasOwnProperty('active')) {

                    }
                }
                else {
                    this.$refs.editor.editor.clearContent(false)
                    this.imagePreview = null
                    this.showCropper()

                    this.form = {
                        title: null,
                        slug: null,
                        content: null,
                        read_text: null,
                        active: true,
                    }
                }


            },
            deep: true
        },
    },
    methods: {
        initAnim: function () {
            let container = this.$refs.container.$el

            this.master = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.master.addLabel('start', '+=0')
            this.master.addLabel('opacity', '+=0.3')

            this.master.fromTo(container, .6, {
                height: 0,
                roundProps: 'height',
            }, {
                height: '100%',
                roundProps: 'height',
                ease: Power4.easeInOut,
            }, 'start')

            this.master.fromTo(container, .3, {
                autoAlpha: 1,
            }, {
                autoAlpha: 1,
                ease: Power4.easeInOut,
            }, 'opacity')

            this.master.progress(1).progress(0)
        },
        show: function () {
            if (this.master) {
                this.master.play()
                this.isOpen = true
            }
        },
        hide: function () {
            if (this.master) {
                this.master.reverse()
                this.isOpen = false
            }
        },
        initCropperAnim: function () {
            let input = this.$refs.cropper.$el
            let image = this.$refs.image.$el

            this.cropperAnim = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.cropperAnim.fromTo(input, .6, {
                autoAlpha: 1,
                height: '100%',
                // roundProps: 'height',
            }, {
                autoAlpha: 0,
                height: 0,
                // roundProps: 'height',
            }, 0)

            this.cropperAnim.fromTo(image, .6, {
                autoAlpha: 0,
                height: '0',
                // roundProps: 'height',
            }, {
                autoAlpha: 1,
                height: '100%',
                // roundProps: 'height',
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
        },
        save: async function () {
            this.isSaving = true

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
                    this.isSaving = false
                    this.$emit('saved', response.data.news)
                }).catch(err => {
                    this.isSaving = false
                })
            })

        },
        undo: function () {
            this.$emit('undo')
        },
    },
    created: function () {
        if (this.initial) {
            this.form = this.initial
        }
    },
    mounted: function () {
        this.$nextTick(() => {
            this.initAnim()
            this.initCropperAnim()
        })
    },
    beforeDestroy: function () {
        if (this.master) {
            this.master.kill()
        }

        if (this.cropperAnim) {
            this.cropperAnim.kill()
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-panel {
    overflow: hidden;

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
