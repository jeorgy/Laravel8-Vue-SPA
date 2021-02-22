<template>
    <nav class="main-header navbar navbar-expand navbar-dark navbar-gray-dark border-bottom-0">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-4 col-md-3 input-group input-group-sm">
            <input class="form-control form-control-navbar" v-model="termoPesquisa" type="search" placeholder="Pesquisar..." aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </ul>
        <ul class="navbar-nav ml-auto">
            <b-nav-item-dropdown id="dropdown-1" right size="sm" :text="user.name">
                <b-dropdown-item :to="{ name: 'user', params: {id: user.id}}">
                    <i class="fas fa-user-circle"></i> Meu Perfil
                </b-dropdown-item>
                <b-dropdown-item v-if="$auth.check()" href="#" @click.prevent="logout()">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </b-dropdown-item>
            </b-nav-item-dropdown>
        </ul>
    </nav>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    methods: {
        logout() {
                this.$auth
                    .logout({
                        makeRequest: true,
                        redirect: {name: 'login'},
                    });
            }
    },
    data() {
        return {
            termoPesquisa: ''
        }
    },
    computed: {
      ...mapGetters({
          user: 'auth/user',
        //   userPermissions: 'auth/userPermissions',
      }),
    },
}
</script>

<style>

</style>
