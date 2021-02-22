<template>
        <to-dos-table @updatedToDos="loadToDos()" :to_dos="to_dos"></to-dos-table>
</template>
<script>
import ToDosTable from './toDoList/components/List.vue'
import {mapGetters} from 'vuex'
export default {
    components: {ToDosTable},
    data() {
        return {
            breadcrumb: [{name: 'HOME'}],
            to_dos: []
        }
    },
    computed: {
        ...mapGetters('auth', {
            user: 'user'
        })
    },
    methods: {
        logout() {
            this.$auth
                .logout({
                    makeRequest: true,
                    redirect: {name: 'login'},
                });
        },
        loadToDos(){
            axios.get('auth/to-dos/not-completed')
                .then(({data}) => (this.to_dos = data.to_dos))
                .catch(e => {
                this.toastDanger('ERRO AO CARREGAR LISTA DE TAREFAS!')
                })
        },
    },
    mounted() {
        this.$store.dispatch('updateBreadcrumbList', this.breadcrumb)
    },
    created() {
        this.loadToDos()
    }
}
</script>