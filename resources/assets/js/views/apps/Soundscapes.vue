<template>
<app-template :app="app">
    <template slot="left">
        <ui-app-soundscapes-preview
            ref="preview"
            :src="this.image"
            :players="players"
            @ready="ready"
        />
        <div
            v-for="(player, i) in slot"
            class="d-none"
            ref="player"
            :key="i"
        >
        </div>
    </template>
    <template slot="right">
        <ui-app-library
            ref="library"
            :hasSubLibraries="assets.hasSubLibraries"
            :type="assets.type"
            :items="assets.library"
            :color="color"
            @selected="selected"
        />
    </template>
    <template>
        <ui-app-mixer
            v-if="players.length > 0"
            :color="color"
            :players="players"
            @volume="volumeChanged"
            @remove-track="removeTrack"
        />
        <ui-app-note
            :initial="this.notes"
            class="mt-4"
            :color="color"
            @changed="setNotes"
        />
        <channel-selector
            ref="selector"
            v-if="players.length > 0"
            :players="players"
            @channel-selected="channelSelected"
        />

    </template>
</app-template>
</template>

<script>
import AppTemplate from './AppTemplate.vue'
import ChannelSelector from '../../uiapp/sub/mixer/ChannelSelector.vue'
import {
    UiAppFolder,
    UiAppImage,
    UiAppLibrary,
    UiAppMixer,
    UiAppNote,
    UiAppSoundscapesPreview
}
from '../../uiapp'
import {
    SharedData,
    SharedMethods,
    SharedWatch
}
from './Shared'
import SizeUtility from '../../Sizes'
import WaveSurfer from 'wavesurfer.js'
import RegionsPlugin from 'wavesurfer.js/src/plugin/regions.js'
export default {
    name: 'Soundscapes',
    components: {
        AppTemplate,
        ChannelSelector,
        UiAppFolder,
        UiAppImage,
        UiAppLibrary,
        UiAppMixer,
        UiAppNote,
        UiAppSoundscapesPreview,
    },
    data: function () {
        return {
            ...SharedData,
            players: [],
            slot: 6,
            image: null,
            current: null,
            isLoading: false,
            jumbo: 0,
        }
    },
    watch: {
        ...SharedWatch,
        // isLoading: function (value) {
        //     console.log('isLodaing', value);
        // }
    },
    methods: {
        randomID: function (min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        },
        init: function () {
            for (let i = 0; i < this.$refs.player.length; i++) {
                let packet = {
                    player: WaveSurfer.create({
                        container: this.$refs.player[i],
                        plugins: [RegionsPlugin.create({})]
                    }),
                    obj: null,
                    vol: 0,
                }

                packet.player.on('ready', () => {
                    // console.log('player.ready');
                    this.ready()
                    // this.playersReady()
                })

                this.players.push(packet)
            }

            let session = this.$root.session
            if (session && session.app_id == 9) {
                let content = session.content
                let audios = content['audio-src']
                let image = content['image']
                // https://stackoverflow.com/questions/281264/remove-empty-elements-from-an-array-in-javascript
                // let audios = audios.filter(Boolean)
                if (audios) {
                    let count = audios.length + 2
                    // console.log(count);

                    this.isLoading = true
                    this.$root.isOpen = true
                    this.$root.objectsToLoad = count

                    this.$nextTick(() => {
                        let audioLibrary = this.assets.library.find(library => library.type === 'audios' && library.name === 'Audio')
                        for (let i = 0; i < audios.length; i++) {
                            if (audios[i]) {
                                this.current = audioLibrary.audios.find(audio => audio.src === audios[i])
                                // console.log(this.current);
                                this.channelSelected(i)
                                this.volumeChanged(content['audio-vol'][i], i)
                            }
                            else {
                                this.ready()
                            }
                        }

                        this.image = image
                    })
                }
            }

            if (!this.isLoading) {
                let imageLibrary = this.assets.library[1]
                if (imageLibrary && imageLibrary.hasOwnProperty('medias') &&
                    imageLibrary.medias.length > 0) {
                    let library = imageLibrary.medias
                    let idx = this.randomID(0, library.length)
                    this.image = '/storage/' + library[idx].src
                }
                else {
                    this.image = '/img/test-app/1.png'
                }
            }
        },
        selected: function (idx, libraryID) {
            let library = this.assets.library.find(library => library.id == libraryID)
            let type, asset
            if (library) {
                switch (library.type) {
                case 'audios':
                    asset = library.audios.find(audio => audio.id == idx)
                    if (asset) {
                        this.current = asset
                        this.$nextTick(this.$refs.selector.show)
                    }
                    break;
                default:
                    asset = library.medias.find(image => image.id == idx)
                    if (asset) {
                        this.image = '/storage/' + asset.src
                    }
                }
            }
        },
        channelSelected: function (idx, src = null) {
            if (this.current) {
                // console.log(this.players[idx]);
                this.players[idx].obj = this.current
                let src = '/storage/' + this.current.src
                this.$refs.preview.stop()
                this.$nextTick(() => {
                    this.players[idx].player.clearRegions()
                    this.players[idx].player.load(src)
                    this.players[idx].player.setMute(false)
                    let duration = this.players[idx].player.getDuration()
                    this.players[idx].player.addRegion({
                        start: 0,
                        end: duration,
                        loop: true,
                        color: 'hsla(100, 100%, 30%, 0.1)',
                    })
                    this.current = null
                    this.saveContent()
                })
            }
        },
        volumeChanged: function (volume, idx) {
            this.players[idx].vol = volume
            this.players[idx].player.setVolume(volume / 100)
            this.saveContent()
        },
        removeTrack: function (idx) {
            this.$refs.preview.stop()
            this.players[idx].player.setMute(true)
            this.$nextTick(() => {
                this.players[idx].vol = 0
                this.players[idx].obj = null
                this.saveContent()
            })
        },
        setNotes: function (notes) {
            this.notes = notes
        },
        ready: function () {
            this.$nextTick(() => {
                let title = this.$refs.preview.$refs.title.$el
                let titleH = SizeUtility.get(title)
                let containerH = SizeUtility.get(this.$refs.preview.$el)
                let height = containerH.h - titleH.hClean
                this.$refs.library.setLibraryHeight(height)
            })
            if (this.isLoading) {
                this.$root.objectsLoaded++
                // console.log(this.$root.objectsLoaded, 'di', this.$root.objectsToLoad);
            }
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                'audio-src': this.players.map(player => (player.obj && player.obj.hasOwnProperty('src')) ? player.obj.src : null),
                'audio-vol': this.players.map(player => player.vol),
                image: this.image,
                notes: this.notes
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
        }, 500),
    },
    created: function () {
        this.getData = SharedMethods.getData.bind(this)
        this.$root.isApp = true
        this.getData()
        // this.getData('5cffd9d60c401')
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
