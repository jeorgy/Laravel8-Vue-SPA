import UsersMenu from './menus/users_menu.json'

export default [
    {
        type: 'item',
        icon: 'fas fa-home',
        name: 'Home',
        router: {
          name: 'home'
        },
        permission: null
    },
    {
        type: 'tree',
        icon: 'fas fa-users',
        name: 'Usuários',
        items: [...UsersMenu
        ],
        permission: 'view_users'
    },
    {
        type: 'item',
        icon: 'fas fa-address-book',
        name: 'Lista de Tarefas',
        router: {
          name: 'toDoList'
        },
        permission: null
    },
]