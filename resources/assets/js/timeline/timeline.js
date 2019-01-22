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
                    cache[i].start = cache[i].start / this.tick
                    cache[i].duration = cache[i].duration / this.tick
                }
                resolve(cache)
            })
        },
        updateEditor: _.debounce(e => {
            timeline.$refs.videoPreview.showLoader()

            timeline.reformatTimelines().then(cache => {
                console.log('prima di inviare', cache)
                let session = window.$session
                let data = new FormData()

                data.append('session', session.token)
                data.append('timelines', JSON.stringify(cache))

                axios.post('/api/v1/video-edit', data).then(response => {
                    console.log('render completato', response.data)
                    timeline.$refs.videoPreview.changeSrc(response.data.export)
                })
            })

        }, 500),
        addTimeline: function(obj) {
            let timeline = {
                id: obj.id,
                title: obj.title,
                duration: obj.duration * this.tick,
                start: 0,
                src: obj.src,
                img: obj.img
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
    }
})
