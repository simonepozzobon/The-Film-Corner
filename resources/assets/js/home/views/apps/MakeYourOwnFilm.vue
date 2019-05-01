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
            app: null,
            assets: null,
            size: { w: 0, h: 0 },
            notes: null,
        }
    },
    methods: {
        getData: function() {
            let slug = this.$route.name
            this.$http.get('/api/v2/load-assets/' + slug).then(response => {
                console.dir(response.data);
                if (response.data.success) {
                    this.app = response.data.app
                    this.assets = response.data.assets
                    this.$nextTick(this.init)
                }
            })
        },
        selected: function() {

        },
        setNotes: function(notes) {
            this.notes = notes
        }
    },
    created: function() {
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
