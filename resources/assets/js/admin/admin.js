require('bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import AdminTemplate from './components/AdminTemplate.vue'
import routes from './routes'
import BootstrapVue from 'bootstrap-vue'
import axios from 'axios'
import VuejsClipper from 'vuejs-clipper'
import EventBus from './EventBus'
import Utility from '../Utilities'

Vue.config.productionTip = false
Vue.prototype.$http = axios
Vue.prototype.$ebus = EventBus
Vue.prototype.$util = Utility

Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(VuejsClipper)

const router = new VueRouter({
    mode: 'history',
    dir: __dirname,
    base: '/admin',
    routes: routes,
})

const admin = new Vue({
    router,
    components: {
        AdminTemplate,
    },
    methods: {
        goTo: function (name) {
            this.$router.push({
                name: name
            })
        },
        goToWithParams: function (name, params) {
            if (this.$route.name != name) {
                this.$router.push({
                    name: name,
                    params: params
                })
            }
        },
    },
    mounted: function () {}
}).$mount('#admin')
