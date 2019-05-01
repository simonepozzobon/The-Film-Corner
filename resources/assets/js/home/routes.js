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
                        path: 'studio/:pavilion',
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
                    {
                        path: 'dashboard/:app',
                        name: 'app-home',
                        component: require('./views/apps/AppSingle.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'frame-composer',
                        name: 'frame-composer',
                        component: require('./views/apps/FrameComposer.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'frame-crop',
                        name: 'frame-crop',
                        component: require('./views/apps/FrameCrop.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'types-of-images',
                        name: 'types-of-images',
                        component: require('./views/apps/TypesOfImages.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'parallel-action',
                        name: 'parallel-action',
                        component: require('./views/apps/ParallelAction.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'offscreen',
                        name: 'offscreen',
                        component: require('./views/apps/Offscreen.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'whats-going-on',
                        name: 'whats-going-on',
                        component: require('./views/apps/WhatsGoingOn.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'soundscapes',
                        name: 'soundscapes',
                        component: require('./views/apps/Soundscapes.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'active-offscreen',
                        name: 'active-offscreen',
                        component: require('./views/apps/ActiveOffscreen.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'active-parallel-action',
                        name: 'active-parallel-action',
                        component: require('./views/apps/ActiveParallelAction.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'sound-studio',
                        name: 'sound-studio',
                        component: require('./views/apps/SoundStudio.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'character-builder',
                        name: 'character-builder',
                        component: require('./views/apps/CharacterBuilder.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'lumiere-minute',
                        name: 'lumiere-minute',
                        component: require('./views/apps/LumiereMinute.vue').default,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'make-your-own-film',
                        name: 'make-your-own-film',
                        component: require('./views/apps/MakeYourOwnFilm.vue').default,
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
