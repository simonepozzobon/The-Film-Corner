<template>
<div
    class="para-single"
    ref="container"
>
    <ui-title
        font-size="h2"
        :title="'Gestisci i contenuti di - ' + paratext.title"
        color="white"
    />
    <div class="para-single__table margin-bt">
        <ui-title
            tag="h6"
            font-size="h6"
            title="Carica nuovo contenuto"
        />
        <hr>

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

    <div class="para-single__table">
        <ui-title
            tag="h6"
            font-size="h6"
            title="Lista dei contenuti"
        />
        <hr>

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
}
from 'gsap'

import {
    GSDevTools
}
from 'gsap/GSDevTools'

console.log(Elastic);

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
    },
    methods: {
        blendEases: function (startEase, endEase, blender) {
            let parse = function (ease) {
                    return typeof (ease) === "function" ? ease : gsap.parseEase("power4.inOut");
                },
                s = gsap.parseEase(startEase),
                e = gsap.parseEase(endEase)

            blender = parse(blender);
            return function (v) {
                var b = blender(v);
                return s(v) * (1 - b) + e(v) * b;
            }
        },
        initAnim: function () {
            let container = this.$refs.container
            let parent = this.$parent.$refs.paraContainer
            let duration = 0.4
            let delay = (duration * 1)
            console.log(delay);

            let master = gsap.timeline({
                paused: true,
                yoyo: true,
                smoothChildTiming: true,
            })

            master.set(container, {
                transformOrigin: 'center top',
                top: 0,
                yPercent: -100,
                width: '100%',
                position: 'absolute',
            }, 0)

            master.set(parent, {
                overflow: 'hidden',
                transformOrigin: 'center top',
                position: 'relative',
                width: '100%'
            }, 0)

            master.addLabel('start', '+=0')

            master.from(parent, {
                immediateRender: true,
                duration: duration,
                height: 0,
                ease: 'power4.inOut',
            }, 'start')

            master.fromTo(parent, {
                // opacity: 0,
                yPercent: -25,
            }, {
                duration: duration,
                // opacity: 1,
                yPercent: 0,
                ease: 'power4.inOut',
                onStart: () => {
                    console.log('start parent');
                },
                onComplete: () => {
                    console.log('completo parent');
                }
            }, 'start')

            master.addLabel('sec', '-=0.3')

            master.fromTo(container, {
                yPercent: -20,
                scaleY: 0.9,
            }, {
                duration: duration / 3,
                yPercent: 0,
                scaleY: 1,
                ease: 'power4.inOut',
            }, 'sec')

            master.fromTo(container, {
                opacity: 0,
            }, {
                duration: duration / 4,
                opacity: 1,
                ease: 'power4.inOut',
            }, 'sec')

            master.add(
                gsap.fromTo(container, {
                    className: '+=no-height'
                }, {
                    duration: duration,
                    className: '-=no-height',
                    onStart: () => {
                        console.log('iisdsidsi');
                    },
                    onComplete: () => {
                        console.log('finitooooo');
                    }
                }),
                'sec'
            )


            // master.from(container, {
            //     immediateRender: true,
            //     duration: duration,
            //     // height: 0,
            //     physics2D: {
            //         velocity: 2,
            //         friction: 0.5
            //     },
            //     ease: this.blendEases('Power4.easeInOut', 'sine', 'back'),
            //     onStart: () => {
            //         console.log('start container');
            //     },
            //     onComplete: () => {
            //         console.log('completo container');
            //     }
            // }, delay)

            this.$nextTick(() => {
                GSDevTools.create({
                    animation: master,
                    paused: true,
                })

                master.eventCallback('onComplete', () => {
                    console.log('complete');
                })
                master.eventCallback('onStart', () => {
                    console.log('start');
                    console.log(master.labels);
                })
            })

        },
        // showPanel: function () {
        //     if (this.master) {
        //         let container =
        //             this.master.eventCallback('onComplete', () => {
        //                 TweenMax.set(this.$refs.container, {
        //                     clearProps: 'all',
        //                     onComplete: () => {
        //                         this.master.kill()
        //                     }
        //                 })
        //             })
        //         this.master.play()
        //     }
        //     else {
        //         this.initAnim()
        //     }
        // },
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
                    }
                })
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

.para-single {
    // background-color: $white;
    height: 100%;
    padding: $spacer * 2;
    margin-bottom: $spacer * 2.5;
    @include gradient-directional($dark, lighten($dark, 10), 145deg);
    @include border-radius($border-radius * 4);
    @include custom-inner-shadow-lg($black);
    transition: $transition-base-lg !important;

    &__table {
        padding: $spacer * 2;
        @include gradient-directional($gray-100, lighten($gray-200, 20), 145deg);
        @include border-radius($border-radius);
        @include custom-box-shadow($black);
        transition: $transition-base-lg !important;
    }

    .margin-bt {
        margin-bottom: $spacer * 2.5;
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
