<template lang="html">
    <app-template :app="app">
        <template slot="left">
            <ui-app-video-preview
                ref="preview"
                :src="currentExport"
                :color="color"
                @on-update-player="onUpdatePlayer"/>
        </template>
        <template slot="right" v-if="this.assets">
            <ui-app-library
                :hasSubLibraries="assets.hasSubLibraries"
                :type="assets.type"
                :items="assets.library"
                :color="color"
                @selected="addTimeline"/>
        </template>
        <template>
            <ui-app-timeline
                :timelines="timelines"
                :playhead-position="playheadPosition"
                :playhead-height="playheadHeight"
                :color="color"
                @delete-track="onDeleteTrack"
                @duplicate-track="onDuplicate"
                @on-drag="onDrag"
                @on-resize="onResize"/>
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
    name: 'ActiveParallelAction',
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
            timelines: [],
            tick: 10,
            isFree: true,
            cache: null,
            currentExport: null,
            playheadHeight: 300,
            playheadStart: 171,
            playheadPosition: 171,
        }
    },
    watch: {
        'timelines': function(timelines) {
            this.$nextTick(this.updateEditor)
        },
        ...SharedWatch,
    },
    computed: {
        video: function() {
            if (this.assets.video) {
                return '/storage/' + this.assets.video
            }
        }
    },
    methods: {
        init: function() {
            this.currentExport = this.video
            console.log();
            // let o = [
            //     [195, 15],
            //     [104, 22],
            //     [103, 22],
            // ]
            // for (var i = 0; i < o.length; i++) {
            //     this.addTimeline(o[i][0], o[i][1])
            // }
        },
        addTimeline: function(id, libraryID) {
            let timeline
            let library = this.assets.library.filter(library => library.id == libraryID)[0]
            if (library) {
                let audio = library.audios.filter(audio => audio.id == id)[0]
                if (audio) {
                    timeline = {
                        id: audio.id,
                        uniqueid: '_' + Math.random().toString(36).substr(2, 9),
                        title: audio.title,
                        originalDuration: audio.duration * this.tick,
                        duration: audio.duration * this.tick,
                        start: 0,
                        src: audio.src,
                        img: audio.img,
                        hasCutStart: false,
                        hasCutEnd: false,
                        cutStart: 0,
                        cutEnd: 0,
                    }
                }
            }

            this.timelines.push(timeline)
        },
        onDeleteTrack: function(uniqueid) {
            this.timelines = this.timelines.filter(timeline => timeline.uniqueid != uniqueid)
        },
        onDuplicate: function(uniqueid) {
            let obj = this.timelines.filter(timeline => timeline.uniqueid == uniqueid)[0]
            if (obj) {
                obj = {
                    ...obj,
                    uniqueid: '_' + Math.random().toString(36).substr(2, 9),
                }
                this.timelines.push(obj)
            }
        },
        onDrag: function(obj) {
            this.timelines[obj.idx]['start'] = obj.start
            this.timelines = this.timelines.slice()
        },
        onResize: function(obj) {
            this.timelines[obj.idx]['start'] = obj.start
            this.timelines[obj.idx]['duration'] = obj.duration
            this.timelines[obj.idx]['cutStart'] = obj.cutStart
            this.timelines[obj.idx]['cutEnd'] = obj.cutEnd
            this.timelines = this.timelines.slice()
        },
        onUpdatePlayer: function(time) {
            this.playheadPosition = Math.round((time * this.tick) + this.playheadStart)
        },
        updateEditor: function() {
            if (this.isFree) {
                this.isFree = false
                this.$refs.preview.showLoader()
                console.log('updating');
                let data = new FormData()
                data.append('token', this.session.token)
                data.append('video', this.video)
                data.append('timelines', JSON.stringify(this.timelines))
                this.$http.post('/api/v2/render-audio', data).then(response => {
                    // se c'è qualcosa nella cache
                    this.isFree = true
                    if (this.cache) {
                        this.cache = null
                        this.updateEditor()
                    } else {
                        this.$refs.preview.hideLoader()
                        // carico l'export solo quando è finita la coda
                        this.$nextTick(() => {
                            this.currentExport = response.data.export
                        })
                        console.log('complete');
                    }
                })
            } else {
                // console.log('cache');
                this.cache = this.timelines
            }
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
