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

new Vue({
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
        }
    },
    watch: {
        timelines: function(timelines) {
            console.log('changed')
            this.updateEditor()
        }
    },
    methods: {
        updateEditor: function() {
            // this.showLoader = true
            this.$refs.videoPreview.showLoader()
            let session = window.$session

            let data = new FormData()
            data.append('session', session.token)
            data.append('timelines', JSON.stringify(this.timelines))
            axios.post('/api/v1/video-edit', data).then(response => {
                console.log(response)
                // this.showLoader = false
                this.$refs.videoPreview.changeSrc(response.data.export)
            })
        },
        addTimeline: function(obj) {
            let timeline = {
                id: obj.id,
                title: obj.title,
                duration: obj.duration * 10,
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
