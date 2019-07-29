<template>
<div class="propaganda-back">
    <div class="propaganda-back__container">
        <div class="propaganda-back__content">
            <ui-container class="prop-ex-container">
                <ui-container
                    :contain="true"
                    ref="folder"
                >
                    <ui-row>
                        <ui-block
                            size="auto"
                            direction="row"
                            align="end"
                            justify="end"
                        >

                            <ui-app-challenges-breadcrumbs app="Make your own propaganda film" />

                            <ui-folder-corner
                                color="dark-gray"
                                cross="white"
                                :has-times="false"
                            />

                        </ui-block>
                    </ui-row>
                    <ui-row justify="center">
                        <ui-block
                            size="auto"
                            color="dark-gray"
                            :radius="true"
                            radius-size="md"
                        >
                            <ui-title
                                tag="h2"
                                font-size="h2"
                                :title="content.title"
                                class="pt-5"
                                color="white"
                            />
                            <ui-paragraph
                                color="white"
                                class="pt-5 prop-ex-container__paragraph"
                                align="justify"
                                v-html="description"
                            />
                        </ui-block>
                    </ui-row>
                </ui-container>
                <ui-container
                    class="mt-4"
                    :contain="true"
                >
                    <ui-row :no-gutters="true">
                        <ui-block :size="8">
                            <ui-app-video-preview
                                ref="preview"
                                :src="currentExport"
                                :color="color"
                                @on-update-player="onUpdatePlayer"
                                @ready="ready"
                            />
                        </ui-block>
                        <ui-block
                            :size="4"
                            v-if="libraryLoaded"
                        >
                            <ui-app-library
                                ref="library"
                                :app-id="18"
                                accept="video/*, audio/*"
                                :has-sub-libraries="assets.hasSubLibraries"
                                :type="assets.type"
                                :items="assets.library"
                                color="yellow"
                                @selected="addTimeline"
                                @uploaded="uploaded"
                            />
                        </ui-block>
                    </ui-row>
                    <ui-app-timeline-mixed
                        :timelines="timelines"
                        :playhead-position="playheadPosition"
                        :playhead-height="playheadHeight"
                        :color="color"
                        @delete-track="onDeleteTrack"
                        @duplicate-track="onDuplicate"
                        @on-drag="onDrag"
                        @on-resize="onResize"
                    />

                    <ui-app-note
                        class="mt-4"
                        @changed="setNotes"
                        color="yellow"
                        :initial="this.notes"
                    />
                </ui-container>
            </ui-container>
        </div>
    </div>
</div>
</template>

<script>
import {
    challenges,
    subsPics,
}
from '../../../../dummies/PropagandAppContent'

import AppTemplate from '../../AppTemplate.vue'
import {
    UiAppFolder,
    UiAppLibrary,
    UiAppNote,
    UiAppTimelineMixed,
    UiAppVideoPreview,
    UiAppChallengesBreadcrumbs,
}
from '../../../../uiapp'

import {
    UiBlock,
    UiBreadcrumbs,
    UiButton,
    UiContainer,
    UiFolderCorner,
    UiHeroBanner,
    UiHeroImage,
    UiImageSlider,
    UiLink,
    UiParagraph,
    UiRoadmap,
    UiSpecialText,
    UiTitle,
    UiRow,
}
from '../../../../ui'

import SizeUtility from '../../../../Sizes'
import {
    SharedData,
    SharedMethods,
    SharedWatch
}
from './../../Shared'

