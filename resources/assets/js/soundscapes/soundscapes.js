import Vue from 'vue'
import axios from 'axios'

import VueVideoPlayer from 'vue-video-player'
Vue.use(VueVideoPlayer)

import Soundscapes from './components/Soundscapes.vue'

import WaveSurfer from 'wavesurfer.js'
import RegionsPlugin from 'wavesurfer.js/src/plugin/regions.js'

const soundscapes = new Vue({
    el: '#soundscapes',
    components: {
        Soundscapes,
    },
    data: function() {
        return {
            players: null,
            srcs: [],
            slot: 6,
            imageSelected: '',
            playerHeight: 0,
            window: {
                h: 0,
                w: 0,
            }
        }
    },
    methods: {
        init: function() {
            let players = []
            for (let i = 0; i < this.slot; i++) {
                let player = {
                    'player': WaveSurfer.create({
                                container: '#waveform-'+i,
                                plugins: [ RegionsPlugin.create({}) ]
                            }),
                    src: null,
                    vol: 0,
                }
                players.push(player)
            }

            this.players = players
            if (this.srcs.length > 0) {
                for (var i = 0; i < this.srcs.length; i++) {
                    console.log(this.srcs.length)
                    if (this.srcs[i]) {
                        this.players[i].player.load('/storage/'+this.srcs[i])
                        let duration = this.players[i].player.getDuration()
                        this.players[i].player.addRegion({
                            start: 0,
                            end: duration,
                            loop: true,
                            color: 'hsla(100, 100%, 30%, 0.1)'
                        })
                    }
                }
            }
        },
        saveLocal: function() {
            let vol = []
            let src = []

            for (var i = 0; i < this.players.length; i++) {
                vol.push(this.players[i].vol)
                if (this.players[i].src) {
                    src.push(this.players[i].src.src)
                } else {
                    src.push(null)
                }
            }

            localStorage.setItem('app-9-vol', JSON.stringify(vol));
            localStorage.setItem('app-9-audio', JSON.stringify(src));
            localStorage.setItem('app-9-img', this.imageSelected);
        },
        getSize: function() {
            this.window = {
                h: window.innerHeight,
                w: window.innerWidth
            }
        },
        play: function() {
            for (var i = 0; i < this.players.length; i++) {
                this.players[i].player.play()
            }
        },
        pause: function() {
            for (var i = 0; i < this.players.length; i++) {
                this.players[i].player.pause()
            }
        },
        stop: function() {
            for (var i = 0; i < this.players.length; i++) {
                if (this.players[i].player.isPlaying()) {
                    this.players[i].player.pause()
                    this.players[i].player.seekTo(0);
                }
            }
        },
        forward: function() {
            for (var i = 0; i < this.players.length; i++) {
                this.players[i].player.skipForward(5)
            }
        },
        backward: function() {
            for (var i = 0; i < this.players.length; i++) {
                this.players[i].player.skipBackward(5)
            }
        },
        changeSrc: function(idx = null) {
            if (idx >= 0) {
                let src = this.players[idx].src.src

                this.players[idx].player.load('/storage/'+src)
                let duration = this.players[idx].player.getDuration()
                this.players[idx].player.addRegion({
                    start: 0,
                    end: duration,
                    loop: true,
                    color: 'hsla(100, 100%, 30%, 0.1)'
                })
            }
        },
        removeItem: function(idx = null) {
            if (idx >= 0) {
                this.stop()
                this.players[idx].player.destroy()
                this.players[idx].src = false
                this.flushPlayers()
            }
        },
        flushPlayers: function() {
            let newPlayers = []
            let cache = this.players
            for (let i = 0; i < this.slot; i++) {
                this.players[i].player.destroy()

                if (this.players[i].src) {
                    this.$root.$emit('item-unavailable', i)
                } else {
                    this.$root.$emit('item-available', i)
                }

                let player = {
                    'player': WaveSurfer.create({
                        container: '#waveform-'+i,
                        plugins: [RegionsPlugin.create({})]
                        }),
                    src: this.players[i].src,
                }
                newPlayers.push(player)
            }
            this.players = []
            this.players = newPlayers

        }
    },
    mounted: function() {
        this.getSize()
        this.init()

        window.addEventListener('resize', () => {
            this.getSize()
        })

    }
})
