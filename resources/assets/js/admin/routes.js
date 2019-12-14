import AdminHome from './views/AdminHome.vue'
import Apps from './views/Apps.vue'
import ClipCreate from './views/ClipCreate.vue'
import News from './views/News.vue'
import PropagandApp from './views/PropagandApp.vue'
import Translate from './views/Translate.vue'
import Users from './views/Users.vue'
import UploadZone from './views/test/UploadZone.vue'
import Esercizi from './views/test/Esercizi.vue'

export default [{
        path: '/',
        name: 'home',
        component: AdminHome,
    },
    {
        path: '/applicazioni',
        name: 'apps',
        component: Apps
    },
    {
        path: '/traduzioni',
        name: 'translate',
        component: Translate
    },
    {
        path: '/utenti',
        name: 'users',
        component: Users
    },
    {
        path: '/propagandapp',
        name: 'propagandapp',
        component: PropagandApp
    },
    {
        path: '/news',
        name: 'news',
        component: News,
    },
    {
        path: '/clips/create',
        name: 'clips-create',
        component: ClipCreate,
    },
    {
        path: '/clips/edit/:id',
        name: 'clips-edit',
        component: ClipCreate,
    },
    {
        path: '/test/uploadzone',
        name: 'test-uploadzone',
        component: UploadZone,
    },
    {
        path: '/test/esercizi',
        name: 'test-esercizi',
        component: Esercizi,
    }

]
