import Vue from 'vue'

import ControlBar from './components/ControlBar.vue'
import Library from './components/Library.vue'
import Timeline from './components/Timeline.vue'
import VideoPreview from './components/VideoPreview.vue'

import VueVideoPlayer from 'vue-video-player'
Vue.use(VueVideoPlayer)

import axios from 'axios'

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
            showLoader: true,
        }
    },
    methods: {
        updateEditor: function() {
            this.showLoader = true

            let data = new FormData()
            data.append('timelines', this.timelines)
            axios.post('/api/v1/video-edit', data).then(response => {
                console.log(response)
                this.showLoader = false
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
        }
    },
    mounted: function() {
        this.$on('add-to-timeline', obj => {
            this.addTimeline(obj)
        })
    }
})
