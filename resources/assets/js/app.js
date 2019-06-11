require('./bootstrap')

import axios from 'axios'
import BootstrapVue from 'bootstrap-vue'
import Cookie from './Cookies'
import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'

import * as Sentry from '@sentry/browser'
import * as Integrations from '@sentry/integrations'

Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(BootstrapVue)
Vue.use(VueRouter)

Vue.prototype.$cookie = Cookie

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
}

Vue.prototype.$http = axios

// Sentry.init({
//     dsn: 'https://43543bff49ce47debc45b09194a4dda8@sentry.io/1426776',
//     integrations: [new Integrations.Vue({Vue, attachProps: true})],
// })


const router = new VueRouter({
    mode: 'history',
    dir: __dirname,
    routes: routes,
})

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        const app = router.app
        let user = app.user
        let token = app.token

        if ((user && token)) {
            // Procedi
            console.log('procedi');
            next()
        } else if (typeof user == 'undefined' || typeof token == 'undefined') {
            let app = router.app
            let user = app.$cookie.get('tfc-user')
            user = JSON.parse(user) ? JSON.parse(user) : null

            let auth = app.$http.defaults.headers.common.hasOwnProperty('Authorization')

            if (user && !auth) {
                let data = new FormData()
                data.append('id', user.id)
                data.append('email', user.email)
                data.append('role_id', user.role_id)
                app.$http.post('/api/v2/get-token', data).then(response => {
                    if (response.data.success) {
                        app.user = response.data.user
                        app.token = response.data.token
                        app.$cookie.set('tfc-logged', true)
                        app.$cookie.set('tfc-user', JSON.stringify(app.user))
                        app.$cookie.set('tfc-token', JSON.stringify(app.token))
                        app.$http.defaults.headers.common.Authorization = `${app.token.token_type} ${app.token.access_token}`

                        console.log('procedi dopo riautenticazione');
                        next()
                    } else {
                        app.$cookie.destroy('tfc-logged')
                        app.$cookie.destroy('tfc-user')
                        app.$cookie.destroy('tfc-token')
                        delete app.$http.defaults.headers.common.Authorization

                        console.log('autenticazione cookies non riuscita');
                        router.push({name: 'login'})
                    }
                })
            } else {
                console.log('user e headers non ci sono nei cookies ->headers', user, auth);
                router.push({name: 'login'})
                return false
            }
        } else {
            console.log('user e token non esistono');
            router.push({name: 'login'})
            return false
        }
    } else {
        console.log('nessuna autorizzazione');
        next()
    }
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

import MainTemplate from './containers/MainTemplate.vue'
import SessionParams from './SessionParams'

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
            token: null,
            isApp: null,
            isOpen: null,
            isNetwork: null,
            space: true,
            session: null,
            progress: 0,
            objectsToLoad: 0,
            objectsLoaded: 0,
        }
    },
    watch: {
        session: function(session) {
            this.checkSession(session.app_id)
        },
        objectsToLoad: function(value) {
            // console.log('oggetti da caricare', value);
            this.objectsLoaded = 0
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
        checkSession: function(app_id) {
            let params = SessionParams
            for (let key in params) {
                if (params.hasOwnProperty(key) && key == app_id) {
                    this.fixSession(params[key])
                }
            }
        },
        fixSession: function(params) {
            let content = this.session.content
            if (content.length || content.length == 0) {
                // https://stackoverflow.com/questions/4215737/convert-array-to-object
                content = this.session.content.reduce((obj, cur, i) => ({ ...obj, [i]: cur }), {});
            }
            for (let i = 0; i < params.length; i++) {
                if (!content.hasOwnProperty(params[i])) {
                    content[params[i]] = null
                }
            }

            this.session.content = content
        },
        goTo: function(name, bypass = false) {
            if (this.$route.name != name && !bypass) {
                this.$router.push({ name: name })
            } else {
                this.$router.go(this.$route.path)
            }
        },
        goToAndScroll: function(name, target) {
            if (this.$route.name != target) {
                this.$router.push({name: target})
                return false
            }
        },
        goToWithParams: function(name, params) {
            if (this.$route.name != name) {
                this.$router.push({name: name, params: params})
            }
        },
        init: function() {
            let user = this.$cookie.get('tfc-user')
            user = JSON.parse(user) ? JSON.parse(user) : null

            if (user) {
                let data = new FormData()
                data.append('id', user.id)
                data.append('email', user.email)
                data.append('role_id', user.role_id)

                this.$http.post('/api/v2/get-token', data).then(response => {
                    if (response.data.success) {
                        this.user = response.data.user
                        this.token = response.data.token
                        this.login()
                    } else {
                        this.logout()
                    }
                })
            }
        },
        login: function() {
            this.$cookie.set('tfc-logged', true)
            this.$cookie.set('tfc-user', JSON.stringify(this.user))
            this.$cookie.set('tfc-token', JSON.stringify(this.token))
            this.$http.defaults.headers.common.Authorization = `${this.token.token_type} ${this.token.access_token}`
        },
        logout: function() {
            this.user = null
            this.token = null
            // this.$cookie.destroy('tfc-logged')
            // this.$cookie.destroy('tfc-user')
            // this.$cookie.destroy('tfc-token')

            delete this.$http.defaults.headers.common.Authorization
            this.goTo('login')
        }
    },
    created: function() {
        this.init()
    },
    mounted: function() {
        this.getSize()
        window.addEventListener('resize', () => {
            this.getSize()
        })
    },
    // render: h => h(home)
}).$mount('#home')
