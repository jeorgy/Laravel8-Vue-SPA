<template>
  <to-dos-table :to_dos="to_dos"></to-dos-table>
</template>

<script>
import toastsMixin from '../../mixins/toastsMixin'
import ToDosTable from './components/List.vue'
export default {
  components: {ToDosTable},
  mixins: [toastsMixin],
  data() {
    return {
        to_dos: [],
        breadcrumb: [{name: 'HOME', link: '/'}, {name: 'Lista de Tarefas'}],
    }
  },
  methods: {
    loadToDos(){
        axios.get('auth/to-dos')
            .then(({data}) => (this.to_dos = data.to_dos))
            .catch(e => {
            this.toastDanger('USUÁRIO NÃO TEM PERMISSÃO PARA VISUALIZAR ESSA PÁGINA!')
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

<style>

</style>