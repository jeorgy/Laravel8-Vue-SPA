<template>
    <div id="main" v-if="user">
        <Nav></Nav>
        <Sidebar :slideMenuItens="slideMenuItens"></Sidebar>
        <Content>
            <transition name="page" mode="out-in">
                <router-view></router-view>
            </transition>
        </Content>
        <Footer></Footer>
    </div>
    <div class="vh-100" v-else>
        <router-view></router-view>
    </div>
</template>
<script>
    import Sidebar from './views/layouts/Sidebar.vue'
    import Footer from './views/layouts/Footer.vue'
    import Nav from './views/layouts/Nav.vue'
    import Content from './views/layouts/Content.vue'
    import slideMenuItens from './lib/SlideMenuItens.js'
    import {mapGetters} from 'vuex'
    export default {
        components: {
            Sidebar,
            Footer,
            Nav,
            Content,
        },
        computed: {
            ...mapGetters('auth', {
                user: 'user'
            })
        },
        data() {
            return {
                slideMenuItens: slideMenuItens,
            }
        }
    }
</script>
<style>
  .page-enter-active, .page-leave-active {
    transition: opacity 0.5s, transform 0.5s;
  }
  
  .page-enter, .page-leave-to {
    opacity: 0;
  }

  .canvas {
    height: 100vh;
  }
</style>