<template>
<div
    class="para-single"
    ref="container"
>
    <div
        class="para-single__content"
        ref="element"
    >
        <panel-title
            :title="paratext.title"
            size="h4"
            class="para-single__sub-title"
            letter-spacing="6px"
        />

        <b-table
            :fields="fields"
            :items="contents"
            hover
            striped
            borderless
        >
            <template v-slot:cell(preview)="data">
                <div v-if="data.item.media_type == 'image'">
                    <img
                        :src="data.item.media"
                        class="para-img"
                        @click.stop.prevent="showPreview(data.item)"
                    >
                </div>
            </template>
            <template v-slot:cell(tools)="data">
                <ui-button
                    color="red"
                    title="Elimina"
                    @click="destroy(data.item)"
                />
            </template>
        </b-table>
        <upload-zone :accept="mime" />
    </div>
    <b-modal
        ref="modal"
        title="Anteprima"
        hide-footer
        hide-header
        size="xl"
        modal-class="preview"
        body-class="preview__body"
        content-class="preview__content"
    >
        <img
            v-if="this.preview"
            :src="this.preview.media"
            class="preview__img"
        >
    </b-modal>
</div>
</template>

<script>
import {
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
    PanelTitle,
    UploadZone,
}
from '../../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../../ui'

import {
    TweenMax,
    TimelineMax,
    Power4,
    Power3,
    Power2,
    Power0,
    CSSPlugin,
    Elastic,
    Back,
    Sine,
}
from 'gsap/all'

const plugins = [
    Power4,
    Power3,
    Power2,
    Power0,
    CSSPlugin,
    Elastic,
    Back,
    Sine,
]

import {
    GSDevTools
}
from 'gsap/GSDevTools'

const debounce = require('lodash.debounce')

