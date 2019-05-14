import MainContainer from './containers/MainContainer.vue'
import ConferenceContainer from './views/conference/ConferenceContainer.vue'
import AppsContainer from './views/apps/AppsContainer.vue'
import NetworkContainer from './views/network/NetworkContainer.vue'

// Public
import Home from './views/home/Home.vue'
import HomePanel from './views/home/HomePanel.vue'
import LoginPanel from './views/home/LoginPanel.vue'
import About from './views/About.vue'
import Schools from './views/Schools.vue'
import Filmography from './views/Filmography.vue'
import News from './views/News.vue'

// Conference
import ConferenceHome from './views/conference/ConferenceHome.vue'
import ConferenceAbout from './views/conference/ConferenceAbout.vue'
import ScheduleDraft from './views/conference/ScheduleDraft.vue'
import Accomodation from './views/conference/Accomodation.vue'
import Downloads from './views/conference/Downloads.vue'
import Contact from './views/conference/Contact.vue'

// Applicazioni
import AppsHome from './views/apps/AppsHome.vue'
import StudioSingle from './views/apps/StudioSingle.vue'
import CatSingle from './views/apps/CatSingle.vue'
import AppSingle from './views/apps/AppSingle.vue'

// Applicazioni Singole
import FrameComposer from './views/apps/FrameComposer.vue'
import FrameCrop from './views/apps/FrameCrop.vue'
import TypesOfImages from './views/apps/TypesOfImages.vue'
import ParallelAction from './views/apps/ParallelAction.vue'
import Offscreen from './views/apps/Offscreen.vue'
import WhatsGoingOn from './views/apps/WhatsGoingOn.vue'
import Soundscapes from './views/apps/Soundscapes.vue'
import ActiveOffscreen from './views/apps/ActiveOffscreen.vue'
import ActiveParallelAction from './views/apps/ActiveParallelAction.vue'
import SoundStudio from './views/apps/SoundStudio.vue'
import CharacterBuilder from './views/apps/CharacterBuilder.vue'
import LumiereMinute from './views/apps/LumiereMinute.vue'
import MakeYourOwnFilm from './views/apps/MakeYourOwnFilm.vue'
import Storytelling from './views/apps/Storytelling.vue'

// Network
import NetworkHome from './views/network/NetworkHome.vue'
import NetworkSingle from './views/network/NetworkSingle.vue'

const routes = [
    {
        path: '/',
        component: MainContainer,
        children: [
            {
                path: '',
                component: Home,
                children: [
                    {
                        path: '',
                        name: 'home',
                        component: HomePanel,
                    },
                    {
                        path: 'login',
                        name: 'login',
                        component: LoginPanel,
                    }
                ],
            },
            {
                path: 'the-project',
                name: 'project',
                component: About,
            },
            {
                path: 'schools',
                name: 'schools',
                component: Schools,
            },
            {
                path: 'filmography',
                name: 'filmography',
                component: Filmography,
            },
            {
                path: 'conference',
                component: ConferenceContainer,
                children: [
                    {
                        path: '',
                        name: 'conference',
                        component: ConferenceHome,
                    },
                    {
                        path: 'about',
                        name: 'conf-about',
                        component: ConferenceAbout,
                    },
                    {
                        path: 'schedule-draft',
                        name: 'conf-schedule-draft',
                        component: ScheduleDraft,
                    },
                    {
                        path: 'accomodation',
                        name: 'conf-accomodation',
                        component: Accomodation,
                    },
                    {
                        path: 'downloads',
                        name: 'conf-downloads',
                        component: Downloads,
                    },
                    {
                        path: 'contact',
                        name: 'conf-contact',
                        component: Contact,
                    },
                ]
            },
            {
                path: 'apps',
                component: AppsContainer,
                children: [
                    {
                        path: '',
                        name: 'apps-home',
                        component: AppsHome,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'studio/:pavilion',
                        name: 'pavilion-home',
                        component: StudioSingle,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'path/:cat',
                        name: 'cat-home',
                        component: CatSingle,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'dashboard/:app',
                        name: 'app-home',
                        component: AppSingle,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'frame-composer',
                        name: 'frame-composer',
                        component: FrameComposer,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'frame-crop',
                        name: 'frame-crop',
                        component: FrameCrop,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'types-of-images',
                        name: 'types-of-images',
                        component: TypesOfImages,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'parallel-action',
                        name: 'parallel-action',
                        component: ParallelAction,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'offscreen',
                        name: 'offscreen',
                        component: Offscreen,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'whats-going-on',
                        name: 'whats-going-on',
                        component: WhatsGoingOn,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'soundscapes',
                        name: 'soundscapes',
                        component: Soundscapes,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'active-offscreen',
                        name: 'active-offscreen',
                        component: ActiveOffscreen,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'active-parallel-action',
                        name: 'active-parallel-action',
                        component: ActiveParallelAction,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'sound-studio',
                        name: 'sound-studio',
                        component: SoundStudio,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'character-builder',
                        name: 'character-builder',
                        component: CharacterBuilder,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'lumiere-minute',
                        name: 'lumiere-minute',
                        component: LumiereMinute,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'make-your-own-film',
                        name: 'make-your-own-film',
                        component: MakeYourOwnFilm,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'storytelling',
                        name: 'storytelling',
                        component: Storytelling,
                        meta: { requiresAuth: true },
                    },

                ],
            },
            {
                path: 'network',
                component: NetworkContainer,
                children: [
                    {
                        path: '',
                        name: 'network-home',
                        component: NetworkHome,
                        meta: { requiresAuth: true },
                    },
                    {
                        path: 'single/:id',
                        name: 'network-single',
                        component: NetworkSingle,
                        meta: { requiresAuth: true },
                    }
                ],
            },
            {
                path: 'news/:slug',
                name: 'news-single',
                component: News,
            }
        ],
    },

]

export default routes
