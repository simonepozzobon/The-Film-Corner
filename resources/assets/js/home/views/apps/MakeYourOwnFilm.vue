<template lang="html">
    <app-template :app="app">
        <template slot="left">

        </template>
        <template slot="right" v-if="this.assets">
            <ui-app-library
                :hasSubLibraries="assets.hasSubLibraries"
                :type="assets.type"
                :items="assets.library"
                @selected="selected"/>
        </template>
        <template>
            Contenuto
            <ui-app-note
                @changed="setNotes"/>
        </template>
    </app-template>
</template>

<script>
import AppTemplate from './AppTemplate.vue'
import { UiAppFolder, UiAppLibrary, UiAppNote } from '../../uiapp'
import { SharedData, SharedMethods } from './Shared'

export default {
    name: 'MakeYourOwnFilm',
    components: {
        AppTemplate,
        UiAppFolder,
        UiAppLibrary,
        UiAppNote,
    },
    data: function() {
        return {
            ...SharedData,
        }
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
