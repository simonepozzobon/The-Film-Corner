<template>
<app-template :app="app">
    <template slot="left">
        <ui-app-video-preview
            ref="preview"
            :src="media.videoSrc"
            @ready="ready"
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
            @changed="setNotes"
            :initial="notes"
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
    UiAppVideoPreview
} from '../../uiapp'
import {
    SharedData,
    SharedMethods,
    SharedWatch
} from './Shared'
import SizeUtility from '../../Sizes'
export default {
    name: 'Offscreen',
    components: {
        AppTemplate,
        UiAppFolder,
        UiAppLibrary,
        UiAppNote,
        UiAppTimeline,
        UiAppVideoPreview,
    },
    data: function () {
        return {
            ...SharedData,
            media: {
                videoSrc: '/video/empty-session.mp4'
            },
            isLoading: false
        }
    },
    watch: {
        ...SharedWatch,
    },
    methods: {
        ready: function () {
            let title = this.$refs.preview.$refs.title.$el
            let titleH = SizeUtility.get(title)
            let containerH = SizeUtility.get(this.$refs.preview.$el)
            let height = containerH.hClean - titleH.hClean + 2
            if (this.$refs.hasOwnProperty('library') && this.$refs.library) {
                this.$refs.library.setLibraryHeight(height)
            }
            if (this.isLoading) {
                this.$root.objectsLoaded++
            }
        },
        init: function () {
            let session = this.$root.session
            if (session && session.content && session.app_id === 5) {
                let content = session.content
                this.notes = content.notes
                if (content && content.video) {
                    this.isLoading = true
                    this.$root.isOpen = true
                    this.$root.objectsToLoad = 1
                    this.media = {
                        videoSrc: content.video
                    }
                }
            }
            if (!this.isLoading) {
                let idx = Math.round(Math.random() * this.assets.library.length)
                this.media = this.assets.library[idx]
            }
            // console.log('media', this.media);
            // console.log();
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
            this.saveContent()
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                video: this.media.videoSrc,
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
        // this.debug = SharedMethods.debug.bind(this)
        this.deleteEmptySession = SharedMethods.deleteEmptySession.bind(
            this)
        this.$root.isApp = true
        this.getData()
    },
    mounted: function () {
        // this.$nextTick(() => {
        //     this.debug('offscreen', '5cffb3eb973e2')
        // })
    },
    beforeDestroy: function () {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
