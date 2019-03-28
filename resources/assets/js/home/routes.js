const routes = [
    {
        path: '/',
        component: {
            render (c) { return c('router-view') }
        },
        children: [
            {
                path: '',
                component: require('./views/Home.vue').default,
                children: [
                    {
                        path: '',
                        name: 'home',
                        component: require('./components/HomePanel.vue').default,
                    },
                    {
                        path: 'login',
                        name: 'login',
                        component: require('./components/LoginPanel.vue').default,
                    }
                ],
            },
            {
                path: 'the-project',
                name: 'project',
                component: require('./views/About.vue').default,
            },
            {
                path: 'schools',
                name: 'schools',
                component: require('./views/Schools.vue').default,
            },
            {
                path: 'filmography',
                name: 'filmography',
                component: require('./views/Filmography.vue').default,
            },
            {
                path: 'conference',
                component: require('./views/conference/Dummy.vue').default,
                children: [
                    {
                        path: '',
                        name: 'conference',
                        components: {
                            conference: require('./views/conference/Home.vue').default
                        },
                    },
                    {
                        path: 'about',
                        name: 'conf-about',
                        components: {
                            conference: require('./views/conference/About.vue').default
                        },
                    },
                    {
                        path: 'downloads',
                        name: 'conf-downloads',
                        components: {
                            conference: require('./views/conference/Downloads.vue').default
                        },
                    },
                    {
                        path: 'contact',
                        name: 'conf-contact',
                        components: {
                            conference: require('./views/conference/Contact.vue').default
                        },
                    },
                ]
            },
        ],
    },

]

export default routes
