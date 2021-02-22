<template> 
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="/images/vue-laravel.jpg" alt="Logo VueLaravel" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">Vue Laravel SPA</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="user.photo" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <span class="d-block text-light">{{ user.name }}</span>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <template v-for="(item,index) in slideMenuItens">
                        <menu-item
                            v-if="item.permission ? userPermissions.includes(item.permission) : true"
                            :data="item"
                            :key="index"
                            :type="item.type"
                            :isHeader="item.isHeader"
                            :icon="item.icon"
                            :name="item.name"
                            :badge="item.badge"
                            :items="item.items"
                            :router="item.router"
                            :link="item.link">
                        </menu-item>
                    </template>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
import MenuItem from './MenuItem.vue'
import {mapGetters} from 'vuex'
export default {
    props: {
        slideMenuItens: {
            type: Array,
            default: []
        }
    },
    methods: {

    },
    components: {
        'menu-item': MenuItem
    },
    computed: {
        ...mapGetters('auth', {
            user: 'user',
            userPermissions: 'userPermissions'
        })
    },
}
</script>

<style scoped>
    .main-sidebar {
        height: 100%;
        margin-top: 0px;
    }
</style>
