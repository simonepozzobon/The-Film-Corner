<template>
<div
    class="para-single"
    ref="container"
>
    <div class="para-single__topbar">
        <ui-title
            class="para-single__title"
            font-size="h4"
            :title="'Gestisci i contenuti di - ' + paratext.title"
            :has-shadows="true"
        />
        <ui-button
            :title="panelBtn"
            theme="outline"
            color="dark"
            :has-margin="false"
            @click="togglePanel"
        />
    </div>
    <div
        ref="uploader"
        class="para-single__table table margin-bt"
    >
        <div class="table__container">
            <ui-title
                tag="h5"
                font-size="h5"
                class="para-single__sub-title"
                title="Carica nuovo contenuto"
                align="center"
                :has-shadows="true"
                :shadows-type="3"
            />
            <file-input
                v-if="mediaType === 1"
                label="Immagine"
                name="image"
                accept="image/*"
                label-size="col-md-1"
                input-size="col-md-11"
                :has-crop="false"
                :has-preview="false"
                @update="updateFile"
            />

            <file-input
                v-if="mediaType === 2"
                label="Audio"
                name="audio"
                accept="audio/mpeg"
                label-size="col-md-1"
                input-size="col-md-11"
                :has-crop="false"
                :has-preview="false"
                @update="updateFile"
            />

            <file-input
                v-if="mediaType === 3"
                label="Video"
                name="video"
                accept="video/mp4"
                label-size="col-md-1"
                input-size="col-md-11"
                :has-crop="false"
                :has-preview="false"
                @update="updateFile"
            />

            <text-editor
                :has-animation="true"
                label-size="col-md-1"
                input-size="col-md-11"
                label="Contenuto"
                @update="updateContent"
            />

            <ui-button
                title="carica"
                color="orange"
                @click="upload"
            />
        </div>
    </div>

    <div
        class="para-single__table table"
        ref="table"
    >
        <div class="table__container">
            <ui-title
                tag="h5"
                font-size="h5"
                :has-shadows="true"
                :shadows-type="3"
                class="para-single__sub-title"
                title="Lista dei contenuti"
                align="center"
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
                            @click.prevent="showPreview(data.item)"
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
        </div>
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
}
from '../../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../../ui'

import {
    gsap,
    TimelineMax,
    Power4,
    CSSPlugin,
    Elastic,
    Back,
}
from 'gsap'

