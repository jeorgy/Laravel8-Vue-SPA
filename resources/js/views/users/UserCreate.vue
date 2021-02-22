<template>
  <div>
    <b-card
        border-variant="success"
        header="Novo Usuário"
        header-bg-variant="success"
        header-text-variant="white"
        align="left">
        <form-user :user="user"></form-user>
        <template #footer>
          <b-button @click="store()" class="float-right" variant="success">Adicionar</b-button>
        </template>
    </b-card>
  </div>
</template>

<script>
import FormUser from './components/Form.vue'
import toastsMixin from '../../mixins/toastsMixin'
export default {
  mixins: [toastsMixin],
  components: {FormUser},
  data() {
    return {
      user: {
        role_id: null,
        active: true
      },
      breadcrumb: [{name: 'HOME', link: '/'}, {name: 'NOVO USUÁRIO'}],
    }
  },
  methods: {
    store(){
        let self = this
        let dados = new FormData
        dados = this.montaDados(dados, this.user)
        axios.post('auth/users/store', dados, {headers: {'Content-Type': 'multipart/form-data'}})
            .then(({data}) => {
                this.toastSuccess(data.message)
                this.clearForm()
            })
            .catch(e => {
                if (e.response.status == 422){
                    this.errors = e.response.data.errors
                } else if (e.response.status == 402) {
                    this.toastDanger(e.response.data.message)
                }
            })
    },
    clearForm() {
        this.user.name ='',
        this.user.email ='',
        this.user.password ='',
        this.user.password_confirmation ='',
        this.user.role_id = null
        this.user.new_photo = null
    },
    montaDados(dados, user) {
            for (let key in user) {
                if (user[key] != null) {
                    if (typeof user[key] == 'Array') {
                        dados.append(`${key}[]`, user[key])
                    } else {
                        dados.append(key, user[key])
                    }
                }
            }
            return dados
        }
  },
  mounted() {
    this.$store.dispatch('updateBreadcrumbList', this.breadcrumb)
  },

}
</script>

<style>

</style>