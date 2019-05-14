<template lang="html">
    <app-template :app="app">
        <template slot="left">
            <ui-app-audio-preview
                ref="preview"
                :src="media.audioSrc"/>
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
import { UiAppFolder, UiAppLibrary, UiAppNote, UiAppTimeline, UiAppAudioPreview } from '../../uiapp'
import { SharedData, SharedMethods, SharedWatch } from './Shared'

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
    data: function() {
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
        init: function() {
            let idx = Math.round(Math.random() * this.assets.library.length)
            this.media = this.assets.library[idx]
            console.log('fsdgfsgfdg',this.media);
        },
        selected: function(id) {
            let player = this.$refs.preview.player
            player.pause()
            this.media = this.assets.library.filter(asset => asset.id == id)[0]
        },
        setNotes: function(notes) {
            this.notes = notes
        }
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
