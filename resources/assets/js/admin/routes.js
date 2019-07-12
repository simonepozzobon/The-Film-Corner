import AdminHome from './views/AdminHome.vue'
import Apps from './views/Apps.vue'
import Users from './views/Users.vue'

export default [
    {
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
        path: '/utenti',
        name: 'users',
        component: Users
    }
]
