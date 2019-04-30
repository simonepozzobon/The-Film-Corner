const routes = [
    {
        path: '/',
        component: require('./containers/MainContainer.vue').default,
        children: [
            {
                path: '',
                component: require('./views/home/Home.vue').default,
                children: [
                    {
                        path: '',
                        name: 'home',
                        component: require('./views/home/HomePanel.vue').default,
                    },
                    {
                        path: 'login',
                        name: 'login',
                        component: require('./views/home/LoginPanel.vue').default,
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
                component: require('./views/conference/ConferenceContainer.vue').default,
                children: [
                    {
                        path: '',
                        name: 'conference',
                        component: require('./views/conference/Home.vue').default,
                    },
                    {
                        path: 'about',
                        name: 'conf-about',
                        component: require('./views/conference/About.vue').default,
                    },
                    {
                        path: 'schedule-draft',
                        name: 'conf-schedule-draft',
                        component: require('./views/conference/ScheduleDraft.vue').default,
                    },
                    {
                        path: 'accomodation',
                        name: 'conf-accomodation',
                        component: require('./views/conference/Accomodation.vue').default,
                    },
                    {
                        path: 'downloads',
                        name: 'conf-downloads',
                        component: require('./views/conference/Downloads.vue').default,
                    },
                    {
                        path: 'contact',
                        name: 'conf-contact',
                        component: require('./views/conference/Contact.vue').default,
                    },
                ]
            },
            {
                path: 'apps',
                component: require('./views/apps/AppsContainer.vue').default,
                children: [
                    {
                        path: '',
                        name: 'apps-home',
                        component: require('./views/apps/Home.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'pavilion/:pavilion',
                        name: 'pavilion-home',
                        component: require('./views/apps/StudioSingle.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'path/:cat',
                        name: 'cat-home',
                        component: require('./views/apps/CatSingle.vue').default,
                        meta: { requiresAuth: true },
                    },
                ],
            },
            {
                path: 'news/:slug',
                name: 'news-single',
                component: require('./views/News.vue').default,
            }
        ],
    },

]

export default routes
