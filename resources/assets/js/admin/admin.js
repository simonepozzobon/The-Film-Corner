import Vue from 'vue'
import VueRouter from 'vue-router'
import AdminTemplate from './components/AdminTemplate.vue'
import routes from './routes'
import BootstrapVue from 'bootstrap-vue'
import axios from 'axios'
import VuejsClipper from 'vuejs-clipper'

Vue.config.productionTip = false
Vue.prototype.$http = axios

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
        goTo: function(name) {
            this.$router.push({ name: name })
        }
    },
    mounted: function() {}
}).$mount('#admin')
