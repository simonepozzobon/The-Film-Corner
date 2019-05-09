<template lang="html">
    <app-template :app="app">
        <template slot="left">
            <ui-app-image title="Your Scene">

            </ui-app-image>
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
import { UiAppFolder, UiAppImage, UiAppLibrary, UiAppNote } from '../../uiapp'
import { SharedData, SharedMethods, SharedWatch } from './Shared'

export default {
    name: 'Soundscapes',
    components: {
        AppTemplate,
        UiAppFolder,
        UiAppImage,
        UiAppLibrary,
        UiAppNote,
    },
    data: function() {
        return {
            ...SharedData,
        }
    },
    watch: {
        ...SharedWatch,
    },
    methods: {
        selected: function() {

        },
        setNotes: function(notes) {
            this.notes = notes
        }
    },
    created: function() {
        this.getData = SharedMethods.getData.bind(this)
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
