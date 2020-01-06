<template>
<app-template :app="app">
    <template>
        <ui-app-block
            :title="$root.getCmd('submission')"
            title-color="white"
            color="dark"
        >
            <div class="form-group">
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    placeholder="Title"
                    v-model="title"
                >
            </div>
            <div class="input-group">
                <div class="custom-file">
                    <input
                        type="file"
                        class="custom-file-input"
                        accept="video/*, image/*"
                        @change="filesChange($event.target.name, $event.target.files)"
                    >

                    <label
                        class="custom-file-label"
                        for="inputGroupFile04"
                    >
                        {{ this.$root.getCmd('select_file') }}
                    </label>
                </div>
            </div>
            <ui-button
                class="mt-4"
                :has-margin="false"
                color="white"
                align="center"
                @click="upload"
            >
                {{ this.$root.getCmd('upload') }}
            </ui-button>
        </ui-app-block>
    </template>
</app-template>
</template>

<script>
import AppTemplate from './AppTemplate.vue'
import {
    UiAppBlock,
    UiAppFolder,
    UiAppLibrary,
    UiAppNote
}
from '../../uiapp'

import {
    UiButton
}
from '../../ui'

import Shared from './Shared'

export default {
    name: 'LumiereMinute',
    mixins: [Shared],
    components: {
        AppTemplate,
        UiAppBlock,
        UiAppFolder,
        UiAppLibrary,
        UiAppNote,
        UiButton,
    },
    data: function () {
        return {
            title: null,
            file: null,
            percent: 0,
        }
    },
    methods: {
        selected: function () {

        },
        setNotes: function (notes) {
            this.notes = notes
        },
        filesChange: function (name, files) {
            this.file = files[0]
            this.error_msg = null
            console.log(files);
        },
        upload: function () {
            let data = new FormData()
            data.append('token', this.session.token)
            data.append('title', this.title)
            data.append('media', this.file)
            data.append('slug', this.app.slug)
            data.append('category_slug', this.app.category.slug)
            data.append('studio_slug', this.app.category.section.slug)
            data.append('_method', 'put')

            let config = {
                headers: {
                    "Content-Type": "multipart/form-data"
                },
                onUploadProgress: function (progressEvent) {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    console.log(progressEvent, percentCompleted);
                }.bind(this)
            }

            this.$http.post('/api/v2/contest-upload', data, config).then(response => {
                console.log(response.data);
                this.saveContent()
            }).catch(err => {
                console.log(err);
            })
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                'video': 'no-video',
            }

            for (let key in content) {
                if (content.hasOwnProperty(key) && newContent.hasOwnProperty(key)) {
                    content[key] = newContent[key]
                }
            }

            this.$root.session = {
                ...this.$root.session,
                content: content
            }
        }, 500),
    },
    created: function () {
        this.$root.isApp = true
        this.getData()
    },
    mounted: function () {},
    beforeDestroy: function () {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
