<template>
<div class="para-single">
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
    padding: $spacer * 2;
    margin-bottom: $spacer * 2.5;
    @include gradient-directional($dark, lighten($dark, 10), 145deg);
    @include border-radius($border-radius * 4);
    @include custom-inner-shadow-lg($black);

    &__table {
        padding: $spacer * 2;
        @include gradient-directional($gray-100, lighten($gray-200, 20), 145deg);
        @include border-radius($border-radius);
        @include custom-box-shadow($black);
    }

    .margin-bt {
        margin-bottom: $spacer * 2.5;
    }

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
