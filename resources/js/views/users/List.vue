<template>
    <div id="main">
        <b-card border-variant="success"
                header-bg-variant="success"
                header-text-variant="white">
            <template #header>
                <h3 class="card-title">Lista de Usuários</h3>
                <div class="card-tools">
                <input class="form-control" v-model="filters['name']" placeholder="Nome, E-mail">
                </div>
            </template>
          <b-card-body>
            <div class="table-responsive">
              <b-table
              :head-variant="'dark'"
              :bordered="true"
              :hover="true"
              id="table-users"
              :items="filtered"
              :per-page="perPage"
              :fields="fields"
              :current-page="currentPage">
                <template v-slot:cell(name)="data">
                    <router-link
                        :to="{ name: 'user', params: {id: data.item.id}}">
                            <img :src="data.item.photo" width="50px" class="img-circle elevation-2 mr-2" alt="User Image">
                            {{ data.item.name }}
                            <b-badge v-if="!data.item.active" title="Usuário inativo" class="ml-2" variant="danger">
                                <i class="fa fa-user-slash"></i>
                            </b-badge>
                    </router-link>
                </template>
                <template v-slot:cell(role)="data">
                    <span v-for="role in data.item.roles" :key="role.name">{{role.name.toUpperCase()}}</span>
                </template>
                <template v-slot:cell(acoes)="data">
                    <b-button variant="success" @click="showModalUpdateUser(data.item.id)"><i class="fas fa-edit fa-fw"></i></b-button>
                    <b-button v-if="userPermissions.includes('delete_users')" variant="danger" @click="showModalDeleteUser(data.item.id)"><i class="fas fa-trash fa-fw"></i></b-button>
                </template>
              </b-table>
            </div>
          </b-card-body>
          <template #footer>
            <b-pagination class="justify-content-center"
              v-model="currentPage"
              :total-rows="rows"
              :per-page="perPage"
              aria-controls="table-users"></b-pagination>
          </template>
      </b-card>
      <b-modal :size="modal_size" scrollable
            v-model="show_modal"
            id="modal-pagina-usuario"
            :title="modal_title"
            :header-bg-variant="modal_variant"
            header-text-variant="light">
            <UserForm v-if="modal_action === 'update_user'" :user="update_user" />
            <h3 v-if="modal_action === 'delete_user'" class="text-center">{{delete_user.name}}</h3>
            <template v-slot:modal-footer>
                <div class="w-100">
                <b-button
                    variant="secondary"
                    size="sm"
                    @click="show_modal=false">
                    Fechar
                </b-button>
                <b-button
                    :variant="modal_variant"
                    class="float-right"
                    size="sm"
                    @click="modal_function">
                    {{button_action_text}}</b-button>
                </div>
            </template>
        </b-modal>
  </div>
</template>
<script>
  import UserForm from './components/Form.vue'
  import toastsMixin from '../../mixins/toastsMixin'
  import {mapGetters} from 'vuex'
  export default {
    mixins: [toastsMixin],
    components: {UserForm},
    data() {
      return {
        filters: {
          name: ''
        },
        perPage: 10,
        currentPage: 1,
        options: [],
        users: [],
        roles: [],
        fields: [
            { key: "name", label: "Nome", sortable: true },
            { key: "email", label: "Email" },
            { key: "role", label: "Perfil" },
            { key: "created_at", label: "Usuário Desde" },
            { key: "acoes", label: "Ações" }
        ],
        breadcrumb: [{name: 'HOME', link: '/'}, {name: 'USUÁRIOS'}],
        show_modal: false,
        modal_title: '',
        modal_size: '',
        modal_action: '',
        modal_variant: '',
        modal_function: null,
        button_action_text: '',
        update_user: {},
        delete_user: {}
      }
    },
    methods: {
        loadUsers(){
            axios.get('auth/users')
                .then(({data}) => (this.users = data.users))
                .catch(e => {
                this.toastDanger('USUÁRIO NÃO TEM PERMISSÃO PARA VISUALIZAR ESSA PÁGINA!')
                })
        },
        loadRoles(){
            axios.get('auth/roles')
                .then(({data}) => (this.roles = data.roles))
        },
        showModalUpdateUser(id) {
                this.update_user = this.users.find(user => user.id === id)
                this.update_user.role_id = this.update_user.roles[0].id
                this.show_modal = true
                this.modal_title = 'Editar dados do Usuário'
                this.modal_size = 'xl'
                this.modal_action = 'update_user'
                this.modal_variant = 'success'
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
        showModalDeleteUser(id) {
            this.delete_user = this.users.find(user => user.id === id)
            this.show_modal = true
            this.modal_title = 'Excluir Usuário?'
            this.modal_size = 'sm'
            this.modal_action = 'delete_user'
            this.modal_variant = 'danger'
            this.button_action_text = 'Deletar'
            this.modal_function = this.deleteUser
        },
        deleteUser() {
            axios.post(`/auth/users/destroy/${this.delete_user.id}`)
            .then(({data}) => {
                this.show_modal = false
                this.toastSuccess(data.message)
                this.loadUsers()
                this.delete_user = {}
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
    created(){
        this.loadUsers()
    },
    mounted() {
      this.$store.dispatch('updateBreadcrumbList', this.breadcrumb)
    },
    computed: {
        rows() {
            return this.filtered.length
        },
        filtered () {
            const filtered = this.users.filter(user => {
            return user.name.includes(this.filters.name) ||
                    user.email.includes(this.filters.name.toLowerCase())
            })
            return filtered.length > 0 ? filtered : [{
            name: ''
            }]
        },
        ...mapGetters('auth', {
            user: 'user',
            userPermissions: 'userPermissions'
        })
    }
  }
</script>