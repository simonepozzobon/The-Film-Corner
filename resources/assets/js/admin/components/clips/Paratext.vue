<template>
<div class="">
    <ui-title
        tag="h6"
        font-size="h6"
        :title="para.type"
    />
    <hr>

    <div
        v-for="file in this.files"
        :key="file.id"
    >
        {{ file.id }}
    </div>
    <div
        v-for="content in this.contents"
        :key="content.id"
    >
        {{ content.id }}
    </div>

    <file-input
        v-if="hasImage"
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
        v-else
        :has-animation="true"
        label="Contenuto"
        @update="updateContent"
    />
    <ui-button
        title="carica"
        color="orange"
        @click="upload"
    />
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
        para: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            file: null,
            content: null,
            contents: [],
            files: [],
        }
    },
    computed: {
        hasImage: function () {
            if (this.para.has_image == 1) {
                return true
            }
            else {
                return false
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
        upload: function () {
            if (this.hasImage) {
                let data = new FormData()
                data.append('para_id', this.para.id)
                // data.append('file', this.file)

                this.$http.post('/api/v2/admin/clips/paratexts/add-file', data).then(response => {
                    console.log(response.data);
                    this.files.push(response.data.para)
                })
            }
            else {
                let data = new FormData()
                data.append('para_id', this.para.id)
                data.append('content', this.content)

                this.$http.post('/api/v2/admin/clips/paratexts/add-content', data).then(response => {
                    console.log(response.data);
                    this.contents.push(response.data.para)
                })
            }
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
