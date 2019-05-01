<template lang="html">
    <app-template :app="app">
        <template slot="left">
            <ui-app-video-preview />
        </template>
        <template slot="right" v-if="this.assets">
            <ui-app-library
                :hasSubLibraries="assets.hasSubLibraries"
                :type="assets.type"
                :items="assets.library"
                @selected="addTimeline"/>
        </template>
        <template>
            <ui-app-timeline
                :timelines="timelines"
                @delete-track="onDeleteTrack"
                @duplicate-track="onDuplicate"
                @on-drag="onDrag"
                @on-resize="onResize"/>
            <ui-app-note
                class="mt-4"
                @changed="setNotes"/>
        </template>
    </app-template>
</template>

<script>
import AppTemplate from './AppTemplate.vue'
import { UiAppFolder, UiAppLibrary, UiAppNote, UiAppTimeline, UiAppVideoPreview } from '../../uiapp'
import { SharedData, SharedMethods } from './Shared'

export default {
    name: 'ParallelAction',
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
        }
    },
    watch: {
        'timelines': function(timelines) {
            this.$nextTick(this.updateEditor)
        }
    },
    methods: {
        init: function() {
            // 204, 19
            let o = [
                [204, 19],
                [178, 18],
                [178, 18],
                [178, 18],
                [179, 18],
                [186, 18],
                [186, 18],
                [186, 18],
            ]
            for (var i = 0; i < o.length; i++) {
                this.addTimeline(o[i][0], o[i][1])
            }
            this.$nextTick(this.deleteEmptySession)
        },
        addTimeline: function(id, libraryID) {
            let timeline
            let library = this.assets.library.filter(library => library.id == libraryID)[0]
            if (library) {
                let video = library.videos.filter(video => video.id == id)[0]
                if (video) {
                    timeline = {
                        id: video.id,
                        uniqueid: '_' + Math.random().toString(36).substr(2, 9),
                        title: video.title,
                        originalDuration: video.duration * this.tick,
                        duration: video.duration * this.tick,
                        start: 0,
                        src: video.src,
                        img: video.img,
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
        updateEditor: function() {
            if (this.isFree) {
                this.isFree = false
                let data = new FormData()
                data.append('timelines', JSON.stringify(this.timelines))
                // this.$http.post('/api/v2/')
                console.log('updating');
            } else {
                this.cache = this.timelines
            }
        },
        setNotes: function(notes) {
            this.notes = notes
        }
    },
    created: function() {
        this.uinqid = SharedMethods.uinqid.bind(this)
        this.getData = SharedMethods.getData.bind(this)
        this.deleteEmptySession = SharedMethods.deleteEmptySession.bind(this)

        this.$root.isApp = true
        this.getData()
    },
    mounted: function() {
    },
    beforeDestroy: function() {
        this.deleteEmptySession()
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
