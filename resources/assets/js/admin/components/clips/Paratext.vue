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
        <upload-zone
            :accept="mime"
            url="/api/v2/admin/clips/paratexts/upload"
            :params.sync="requestParams"
            @success="addParatext"
        />
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
    DebouncedAnimation,
    ParatextAnimation,
}
from './mixins'

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
    mixins: [
        ParatextAnimation,
        DebouncedAnimation,
    ],
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
            paratexts: [],
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
        requestParams: function () {
            return {
                clip_id: this.clipId,
                paratext_type_id: this.paratext.id,
                content: this.content,
            }
        },
    },
    methods: {
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
        addParatext: function (response) {
            this.contents.push(response.paratext)
            this.setCompleted()
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
            // this.upload().then((item) => {
            //     this.showPreview(item)
            // })
        },
    },
    mounted: function () {
        this.$nextTick(() => {
            this.initAnim()
        })
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
        padding-top: $spacer * 1.618 !important;
        padding-bottom: $spacer * 1.618 !important;
    }
}

.para-img {
    width: $spacer * 4;
    max-width: 100%;
}
</style>

<style lang="scss" scoped>
@import '~styles/shared';
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.para-single {
    margin-bottom: $spacer * 2.5;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    &__content {
        @include gradient-directional($color, lighten($color, 2), -11deg);
        @include border-radius($border-radius * 2);
        // @include custom-box-shadow($darken, 2px, 0.02);

        padding: ($spacer / 2) ($spacer * 2) ($spacer * 2) ($spacer * 2);
    }
}
</style>
