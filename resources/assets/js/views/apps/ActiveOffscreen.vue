<template>
    <app-template :app="app">
        <template slot="left">
            <ui-app-video-preview
                ref="preview"
                :src="media.videoSrc"/>
        </template>
        <template slot="right" v-if="this.assets">
            <ui-app-library
                :hasSubLibraries="assets.hasSubLibraries"
                :type="assets.type"
                :items="assets.library"
                :color="color"
                @selected="selected"/>
        </template>
        <template>
            <ui-app-note
                class="mt-4"
                :color="color"
                @changed="setNotes"/>
        </template>
    </app-template>
</template>

<script>
import AppTemplate from './AppTemplate.vue'
import { UiAppFolder, UiAppLibrary, UiAppNote, UiAppTimeline, UiAppVideoPreview } from '../../uiapp'
import { SharedData, SharedMethods, SharedWatch } from './Shared'

export default {
    name: 'ActiveOffscreen',
    components: {
        AppTemplate,
        UiAppFolder,
        UiAppLibrary,
        UiAppNote,
        UiAppTimeline,
        UiAppVideoPreview,
    },
    data: function() {
        return {
            ...SharedData,
            media: {
                videoSrc: '/video/empty-session.mp4'
            },
        }
    },
    watch: {
        ...SharedWatch,
    },
    methods: {
        init: function() {
            let idx = Math.round(Math.random() * this.assets.library.length)
            this.media = this.assets.library[idx]
            // console.log();
        },
        selected: function(id) {
            let player = this.$refs.preview.player
            player.pause()
            this.media = this.assets.library.filter(asset => asset.id == id)[0]
        },
        setNotes: function(notes) {
            this.notes = notes
        },
        saveContent: _.debounce(function() {
            let content = this.$root.session.content
            let newContent = {
                'main_video': this.media.videoSrc,
                'videos': [],
                notes: 'no notes'
            }

            console.log(newContent);

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
    created: function() {
        this.uniqid = SharedMethods.uniqid.bind(this)
        this.getData = SharedMethods.getData.bind(this)
        this.deleteEmptySession = SharedMethods.deleteEmptySession.bind(this)

        this.$root.isApp = true
        this.getData()
    },
    mounted: function() {
    },
    beforeDestroy: function() {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