import {
    GSDevTools
}
from 'gsap/GSDevTools'

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
            isOpen: true,
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
        }
    },
    methods: {
        initAnim: function () {
            let container = this.$refs.container
            let parent = this.$parent.$refs.paraContainer
            let duration = 0.4
            let delay = (duration * 1)

            this.master = gsap.timeline({
                paused: true,
                yoyo: true,
                smoothChildTiming: true,
            })

            this.master.addLabel('start', '+=0')

            this.master.fromTo(parent, {
                height: '0',
            }, {
                height: '100%',
                duration: duration,
                ease: 'power4.inOut',
                yoyoEase: 'power4.inOut',
            }, 'start+=0')

            this.master.fromTo(container, {
                height: '0',
            }, {
                height: '100%',
                duration: duration,
                ease: 'power4.inOut',
                yoyoEase: 'power4.inOut',
            }, 'start+=0.1')

            this.master.progress(1).progress(0).then(() => {})

            this.$nextTick(() => {
                this.initPanel()
                this.master.play()
            })

        },
        initPanel: function () {
            let uploader = this.$refs.uploader
            let table = this.$refs.table
            let container = this.$refs.container
            let paddingLeft = gsap.getProperty(uploader, 'paddingLeft')
            let paddingRight = gsap.getProperty(uploader, 'paddingRight')
            let paddingTop = gsap.getProperty(uploader, 'paddingTop')
            let paddingBottom = gsap.getProperty(uploader, 'paddingBottom')

            this.masterPanel = gsap.timeline({
                paused: true,
                yoyo: true,
            })

            this.masterPanel.addLabel('start', '+=0')

            this.masterPanel.fromTo(container, {
                boxShadow: 'inset 0px 0px 0.61805rem rgba(59, 66, 72, 0.2)',
            }, {
                boxShadow: 'inset 0px 0px 0rem rgba(59, 66, 72, 0)',
                duration: .3,
            }, 'start+=0')

            this.masterPanel.fromTo(uploader, {
                autoAlpha: 1,
                height: '100%',
                scaleY: 1,
                yPercent: 0,
                transformOrigin: 'center top',
            }, {
                autoAlpha: 0,
                scaleY: .6,
                height: '0',
                yPercent: -20,
                transformOrigin: 'center top',
                duration: .3,
            }, 'start+=0')

            this.masterPanel.fromTo(uploader, {
                paddingLeft: paddingLeft,
                paddingRight: paddingRight,
                paddingTop: paddingTop,
                paddingBottom: paddingBottom,
            }, {
                paddingLeft: '0',
                paddingRight: '0',
                paddingTop: '0',
                paddingBottom: '0',
                duration: .3,
            }, 'start+=.1')



            this.masterPanel.progress(1).progress(0)

            this.masterPanel.eventCallback('onComplete', () => {
                console.log('cai');
                this.isOpen = false
            })

            this.masterPanel.eventCallback('onReverseComplete', () => {
                console.log('sds');
                this.isOpen = true
            })
        },
        togglePanel: function () {
            if (this.masterPanel) {
                if (this.isOpen) {
                    this.masterPanel.play()
                }
                else {
                    this.masterPanel.reverse()
                }
            }
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
    // background-color: $white;
    // height: 100%;
    width: 100%;
    position: relative;
    padding: ($spacer * 2) ($spacer * 2) ($spacer * 1.618) ($spacer * 2);
    margin-bottom: $spacer * 2.5;
    @include gradient-directional($color-darken, lighten($color-darken, 1), -10deg);
    // @include gradient-directional($red, lighten($red, 2), 10deg);
    @include border-radius($border-radius * 4);
    @include custom-inner-shadow-lg($darken, 0.2);
    transition: $transition-base-lg !important;
    height: 0;
    overflow: hidden;
    z-index: 3;

    &__title {
        color: $dark;
        // color: rgba($color, .7);
        // -webkit-text-fill-color: rgba($color, .7);
        // -webkit-text-stroke: 1.618px $darken;
        letter-spacing: 8px;
    }

    &__sub-title {
        padding: ($spacer / 1.618) ($spacer * 2) ($spacer / 2) 0;
        color: $darken;
        // color: rgba($color, .7);
        // -webkit-text-fill-color: rgba($color, .7);
        // -webkit-text-stroke: 1.33px $darken;
        letter-spacing: 6px;
    }

    &__table {
        height: auto;
        width: 100%;
        transition: $transition-base-lg !important;
    }

    .margin-bt {
        margin-bottom: $spacer * 2.5;
    }

    &__topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: $spacer / 1.618;
    }
}

.table {
    // overflow: hidden;

    &__container {
        @include gradient-directional($color, lighten($color, 2), -11deg);
        @include border-radius($border-radius);
        width: 100%;
        position: relative;
        padding: ($spacer / 2) ($spacer * 2) ($spacer * 2) ($spacer * 2);

        &::after,
        &::before {
            content: '';
            position: absolute;
            bottom: ($spacer / (1.618)) * 1.1;
            top: 80%;
            background: $darken;
            @include custom-box-shadow($darken, 2px, 0.2);
            width: 50%;
            z-index: -1;
        }

        &::before {
            transform-origin: right bottom;
            left: 8px;
            right: auto;
            transform: rotate(-0.5deg);
        }

        &::after {
            transform-origin: left top;
            right: 8px;
            left: auto;
            transform: rotate(0.5deg);
        }
    }

}

.no-height {
    height: 0;
}

.para-img {
    width: $spacer * 4;
    height: auto;
    max-height: $spacer * 4;
    cursor: pointer;
}

.preview {
    &__body {
        background-color: transparent;
        padding: 0;
    }

    &__content {
        background-color: transparent;
    }

    &__img {
        width: 100%;
    }
}
</style>
