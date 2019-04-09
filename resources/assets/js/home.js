require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './home/routes'
import * as Sentry from '@sentry/browser'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    dir: __dirname,
    routes: routes,
})

// if (process.env == 'production') {
//     Sentry.init({
//         dsn: 'https://43543bff49ce47debc45b09194a4dda8@sentry.io/1426776',
//         integrations: [
//             new Sentry.Integrations.Vue({
//                 Vue,
//                 attachProps: true
//             })
//         ]
//     })
// }

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
            user: null,
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
        },
        goTo: function(name) {
            if (this.$route.name != name) {
                this.$router.push({name: name})
            }
        },
        goToAndScroll: function(name, target) {
            if (this.$route.name != target) {
                this.$router.push({name: target})
                return false
            }
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
