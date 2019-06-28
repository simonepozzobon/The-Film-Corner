<template>
<div class="upload-form">
    <file-input
        name="upload"
        :accept="accept"
        @update="updateFile"
    />
    <ui-button
        :has-container="false"
        title="Upload"
        color="dark"
        @click="uploadFile"
    />
</div>
</template>

<script>
import FileInput from './FileInput.vue'
import {
    UiButton,
}
from '../../../ui'

export default {
    name: 'UploadForm',
    components: {
        FileInput,
        UiButton,
    },
    props: {
        accept: {
            type: String,
            default: 'video/*',
        },
        appId: {
            type: Number,
            default: 0,
        },
    },
    data: function () {
        return {
            file: null,
        }
    },
    methods: {
        updateFile: function (file) {
            this.file = file
        },
        uploadFile: function () {
            console.log('cliccato');
            let data = new FormData()
            data.append('file', this.file)
            data.append('app_id', this.appId)

            this.$http.post('/api/v2/asset-upload', data).then(response => {
                this.$emit('uploaded', response.data)
            })
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
