<template lang="html">
    <app-template :app="app" :left="6" :right="6">
        <template slot="left">

        </template>
        <template slot="right">

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
    name: 'TypesOfImages',
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
