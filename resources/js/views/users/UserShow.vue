<template>
    <b-row class="justify-content-md-center">
        <b-col cols="6">
            <b-card header="Dados do Usuário" border-variant="success" header-bg-variant="success">
                <b-card-body>
                    <template v-if="user != ''">
                        <img :src="user.photo" width="150px" class="img-circle elevation-2 mr-2 float-right" alt="User Image">
                        <p><b>Nome:</b> {{user.name}}</p>
                        <p><b>E-mail:</b> {{user.email}}</p>
                        <p><b>Perfil:</b> <span v-for="role in user.roles" :key="role.id">{{role.details}}</span></p>
                        <p><b>Usuário Desde:</b> {{user.created_at}}</p>
                        <p><b>Última Atualização:</b> {{user.updated_at}}</p>
                    </template>
                    <b-button variant="success" @click="showModalUpdateUser">Editar dados</b-button>
                </b-card-body>
            </b-card>
        </b-col>
        <b-modal size="xl" scrollable
            v-model="show_modal"
            id="modal-pagina-usuario"
            :title="modal_title"
            header-bg-variant="success"
            header-text-variant="light">
            <UserForm :user="update_user" />
            <template v-slot:modal-footer>
                <div class="w-100">
                <b-button
                    variant="secondary"
                    size="sm"
                    @click="show_modal=false">
                    Fechar
                </b-button>
                <b-button
                    variant="success"
                    class="float-right"
                    size="sm"
                    @click="modal_function">
                    {{button_action_text}}</b-button>
                </div>
            </template>
        </b-modal>
    </b-row>
</template>

<script>
import {mapGetters} from 'vuex'
import toastsMixin from '../../mixins/toastsMixin'
import UserForm from './components/Form.vue'
export default {
    mixins: [toastsMixin],
    components: {UserForm},
    props: ['id'],
    data() {
        return {
            breadcrumb: [],
            user:[],
            show_modal: false,
            modal_title: '',
            modal_function: null,
            button_action_text: '',
            update_user: {}
        }
    },
    methods: {
        loadUser(id){
            axios.get(`/auth/users/${id}`)
                .then(({data}) => {
                      this.user = data.user
                })
                .catch(e => {
                    this.toastDanger(e.response.data.message)
                })
        },
        showModalUpdateUser() {
            this.update_user = this.user
            this.show_modal = true
            this.modal_title = 'Editar dados do Usuário'
            this.button_action_text = 'Atualizar'
            this.modal_function = this.updateUser
        },
        updateUser() {
            let self = this
            let dados = new FormData
            dados = this.montaDados(dados, this.update_user)
            axios.post(`/auth/users/update/${this.update_user.id}`, dados, {headers: {'Content-Type': 'multipart/form-data'}})
              .then(({data}) => {
                  this.show_modal = false
                  this.toastSuccess(data.message)
                  this.loadUsers()
                  this.update_user = {}
              })
              .catch(e => {
                  if (e.response.status == 422){
                      this.errors = e.response.data.errors
                  } else if (e.response.status == 402) {
                      this.toastDanger(e.response.data.message)
                  }
              })
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
      this.loadUser(this.id)
    },
    watch: {
        user() {
            this.breadcrumb = []
            this.breadcrumb.push({name: 'HOME', link: '/'})
            if (this.userPermissions.includes('view_users')) {
                this.breadcrumb.push({name: 'USUÁRIOS', link: '/users'})
            }
            this.breadcrumb.push({name: this.user.name.toUpperCase()})
            this.$store.dispatch('updateBreadcrumbList', this.breadcrumb)
        }
    },
    computed: {
      ...mapGetters({
          userLoged: 'auth/user',
          userPermissions: 'auth/userPermissions',
      }),
    },
}
</script>

<style>

</style>
