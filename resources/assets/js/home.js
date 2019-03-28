require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './home/routes'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    dir: __dirname,
    routes: routes,
})

import MainTemplate from './home/containers/MainTemplate.vue'

const home = new Vue({
    router,
    components: {
        MainTemplate,
    },
    data: function() {
        return {
            window: { w: 0, h: 0 },
            isMobile: null,
            conferenceMenu: null,
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
        window.addEventListener('resize', () => {
            this.getSize()
        })
    },
    // render: h => h(home)
}).$mount('#home')
