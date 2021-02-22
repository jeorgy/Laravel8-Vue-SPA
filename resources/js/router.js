import VueRouter from 'vue-router'

// Views
import Home from './views/Home.vue'
import Login from './views/Login'
// Usuários
import Users from './views/users/Users.vue'
import UsersList from './views/users/List.vue'
import UserShow from './views/users/UserShow.vue'
import UserCreate from './views/users/UserCreate.vue'
import Roles from './views/users/Roles.vue'
import Permissions from './views/users/Permissions.vue'
// To Do List
import ToDoList from './views/toDoList/ToDoList.vue'

// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    // USER ROUTES
    {
        path: '/users', props: true, component: Users,
        children: [
            {
                path: '', name: 'users', component: UsersList,
                meta: { auth: true }
            },
            {
                path: 'create', name: 'newUser', component: UserCreate,
                meta: { auth: true }
            },
            {
                path: 'user/:id', name: 'user', component: UserShow, props: true,
                meta: { auth: true }
            },
            {
                path: 'perfis', name: 'roles', component: Roles,
                meta: { auth: true }
            },
            {
                path: 'permissoes', name: 'permissions', component: Permissions,
                meta: { auth: true }
            }
        ]
    },
    // To Do List Routes
    {
        path: '/to-do-list',
        name: 'toDoList',
        component: ToDoList,
        meta: {
            auth: true
        }
    },
]

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})

export default router