import AdminHome from './views/AdminHome.vue'
import Users from './views/Users.vue'

export default [
    {
        path: '/',
        name: 'home',
        component: AdminHome,
    },
    {
        path: '/users',
        name: 'users',
        component: Users
    }
]