export default {
    name: 'ActiveParallelAction',
    components: {
        AppTemplate,
        UiAppFolder,
        UiAppLibrary,
        UiAppChallengesBreadcrumbs,
        UiAppNote,
        UiAppTimelineMixed,
        UiAppVideoPreview,
        UiBlock,
        UiBreadcrumbs,
        UiButton,
        UiContainer,
        UiFolderCorner,
        UiHeroBanner,
        UiHeroImage,
        UiImageSlider,
        UiLink,
        UiParagraph,
        UiRoadmap,
        UiSpecialText,
        UiTitle,
        UiRow,
    },
    data: function () {
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
            isLoading: false,
            title: null,
            description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            content: null,
            open: false,
            libraryLoaded: false,
        }
    },
    watch: {
        'timelines': function (timelines) {
            this.$nextTick(this.updateEditor)
        },
        ...SharedWatch,
    },
    methods: {
        getData: function (token = null) {
            // pulisce la sessione se non è stata salvata
            window.addEventListener('beforeunload', () => {
                try {
                    this.deleteEmptySession()
                }
                catch (e) {

                }
                finally {

                }
            })

            let slug = 'active-parallel-action'
            let url = '/api/v2/load-assets/' + slug

            if (this.$root.session && this.$root.session.token) {
                url = '/api/v2/load-assets/' + slug + '/' + this.$root.session.token
            }

            if (token) {
                url = '/api/v2/load-assets/' + slug + '/' + token
                // console.log(url);
            }

            // console.log('url per il caricamento', url);

            this.$http.get(url).then(response => {
                // console.log('caricata')
                // console.dir(response.data);
                if (response.data.success) {
                    this.app = response.data.app
                    this.assets = response.data.assets
                    let session = response.data.session
                    // console.log(session);
                    session.content = session.content ? JSON.parse(session.content) : {}

                    this.session = session

                    this.$nextTick(() => {
                        this.init()
                        this.libraryLoaded = true
                    })
                }
            })

        },
        ready: function () {
            this.$nextTick(() => {
                let title = this.$refs.preview.$refs.title.$el
                let titleH = SizeUtility.get(title)
                let containerH = SizeUtility.get(this.$refs.preview.$el)
                let height = containerH.hClean - titleH.hClean + 2
                // console.log('ready', containerH.hClean, height);

                if (this.$refs.library) {
                    // console.log('fuori', height);
                    this.$refs.library.setLibraryHeight(height)
                }
                if (this.isLoading) {
                    this.$root.objectsLoaded++
                }
            })
        },
        init: function () {
            let session = this.$root.session
            if (session && session.app_id === 11) {
                let timelines = session.content.timelines
                this.notes = session.content.notes
                if (session.content.video) {
                    this.currentExport = session.content.video
                }
                if (timelines && timelines.length > 0) {
                    this.session = session
                    this.isLoading = true
                    this.$root.isOpen = true
                    this.$root.objectsToLoad = 1
                    for (let i = 0; i < timelines.length; i++) {
                        this.$nextTick(() => {
                            this.timelines.push(timelines[i])
                        })
                    }
                }
            }

            // console.log(this.assets);
        },
        addTimeline: function (id, libraryID) {
            // console.log(id, libraryID);
            let timeline
            let library = this.assets.library.find(library => library.id == libraryID)

            if (library) {
                // console.log('libreria', library);
                let video = library.videos.find(video => video.id == id)
                if (video) {
                    // console.log('video', video);
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
                        type: video.hasOwnProperty('type') ? video.type : 'video',
                        color: video.hasOwnProperty('type') && video.type == 'audio' ? 'green' : 'yellow'
                    }

                    // console.log(timeline);
                }
            }

            this.timelines.push(timeline)
        },
        onDeleteTrack: function (uniqueid) {
            this.timelines = this.timelines.filter(timeline => timeline.uniqueid != uniqueid)
        },
        onDuplicate: function (uniqueid) {
            let obj = this.timelines.filter(timeline => timeline.uniqueid == uniqueid)[0]
            if (obj) {
                obj = {
                    ...obj,
                    uniqueid: '_' + Math.random().toString(36).substr(2, 9),
                }
                this.timelines.push(obj)
            }
        },
        onDrag: function (obj) {
            this.timelines[obj.idx]['start'] = obj.start
            this.timelines = this.timelines.slice()
        },
        onResize: function (obj) {
            this.timelines[obj.idx]['start'] = obj.start
            this.timelines[obj.idx]['duration'] = obj.duration
            this.timelines[obj.idx]['cutStart'] = obj.cutStart
            this.timelines[obj.idx]['cutEnd'] = obj.cutEnd
            this.timelines = this.timelines.slice()
        },
        onUpdatePlayer: function (time) {
            this.playheadPosition = Math.round((time * this.tick) + this.playheadStart)
        },
        updateEditor: function () {
            // console.log('free', this.isFree);
            if (this.isFree) {
                this.isFree = false

                if (this.$refs.preview) {
                    this.$refs.preview.showLoader()
                }
                // console.log('updating');
                let data = new FormData()
                data.append('token', this.session.token)
                data.append('timelines', JSON.stringify(this.timelines))

                this.$http.post('/api/v2/render-mixed', data).then(response => {
                    console.log(response.data);
                    // se c'è qualcosa nella cache
                    this.isFree = true
                    // console.log('cache', this.cache);
                    if (this.cache) {
                        this.cache = null
                        this.saveContent()
                        this.updateEditor()
                    }
                    else {
                        this.$refs.preview.hideLoader()
                        // carico l'export solo quando è finita la coda
                        this.$nextTick(() => {
                            this.currentExport = response.data.export
                            this.saveContent()
                        })
                        // console.log('complete');
                    }
                })
            }
            else {
                // console.log('caching');
                this.cache = this.timelines
            }
        },
        setNotes: function (notes) {
            this.notes = notes
            this.saveContent()
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                video: this.currentExport,
                timelines: this.timelines,
                notes: this.notes
            }

            // console.log(newContent, content);

            for (let key in content) {
                if (content.hasOwnProperty(key) && newContent.hasOwnProperty(key)) {
                    content[key] = newContent[key]
                }
            }

            this.$root.session = {
                ...this.$root.session,
                content: content
            }
        }, 500),
        uploaded: function (asset) {
            // console.log(this.assets, asset);
        },
    },
    created: function () {
        this.$root.isApp = true
        this.content = challenges.find(challenge => challenge.id == 1)
        this.uniqid = SharedMethods.uniqid.bind(this)
        this.deleteEmptySession = SharedMethods.deleteEmptySession.bind(this)

        this.getData()
    },
    mounted: function () {},
    beforeDestroy: function () {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.propaganda-back {
    padding-top: 90px;
    background-image: url("/img/grafica/propaganda/bg-app-80.jpg");
    background-position: top;
    background-size: cover;

    &__container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    &__content {
        padding: $spacer * 2;
    }
}
</style>
