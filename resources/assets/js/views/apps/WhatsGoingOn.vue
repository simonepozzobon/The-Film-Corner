<template>
<app-template :app="app">
    <template slot="left">
        <ui-app-audio-preview
            ref="preview"
            :src="media.audioSrc"
        />
    </template>
    <template
        slot="right"
        v-if="this.assets"
    >
        <ui-app-library
            ref="library"
            :hasSubLibraries="assets.hasSubLibraries"
            :type="assets.type"
            :items="assets.library"
            :color="color"
            @selected="selected"
        />
    </template>
    <template>
        <ui-app-note
            class="mt-4"
            :color="color"
            :initial="this.notes"
            @changed="setNotes"
        />
    </template>
</app-template>
</template>

<script>
import AppTemplate from './AppTemplate.vue'
import {
    UiAppFolder,
    UiAppLibrary,
    UiAppNote,
    UiAppTimeline,
    UiAppAudioPreview
} from '../../uiapp'
import {
    SharedData,
    SharedMethods,
    SharedWatch
} from './Shared'
export default {
    name: 'WhatsGoingOn',
    components: {
        AppTemplate,
        UiAppFolder,
        UiAppLibrary,
        UiAppNote,
        UiAppTimeline,
        UiAppAudioPreview,
    },
    data: function () {
        return {
            ...SharedData,
            media: {
                audioSrc: null
            },
        }
    },
    watch: {
        ...SharedWatch,
    },
    methods: {
        init: function () {
            let idx = Math.round(Math.random() * this.assets.library.length)
            this.media = this.assets.library[idx]
            this.saveContent()
        },
        selected: function (id) {
            let player = this.$refs.preview.player
            player.pause()
            this.media = this.assets.library.filter(asset => asset.id == id)[
                0]
            this.saveContent()
        },
        setNotes: function (notes) {
            this.notes = notes
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                audio: this.media.audioSrc,
                notes: this.notes
            }
            for (let key in content) {
                if (content.hasOwnProperty(key) && newContent.hasOwnProperty(
                        key)) {
                    content[key] = newContent[key]
                }
            }
            this.$root.session = {
                ...this.$root.session,
                content: content
            }
        }, 500)
    },
    created: function () {
        this.uniqid = SharedMethods.uniqid.bind(this)
        this.getData = SharedMethods.getData.bind(this)
        this.debug = SharedMethods.debug.bind(this)
        this.deleteEmptySession = SharedMethods.deleteEmptySession.bind(
            this)
        this.$root.isApp = true
        this.getData()
    },
    mounted: function () {
        this.debug('whats-going-on', "5cffb846bcf86")
    },
    beforeDestroy: function () {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