export default {
    name: 'Paratext',
    components: {
        Container,
        FileInput,
        ImagePreview,
        SwitchInput,
        TextEditor,
        TextInput,
        UiButton,
        UiTitle,
        Select2Input,
        PanelTitle,
        UploadZone,
    },
    props: {
        paratext: {
            type: Object,
            default: function () {
                return {}
            },
        },
        clipId: {
            type: Number,
            default: 0,
        }
    },
    data: function () {
        return {
            master: null,
            masterPanel: null,
            isOpen: false,
            file: null,
            content: null,
            contents: [],
            files: [],
            fields: [{
                key: 'id',
                label: 'id',
                sortable: true
            }, {
                key: 'media_type',
                label: 'Tipo di file',
                sortable: true,
            }, {
                key: 'preview',
                label: 'Anteprima',
                sortable: false,
            }, {
                key: 'tools',
                label: 'Strumenti',
                sortable: false,
            }],
            preview: null,
        }
    },
    computed: {
        hasMedia: function () {
            if (this.paratext.has_media == 1) {
                return true
            }
            else {
                return false
            }
        },
        mediaType: function () {
            if (this.paratext.type === 'image') {
                return 1
            }
            else if (this.paratext.type === 'audio') {
                return 2
            }
            else if (this.paratext.type === 'video') {
                return 3
            }
            else {
                return 0
            }
        },
        mime: function () {
            if (this.paratext.type === 'image') {
                return 'image/*'
            }
            else if (this.paratext.type === 'audio') {
                return 'audio/*'
            }
            else if (this.paratext.type === 'video') {
                return 'video/mp4'
            }

            return null
        },
        panelBtn: function () {
            if (this.isOpen) {
                return 'Minimizza'
            }
            else {
                return 'Espandi'
            }
        },
        tableShadows: function () {
            return
        },
        uuid: function () {
            return this.$util.uuid()
        },
    },
    methods: {
        initAnim: function () {
            let container = this.$refs.container
            let content = this.$refs.element
            this.master = gsap.timeline({
                paused: true,
                yoyo: true,
            })

            this.master.addLabel('start', 0)
            this.master.addLabel('setInitial', 'start')
            this.master.addLabel('setWidth', 'start+=0.1')
            this.master.addLabel('setHeight', 'start+=0.2')
            this.master.addLabel('revealFrame', 'start+=0.35')

            this.master.fromTo(content, .1, {
                    display: 'none',
                }, {
                    display: 'block'
                }, 'start')
                .to(container, .05, {
                    display: 'flex',
                    opacity: '0',
                    marginBottom: '0rem',
                }, 'start')

                .to(content, .05, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                    opacity: '0',
                    overflow: 'hidden',
                    css: {
                        boxShadow: '1px 1px 1px 0 rgba(59, 66, 72, 0), 1px 1px 1px 0 rgba(59, 66, 72, 0)',
                    },
                }, 'start')

                .fromTo(content, 0.1, {
                    width: '1px',
                    maxWidth: '0%',
                }, {
                    id: 'width',
                    width: '100%',
                    maxWidth: '100%',
                    ease: Sine.easeInOut,
                    yoyoEase: Sine.easeIn,
                    immediateRender: false,
                }, 'setWidth')

                .fromTo(content, .1, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                }, {
                    id: 'height',
                    height: '100%',
                    paddingTop: '0.5rem',
                    paddingBottom: '2rem',
                    immediateRender: false,
                    ease: Sine.easeInOut,
                    yoyoEase: Sine.easeIn,
                }, 'setHeight')

                .fromTo(content, .3, {
                    opacity: '0',
                }, {
                    opacity: '1',
                    ease: Sine.easeInOut,
                    immediateRender: false,
                }, 'start')

                .fromTo(container, .3, {
                    opacity: '0',
                }, {
                    opacity: '1',
                    ease: Sine.easeInOut,
                    immediateRender: false,
                }, 'start')


                .fromTo(container, .1, {
                    marginBottom: '0rem',
                }, {
                    marginBottom: '2.5rem',
                    immediateRender: false,
                }, 'setHeight')

                .fromTo(content, .2, {
                    boxShadow: '2px 4px 12px 0 rgba(59, 66, 72, 0), 4px 8px 24px 0 rgba(59, 66, 72, 0)',
                }, {
                    boxShadow: '2px 4px 12px 0 rgba(59, 66, 72, 0.04), 4px 8px 24px 0 rgba(59, 66, 72, 0.02)',
                    immediateRender: false,
                    ease: Power0.easeNone,
                }, 'revealFrame')

            this.master.progress(1).progress(0)

            this.$nextTick(() => {
                this.debouncedEvent('add-anim', this.master, true, this.uuid, null)
            })

        },
        updateFile: function (file, src) {
            this.file = file
        },
        updateContent: function (json, html) {
            this.content = html
        },
        showPreview: function (item) {
            this.preview = item
            this.$nextTick(() => {
                this.$refs.modal.show()
            })
        },
        upload: function () {
            return new Promise((resolve, reject) => {
                if (this.hasMedia) {
                    let data = new FormData()
                    data.append('clip_id', this.clipId)
                    data.append('paratext_type_id', this.paratext.id)
                    data.append('file', this.file)
                    data.append('content', this.content)

                    this.$http.post('/api/v2/admin/clips/paratexts/upload', data).then(response => {
                        // console.log(response.data);
                        this.contents.push(response.data.paratext)
                        this.setCompleted()
                        resolve(response.data.paratext)
                    })
                }
            });
        },
        destroy: function (item) {
            if (this.hasMedia) {
                let data = new FormData()
                data.append('clip_id', this.clipId)
                data.append('paratext_type_id', this.paratext.id)
                data.append('paratext_id', item.id)

                this.$http.post('/api/v2/admin/clips/paratexts/destroy', data).then(response => {
                    let idx = this.contents.findIndex(content => content.id == response.data.id)
                    if (idx > -1) {
                        this.contents.splice(idx, 1)
                        this.setCompleted()
                    }
                })
            }
        },
        setCompleted: function () {
            if (this.contents.length > 0) {
                this.$emit('completed')
            }
            else {
                this.$emit('uncomplete')
            }
        },
        debug: function () {
            this.upload().then((item) => {
                this.showPreview(item)
            })
        },
        debouncedEvent: debounce(function (name, anim, direction, uuid, callback) {
            this.$ebus.$emit(name, anim, direction, uuid, callback)
        }, 150)
    },
    mounted: function () {
        this.$nextTick(() => {
            this.initAnim()
        })
        // this.$nextTick(() => {
        //     this.debug()
        // })
    },
}
</script>

<style lang="scss">
@import '~styles/shared';
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.para-single {
    &__sub-title {
        // color: darken($gray-100, 50);
        padding-top: $spacer * 1.618 !important;
        padding-bottom: $spacer * 1.618 !important;
        // padding: ($spacer / 1.618) ($spacer * 2) ($spacer / 2) 0;
    }
}
</style>

<style lang="scss" scoped>
@import '~styles/shared';
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.para-single {
    // width: 100%;
    // position: relative;
    margin-bottom: $spacer * 2.5;
    // height: 0;
    // z-index: 3;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    &__content {
        @include gradient-directional($color, lighten($color, 2), -11deg);
        @include border-radius($border-radius * 2);
        // @include custom-box-shadow($darken, 2px, 0.02);

        // width: 100%;
        padding: ($spacer / 2) ($spacer * 2) ($spacer * 2) ($spacer * 2);
    }
}
</style>
