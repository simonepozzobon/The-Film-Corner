<template>
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
                :hasSubLibraries="assets.hasSubLibraries"
                :type="assets.type"
                :items="assets.library"
                :color="color"
                @selected="addTimeline"
            />
        </template>
        <template>
            <ui-app-timeline
                ref="editor"
                :timelines="timelines"
                :playhead-position="playheadPosition"
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
            timelinesCache: [],
            oldTimelines: [],
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
            // this.$nextTick(this.updateEditor);
            if (this.$refs.preview) {
                this.$refs.preview.stop();
            }
        }
    },
    computed: {
        video: function() {
            if (this.assets.video) {
                return "/storage/" + this.assets.video;
            }
        }
    },
    methods: {
        ready: function() {
            this.$nextTick(() => {
                let title = this.$refs.preview.$refs.title.$el;
                let titleH = SizeUtility.get(title);
                let containerH = SizeUtility.get(this.$refs.preview.$el);
                let height = containerH.h - titleH.h + 2;
                this.$refs.library.setLibraryHeight(height);
                if (this.isLoading) {
                    this.$root.objectsLoaded++;
                }
            });
        },
        init: function() {
            let session = this.$root.session;
            if (session && session.app_id === 12) {
                let timelines = session.content.timelines;
                this.notes = session.content.notes;
                if (session.content.video) {
                    this.currentExport = session.content.video;
                }
                if (timelines && timelines.length > 0) {
                    this.session = session;
                    this.isLoading = true;
                    this.$root.isOpen = true;
                    // this.$root.objectsToLoad = 1;
                    this.$root.objectsToLoad = timelines.length > 0 ? 2 : 1;

                    this.$nextTick(() => {
                        this.timelines = timelines;
                    });
                }
            }

            if (!this.isLoading) {
                this.currentExport = this.video;
            }
        },
        addTimeline: function(id, libraryID) {
            let timeline;
            let library = this.assets.library.find(
                library => library.id == libraryID
            );
            if (library) {
                let audio = library.audios.filter(audio => audio.id == id)[0];
                if (audio) {
                    timeline = {
                        id: audio.id,
                        uniqueid:
                            "_" +
                            Math.random()
                                .toString(36)
                                .substr(2, 9),
                        title: audio.title,
                        originalDuration: audio.duration * this.tick,
                        duration: audio.duration * this.tick,
                        start: 0,
                        src: audio.src,
                        img: audio.img,
                        hasCutStart: false,
                        hasCutEnd: false,
                        cutStart: 0,
                        cutEnd: 0
                    };
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
            let obj = this.timelines.find(
                timeline => timeline.uniqueid == uniqueid
            );
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
            // console.log("time from drag", time);
            const position = Math.round(time / this.tick);
            // console.log("new time", position);
            this.$refs.preview.player.currentTime(position);
        },
        onResize: function(obj) {
            this.timelines[obj.idx]["start"] = obj.start;
            this.timelines[obj.idx]["duration"] = obj.duration;
            this.timelines[obj.idx]["cutStart"] = obj.cutStart;
            this.timelines[obj.idx]["cutEnd"] = obj.cutEnd;
            this.timelines = this.timelines.slice();
        },
        onUpdatePlayer: function(time) {
            const position = Math.round(time * this.tick + this.playheadStart);
            // console.log("playhead Position", position);
            this.playheadPosition = position;
        },
        updateEditor: function() {
            const newTimelines = JSON.stringify(this.timelines);
            const oldTimelines = JSON.stringify(this.timelinesCache);

            // Verifico se è necessario un nuovo render
            // console.log(newTimelines == oldTimelines);
            if (newTimelines != oldTimelines) {
                if (this.isFree) {
                    this.isFree = false;
                    if (this.$refs.preview) {
                        this.$refs.preview.showLoader();
                    }
                    // console.log('updating');
                    let data = new FormData();
                    data.append("token", this.session.token);
                    data.append("video", this.video);
                    data.append("timelines", JSON.stringify(this.timelines));
                    this.$http
                        .post("/api/v2/render-audio", data)
                        .then(response => {
                            // se c'è qualcosa nella cache
                            this.isFree = true;
                            this.oldTimelines = this.timelines;
                            if (this.cache) {
                                this.cache = null;
                                this.saveContent();
                                this.updateEditor();
                            } else {
                                this.$refs.preview.hideLoader().then(() => {
                                    this.currentExport = response.data.export;
                                    this.saveContent();

                                    if (this.$refs.preview) {
                                        this.$refs.preview.readyToPlay();
                                    }
                                });
                            }
                        });
                } else {
                    // console.log('cache');
                    this.cache = this.timelines;
                }
            } else {
                if (this.$refs.preview) {
                    this.$refs.preview.readyToPlay();
                }
            }
        },
        setNotes: function(notes) {
            this.notes = notes;
            this.saveContent();
        },
        saveContent: function() {
            let content = this.$root.session.content;

            // salva le timelines in una cache per confrontarle
            this.timelinesCache = Object.assign([], this.timelines);

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
