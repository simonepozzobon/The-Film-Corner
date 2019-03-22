require('./bootstrap')

import Vue from 'vue'

import MainTemplate from './home/containers/MainTemplate.vue'
const home = new Vue({
    components: {
        MainTemplate,
    },
    data: function() {
        return {
            window: { w: 0, h: 0 },
            isMobile: null,
        }
    },
    methods: {
        getSize: function() {
            let view = {
                w: window.innerWidth,
                h: window.innerHeight
            }

            if (view.w <= 576) {
                this.isMobile = true
            } else {
                this.isMobile = false
            }

            this.window = view

            return this.window
        }
    },
    mounted: function() {
        this.getSize()
        console.log('ciao');

        window.addEventListener('resize', () => {
            this.getSize()
        })
    }
}).$mount('#home')
