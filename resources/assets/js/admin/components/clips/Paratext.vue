<template>
<div
    class="para-single"
    ref="container"
>
    <div
        class="para-single__table para-table"
        ref="table"
    >
        <div class="para-table__container">
            <ui-title
                tag="h4"
                font-size="h4"
                :has-shadows="true"
                :shadows-type="3"
                class="para-single__sub-title"
                :title="paratext.title"
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
    TweenMax,
    Power4,
    TimelineMax,
    CSSPlugin,
    Elastic,
    Back,
}
from 'gsap/all'

const plugins = [
    Power4,
    CSSPlugin,
    Elastic,
    Back,
]

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

            this.master = new TimelineMax({
                paused: true,
                yoyo: true,
                smoothChildTiming: true,
            })

            this.master.addLabel('start', '+=0')

            this.master.fromTo(parent, duration, {
                height: 0,
                position: 'absolute',
                overflow: 'hidden',
            }, {
                height: 'auto',
                position: 'inherit',
                overflow: 'auto',
                ease: Power4.easeInOut,
                yoyoEase: Power4.easeInOut,
            }, 'start+=0')

            this.master.fromTo(container, duration, {
                height: 0,
                position: 'absolute',
                overflow: 'hidden',
            }, {
                height: 'auto',
                position: 'relative',
                overflow: 'auto',
                ease: Power4.easeInOut,
                yoyoEase: Power4.easeInOut,
                onComplete: () => {
                    TweenMax.set(container, {
                        clearProps: 'overflow'
                    })
                }
            }, 'start+=0.1')

            this.master.progress(1).progress(0).then(() => {})

            this.$nextTick(() => {
                // this.initPanel()
                this.master.play()
            })

        },
        initPanel: function () {
            let uploader = this.$refs.uploader
            let table = this.$refs.table
            let container = this.$refs.container
            let uploadForm = this.$refs.uploadForm

            // let paddingLeft = gsap.getProperty(uploader, 'paddingLeft')
            // let paddingRight = gsap.getProperty(uploader, 'paddingRight')
            // let paddingTop = gsap.getProperty(uploader, 'paddingTop')
            // let paddingBottom = gsap.getProperty(uploader, 'paddingBottom')
            // let height = gsap.getProperty(uploader, 'height')
            // console.log(height);

            this.masterPanel = new TimelineMax({
                paused: true,
            })

            let marginBottom = gsap.getProperty(uploader, 'marginBottom')
            console.log(marginBottom);

            this.masterPanel.fromTo(uploadForm, .1, {
                    display: 'none',
                }, {
                    display: 'block'
                }, 'panelAnim')
                .set(uploader, {
                    opacity: '0',
                    display: 'block',
                    height: '1px',
                    width: '100%',
                    transformOrigin: 'center center',
                    overflow: 'hidden',
                    marginBottom: '0',
                }, 'panelAnim+=0.1')
                .set(uploadForm, {
                    opacity: '0',
                    borderRadius: '50%',
                }, 'panelAnim+=0.1')
                .to(uploader, .65, {
                    opacity: '1',
                    // ease: Power4.easeInOut,
                }, 'panelAnim+=0.11')
                .set(uploader, {
                    height: 'auto',
                    marginBottom: '40px',
                }, 'panelAnim+=0.4')
                .from(uploader, 0.25, {
                    height: '1px',
                    marginBottom: '0',
                    immediateRender: false,
                }, 'panelAnim+=0.4')
                .to(uploadForm, .25, {
                    borderRadius: '0.25rem',
                }, 'panelAnim+=0.7')
                .fromTo(uploadForm, .25, {
                    opacity: 0,
                }, {
                    opacity: 1,
                }, 'panelAnim+=0.8')


            this.masterPanel.eventCallback('onComplete', () => {
                this.isOpen = true
            })

            this.masterPanel.eventCallback('onReverseComplete', () => {
                this.isOpen = false
            })

            this.$nextTick(() => {
                this.togglePanel()
            })
        },
        togglePanel: function () {
            if (this.masterPanel) {
                if (this.isOpen) {
                    this.masterPanel.reverse()
                }
                else {
                    this.masterPanel.play()
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
    // padding: ($spacer * 2) ($spacer * 2) ($spacer * 1.618) ($spacer * 2);
    margin-bottom: $spacer * 2.5;
    // @include gradient-directional($color-darken, lighten($color-darken, 1), -10deg);
    // @include gradient-directional($red, lighten($red, 2), 10deg);
    // @include border-radius($border-radius * 4);
    // @include custom-inner-shadow-lg($darken, 0.2);
    // transition: $transition-base-lg !important;
    height: 0;
    z-index: 3;

    &__title {
        color: darken($gray-100, 50);
        // color: rgba($color, .7);
        // -webkit-text-fill-color: rgba($color, .7);
        // -webkit-text-stroke: 1.618px $darken;
        letter-spacing: 8px;
    }

    &__sub-title {
        color: darken($gray-100, 50);
        padding: ($spacer / 1.618) ($spacer * 2) ($spacer / 2) 0;
        // color: $darken;
        // color: rgba($color, .7);
        // -webkit-text-fill-color: rgba($color, .7);
        // -webkit-text-stroke: 1.33px $darken;
        letter-spacing: 8px;
    }

    &__table {
        height: auto;
        width: 100%;
        // transition: $transition-base-lg !important;
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

.para-table {
    // overflow: hidden;
    // transition: $transition-base-lg !important;

    &__container {
        @include gradient-directional($color, lighten($color, 2), -11deg);
        @include border-radius($border-radius * 2);
        width: 100%;
        // position: relative;
        padding: ($spacer / 2) ($spacer * 2) ($spacer * 2) ($spacer * 2);
        // transition: $transition-base-lg !important;

        // &::after,
        // &::before {
        //     content: '';
        //     position: absolute;
        //     bottom: ($spacer / (1.618)) * 1.1;
        //     top: 80%;
        //     background: $darken;
        //     @include custom-box-shadow($darken, 2px, 0.2);
        //     width: 50%;
        //     z-index: -1;
        // }
        //
        // &::before {
        //     transform-origin: right bottom;
        //     left: 8px;
        //     right: auto;
        //     transform: rotate(-0.5deg);
        // }
        //
        // &::after {
        //     transform-origin: left top;
        //     right: 8px;
        //     left: auto;
        //     transform: rotate(0.5deg);
        // }
    }

    &__container .uploader {
        display: none;
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
