<template>
<app-template :app="app">
    <template slot="left">
        <ui-app-giroscope
            ref="preview"
            title="Character"
            :color="color"
        />
    </template>
    <template
        slot="right"
        v-if="this.assets"
    >
        <ui-app-library
            ref="library"
            :hasSubLibraries="assets.hasSubLibraries"
            :type="assets.type"
            :items="vrImages"
            @selected="selected"
        />
    </template>
    <template>
        <ui-app-crop-controls
            :clear-all="clearAll"
            @crop-frame="cropFrame"
            @delete-all="deleteAll"
        />

        <ui-app-cropped-frames
            :frames="this.frames"
            @delete-frame="deleteFrame"
            @changed="updateFrame"
            @loaded="loaded"
        />
    </template>
</app-template>
</template>

<script>
import AppTemplate from './AppTemplate.vue'
import pannellum from 'pannellum'
import SizeUtility from '../../Sizes'
import {
    UiAppBlock,
    UiAppCropControls,
    UiAppCroppedFrames,
    UiAppFolder,
    UiAppGiroscope,
    UiAppLibrary,
    UiAppNote
}
from '../../uiapp'
import {
    UiButton
}
from '../../ui'

import Shared from './Shared'

export default {
    name: 'FrameCrop',
    mixins: [Shared],
    components: {
        AppTemplate,
        UiAppBlock,
        UiAppCropControls,
        UiAppCroppedFrames,
        UiAppFolder,
        UiAppGiroscope,
        UiAppLibrary,
        UiAppNote,
        UiButton,
    },
    data: function () {
        return {
            viewer: null,
            renderer: null,
            frames: [],
            currentSrc: '/img/test-app/360.jpg',
            clearAll: false,
            isLoading: false,
        }
    },
    watch: {
        'frames': function (frames) {
            if (frames.length > 0) {
                this.clearAll = true
            }
            else {
                this.clearAll = false
            }
        }
    },
    computed: {
        vrImages: function () {
            if (this.assets && this.assets.library && this.assets.library.length > 0) {
                return this.assets.library[0].medias
            }

            return []
        }
    },
    methods: {
        selected: function (idx) {
            let asset = this.assets.library.find(asset => asset.id == idx)
            let url = '/storage/' + asset.medias[0].src
            this.currentSrc = url

            let preview = this.$refs.preview
            if (preview && preview.hasOwnProperty('$refs')) {
                let el = this.$refs.preview.$refs.content
                this.viewer.destroy()
                this.viewer = pannellum.viewer(el, {
                        type: 'equirectangular',
                        panorama: url,
                        autoLoad: true,
                        showFullscreenCtrl: false,
                        hfov: 100,
                        pitch: 0,
                        yaw: 0,
                        ignoreGPanoXMP: true,
                    })
                    .on('load', () => {
                        this.renderer = this.viewer.getRenderer()
                        let height = SizeUtility.get(this.$refs.preview.$el)
                        this.$refs.library.setLibraryHeight(height.hClean)
                        // this.$nextTick(this.cropFrame)
                    })
            }

        },
        setNotes: function (notes) {
            this.notes = notes
        },
        getCanvasSize: function (hasReturn = false) {
            let el = this.$refs.preview.$el
            let title = this.$refs.preview.$refs.title.$refs.title
            let elSize = SizeUtility.get(el)
            let titleSize = SizeUtility.get(title)
            elSize.hClean = elSize.hClean - titleSize.hClean - titleSize.marginY
            this.size = elSize
            if (hasReturn) {
                return this.size
            }
        },
        init: function () {
            // load app
            // this.$refs.library.init()
            // console.log(this.assets);

            if (this.$root.session && this.$root.session.app_id) {
                if (this.$root.session.content.hasOwnProperty('frames')) {
                    let frames = JSON.parse(this.$root.session.content.frames)
                    if (frames && frames.length > 0) {
                        this.isLoading = true
                        this.$root.objectsToLoad = frames.length
                        for (let i = 0; i <= frames.length; i++) {
                            if (frames[i]) {
                                this.frames.push(frames[i])
                            }
                        }
                    }
                }
            }

            let preview = this.$refs.preview
            if (preview && preview.hasOwnProperty('$refs')) {
                let el = this.$refs.preview.$refs.content
                this.viewer = pannellum.viewer(el, {
                        type: 'equirectangular',
                        panorama: '/img/test-app/360.jpg',
                        autoLoad: true,
                        showFullscreenCtrl: false,
                        hfov: 100,
                        pitch: 0,
                        yaw: 0,
                        ignoreGPanoXMP: true,
                    })
                    .on('load', () => {
                        this.renderer = this.viewer.getRenderer()
                        let height = SizeUtility.get(this.$refs.preview.$el)
                        this.$refs.library.setLibraryHeight(height.hClean)
                        // this.$nextTick(this.cropFrame)
                    })
            }
        },
        loaded: function () {
            if (this.isLoading) {
                this.$root.objectsLoaded++
            }
        },
        cropFrame: function () {
            let pitch = this.viewer.getPitch() / 180 * Math.PI
            let yaw = this.viewer.getYaw() / 180 * Math.PI
            let hfov = this.viewer.getHfov() / 180 * Math.PI
            let img = this.renderer.render(pitch, yaw, hfov, {
                'returnImage': true,
            })
            let frame = {
                id: this.uniqidSimple(),
                img: img,
                text: null,
            }
            this.frames.push(frame)
            this.saveContent()
        },
        updateFrame: function (value, uuid) {
            let idx = this.frames.findIndex(frame => frame.id == uuid)
            if (idx > -1) {
                this.frames[idx].text = value
            }
            this.saveContent()
        },
        deleteFrame: function (id) {
            this.frames = this.frames.filter(frame => frame.id != id)
            this.saveContent()
        },
        deleteAll: function () {
            this.frames = []
            this.saveContent()
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                frames: JSON.stringify(this.frames),
                src: this.currentSrc,
            }

            for (let key in content) {
                if (content.hasOwnProperty(key) && newContent.hasOwnProperty(key)) {
                    content[key] = newContent[key]
                }
            }

            this.$root.session = {
                ...this.$root.session,
                content: content
            }
        }, 500)
    },
    created: function () {
        this.$root.isApp = true
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
</style>
