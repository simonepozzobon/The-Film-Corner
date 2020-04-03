<template lang="html">
    <app-template :app="app">
        <template slot="left">
            <ui-app-video-preview
                ref="preview"
                :src="currentExport"
                :color="color"
                :has-rendering="true"
                :has-controls="false"
                @start-render="updateEditor"
                @on-update-player="onUpdatePlayer"
                @ready="ready"
            />
        </template>
        <template slot="right" v-if="this.assets">
            <ui-app-library
                ref="library"
                :app-id="11"
                :has-sub-libraries="assets.hasSubLibraries"
                :type="assets.type"
                :items="assets.library"
                :color="color"
                @selected="addTimeline"
                @uploaded="uploaded"
            />
        </template>
        <template>
            <ui-app-timeline
                :timelines="timelines"
                :playhead-position.sync="playheadPosition"
                :playhead-height="playheadHeight"
                :color="color"
                @on-drag-master="onDragMaster"
                @delete-track="onDeleteTrack"
                @duplicate-track="onDuplicate"
                @on-drag="onDrag"
                @on-resize="onResize"
            />
            <ui-app-note
                class="mt-4"
                :color="color"
                @changed="setNotes"
                :initial="this.notes"
            />
        </template>
    </app-template>
</template>

<script>
import AppTemplate from "./AppTemplate.vue";
import {
    UiAppFolder,
    UiAppLibrary,
    UiAppNote,
    UiAppTimeline,
    UiAppVideoPreview
} from "../../uiapp";
import SizeUtility from "../../Sizes";

import Shared from "./Shared";
const debounce = require("lodash.debounce");

export default {
    name: "ActiveParallelAction",
    mixins: [Shared],
    components: {
        AppTemplate,
        UiAppFolder,
        UiAppLibrary,
        UiAppNote,
        UiAppTimeline,
        UiAppVideoPreview
    },
    data: function() {
        return {
            timelines: [],
            tick: 10,
            isFree: true,
            cache: null,
            currentExport: null,
            playheadHeight: 300,
            playheadStart: 171,
            playheadPosition: 171,
            isLoading: false
        };
    },
    watch: {
        timelines: function(timelines) {
            // vecchio sistema
            // this.$nextTick(this.updateEditor);
            // blocca player prima di modificare
            if (this.$refs.preview) {
                this.$refs.preview.stop();
            }
        }
    },
    methods: {
        ready: function() {
            let title = this.$refs.preview.$refs.title.$el;
            let titleH = SizeUtility.get(title);
            let containerH = SizeUtility.get(this.$refs.preview.$el);
            let height = containerH.hClean - titleH.hClean + 2;
            this.$refs.library.setLibraryHeight(height);
            if (this.isLoading) {
                // console.log('isLoading', this.isLoading, this.$root.objectsLoaded);
                this.$root.objectsLoaded++;
                // console.log('isLoading', this.isLoading, this.$root.objectsLoaded);
            }
        },
        init: function() {
            let session = this.$root.session;
            if (session && session.app_id === 11) {
                let timelines = session.content.timelines;
                this.notes = session.content.notes;
                if (session.content.video) {
                    this.currentExport = session.content.video;
                }
                if (timelines && timelines.length > 0) {
                    this.session = session;
                    this.isLoading = true;
                    this.$root.isOpen = true;
                    this.$root.objectsToLoad = timelines.length > 0 ? 2 : 1;
                    this.$nextTick(() => {
                        this.timelines = timelines;
                    });
                }
            }

            // console.log(this.assets);
        },
        addTimeline: function(id, libraryID) {
            let timeline;
            let library = this.assets.library.filter(
                library => library.id == libraryID
            )[0];
            if (library) {
                let video = library.videos.filter(video => video.id == id)[0];
                if (video) {
                    timeline = {
                        id: video.id,
                        uniqueid:
                            "_" +
                            Math.random()
                                .toString(36)
                                .substr(2, 9),
                        title: video.title,
                        originalDuration: video.duration * this.tick,
                        duration: video.duration * this.tick,
                        start: 0,
                        src: video.src,
                        img: video.img,
                        hasCutStart: false,
                        hasCutEnd: false,
                        cutStart: 0,
                        cutEnd: 0
                    };

                    // console.log(timeline);
                }
            }

            this.timelines.push(timeline);
        },
        onDeleteTrack: function(uniqueid) {
            this.timelines = this.timelines.filter(
                timeline => timeline.uniqueid != uniqueid
            );
        },
        onDuplicate: function(uniqueid) {
            let obj = this.timelines.filter(
                timeline => timeline.uniqueid == uniqueid
            )[0];
            if (obj) {
                obj = {
                    ...obj,
                    uniqueid:
                        "_" +
                        Math.random()
                            .toString(36)
                            .substr(2, 9)
                };
                this.timelines.push(obj);
            }
        },
        onDrag: function(obj) {
            this.timelines[obj.idx]["start"] = obj.start;
            this.timelines = this.timelines.slice();
        },
        onDragMaster: function(time) {
            console.log(time);
            this.$refs.preview.player.currentTime(time);
        },
        onResize: function(obj) {
            this.timelines[obj.idx]["start"] = obj.start;
            this.timelines[obj.idx]["duration"] = obj.duration;
            this.timelines[obj.idx]["cutStart"] = obj.cutStart;
            this.timelines[obj.idx]["cutEnd"] = obj.cutEnd;
            this.timelines = this.timelines.slice();
        },
        onUpdatePlayer: function(time) {
            this.playheadPosition = Math.round(
                time * this.tick + this.playheadStart
            );
        },
        updateEditor: debounce(function() {
            if (this.isFree) {
                this.isFree = false;
                if (this.$refs.preview) {
                    this.$refs.preview.showLoader();
                }
                // console.log('updating');
                let data = new FormData();
                data.append("token", this.session.token);
                data.append("timelines", JSON.stringify(this.timelines));
                this.$http.post("/api/v2/render-video", data).then(response => {
                    // se c'è qualcosa nella cache
                    this.isFree = true;
                    if (this.cache) {
                        this.cache = null;
                        this.saveContent();
                        this.$nextTick(() => this.updateEditor());
                    } else {
                        this.$refs.preview.hideLoader().then(() => {
                            // carico l'export solo quando è finita la coda
                            this.currentExport = response.data.export;
                            this.saveContent();

                            if (this.$refs.preview) {
                                this.$refs.preview.readyToPlay();
                            }
                        });
                        // this.$nextTick(() => {

                        // });
                        // console.log('complete');
                    }
                });
            } else {
                // console.log('cache');
                this.cache = this.timelines;
            }
        }, 150),
        setNotes: function(notes) {
            this.notes = notes;
            this.saveContent();
        },
        saveContent: debounce(function() {
            let content = this.$root.session.content;
            let newContent = {
                video: this.currentExport,
                timelines: this.timelines,
                notes: this.notes
            };

            // console.log(newContent, content);

            for (let key in content) {
                if (
                    content.hasOwnProperty(key) &&
                    newContent.hasOwnProperty(key)
                ) {
                    content[key] = newContent[key];
                }
            }

            this.$root.session = {
                ...this.$root.session,
                content: content
            };
        }, 500),
        uploaded: function(asset) {
            // console.log(this.assets, asset);
        }
    },
    created: function() {
        this.$root.isApp = true;
        this.getData();
    },
    mounted: function() {},
    beforeDestroy: function() {
        this.$root.isApp = false;
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
</style>
