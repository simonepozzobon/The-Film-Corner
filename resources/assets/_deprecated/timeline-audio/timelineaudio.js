import Vue from 'vue'

import ControlBar from './components/ControlBar.vue'
import Library from './components/Library.vue'
import Timeline from './components/Timeline.vue'
import VideoPreview from './components/VideoPreview.vue'

import VueVideoPlayer from 'vue-video-player'
Vue.use(VueVideoPlayer)

import axios from 'axios'

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

import debounce from 'lodash/debounce'
Vue.prototype.$debounce = _.debounce

const timeline = new Vue({
    el: '#timeline',
    components: {
        ControlBar,
        Library,
        Timeline,
        VideoPreview,
    },
    data: function() {
        return {
            timelines: [],
            showLoader: false,
            src: null,
            tick: 10,
            video_src: null,
        }
    },
    watch: {
        timelines: function(timelines) {
            this.updateEditor()
        }
    },
    methods: {
        reformatTimelines: function() {
            return new Promise(resolve => {
                let cache = this.timelines.slice() // clone
                for (var i = 0; i < cache.length; i++) {
                    cache[i] = {
                        ...cache[i],
                        id: i,
                        originalDuration: cache[i].originalDuration / this.tick,
                        duration: cache[i].duration / this.tick,
                        start: cache[i].start / this.tick,
                        cutStart: cache[i].cutStart / this.tick,
                        cutEnd: cache[i].cutEnd / this.tick,
                    }
                }
                resolve(cache)
            })
        },
        updateEditor: _.debounce(e => {
            console.log('--------> updating')
            timeline.$refs.videoPreview.showLoader()

            timeline.reformatTimelines().then(cache => {
                // console.log('prima di inviare', cache)
                let session = window.$session
                let app_id = session.app_id
                let data = new FormData()

                // salvo le timelines per poi abbinarle alla sessione
                localStorage.setItem('app-' + app_id + '-timelines', JSON.stringify(timeline.timelines))

                // console.log('Prima di inviare', cache)
                data.append('session', session.token)
                data.append('video_src', timeline.video_src)
                data.append('timelines', JSON.stringify(cache))

                axios.post('/api/v1/audio-edit', data).then(response => {
                    // console.log('render completato', response.data)
                    timeline.$refs.videoPreview.changeSrc(response.data.export)
                    timeline.$refs.videoPreview.hideLoader()

                    // salvo l'export per poi abbinarlo alla sessione
                    localStorage.setItem('app-' + app_id + '-video', response.data.export)

                })
            })
        }, 500),
        addTimeline: function(obj, empty = false) {
            let timeline
            if (!empty) {
                timeline = {
                    id: obj.id,
                    uniqueid: '_' + Math.random().toString(36).substr(2, 9),
                    title: obj.title,
                    originalDuration: obj.duration * this.tick,
                    duration: obj.duration * this.tick,
                    start: 0,
                    src: obj.src,
                    img: obj.img,
                    hasCutStart: false,
                    hasCutEnd: false,
                    cutStart: 0,
                    cutEnd: 0,
                }
            } else {
                console.log('dentro', obj)
                timeline = {
                    ...obj,
                    originalDuration: obj.originalDuration,
                    duration: obj.duration,
                    start: obj.start,
                    cutStart: obj.cutStart,
                    cutEnd: obj.cutEnd,
                }
            }
            this.timelines.push(timeline)
        },
        play: function() {
            this.$refs.videoPreview.play()
        },
        pause: function() {
            this.$refs.videoPreview.pause()
        },
        stop: function() {
            this.$refs.videoPreview.stop()
        },
        backward: function() {
            this.$refs.videoPreview.backward()
        },
        forward: function() {
            this.$refs.videoPreview.forward()
        },
    },
    mounted: function() {
        this.$on('add-to-timeline', obj => {
            this.addTimeline(obj)
        })

        if (window.$session && window.$session.timelines) {
            let timelines = JSON.parse(window.$session.timelines)
            for (var i = 0; i < timelines.length; i++) {
                this.addTimeline(timelines[i], true)
            }
        }
    }
})
