<template>
    <div id="main">
        <b-card border-variant="success"
                header-bg-variant="success"
                header-text-variant="white">
            <template #header>
                <h3 class="card-title">Lista de Tarefas</h3>
                <div class="card-tools">
                    <b-input-group>
                        <input class="form-control" v-model="filters.name" placeholder="Filtrar...">
                        <b-input-group-append>
                            <b-button variant="primary" @click="showModalNewToDo()">Nova Tarefa</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </div>
            </template>
            <b-card-body>
                <transition name="page" mode="out-in">
                    <div v-if="to_dos.length" class="table-responsive">
                        <b-table
                        :head-variant="'dark'"
                        :bordered="true"
                        :hover="true"
                        id="table-todos"
                        :items="filtered"
                        :per-page="perPage"
                        :fields="fields"
                        :current-page="currentPage">
                            <template v-slot:cell(to_do)="data">
                                {{data.item.to_do}}
                                <b-badge variant="success" class="ml-2" v-if="data.item.completed" title="Completa"><i class="fa fa-check"></i></b-badge>
                            </template>
                            <template v-slot:cell(user)="data">
                                <span v-if="data.item.user">{{data.item.user.name}}</span>
                            </template>
                            <template v-slot:cell(acoes)="data">
                                <b-row class="justify-content-center">
                                    <b-button class="ml-2" variant="success" @click="showModalUpdateToDo(data.item)"><i class="fas fa-edit fa-fw"></i></b-button>
                                    <b-button class="ml-2" v-if="userPermissions.includes('delete_users')" variant="danger" @click="showModalDeleteToDo(data.item)"><i class="fas fa-trash fa-fw"></i></b-button>
                                    <span class="ml-2" title="Completa?">
                                        <b-form-checkbox v-model="data.item.completed" name="completed" @change="completeToDo(data.item.id)" switch></b-form-checkbox>
                                    </span>
                                </b-row>
                            </template>
                        </b-table>
                    </div>
                    <b-alert v-else variant="success" show class="text-center">NENHUMA TAREFA PENDENTE</b-alert>
                </transition>
            </b-card-body>
            <template #footer>
                <b-pagination class="justify-content-center"
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="table-todos"></b-pagination>
            </template>
        </b-card>
        <b-modal :size="modal_size" scrollable
            v-model="show_modal"
            id="modal-pagina-usuario"
            :title="modal_title"
            :header-bg-variant="modal_variant"
            header-text-variant="light">
            <FormToDo v-if="modal_action === 'update_to_do'" :to_do="update_to_do" />
            <h3 v-if="modal_action === 'delete_to_do'" class="text-center">{{delete_to_do.to_do}}</h3>
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
import {mapGetters} from 'vuex'
import FormToDo from './Form.vue'
import toastsMixin from '../../../mixins/toastsMixin'
export default {
    components: {FormToDo},
    mixins: [toastsMixin],
    props: {
        to_dos: {
            type: Array,
            required: true
        }
    },
    data() {
    return {
        filters: {
        name: ''
        },
        perPage: 10,
        currentPage: 1,
        options: [],
        fields: [
            { key: "to_do", label: "Tarefa", sortable: true },
            { key: "user", label: "Usuário", sortable: true },
            { key: "created_at", label: "Data" },
            { key: "acoes", label: "Ações" }
        ],
        show_modal: false,
        modal_title: '',
        modal_size: '',
        modal_action: '',
        modal_variant: '',
        modal_function: null,
        button_action_text: '',
        update_to_do: {},
        delete_to_do: {}
    }
    },
    methods: {
        showModalNewToDo() {
            this.update_to_do.to_do = ''
            this.update_to_do.completed = false
            this.show_modal = true
            this.modal_title = 'Nova Tarefa'
            this.modal_size = 'lg'
            this.modal_action = 'update_to_do'
            this.modal_variant = 'success'
            this.button_action_text = 'Cadastrar'
            this.modal_function = this.newToDo
        },
        newToDo() {
            axios.post(`/auth/to-dos/store`, this.update_to_do)
                .then(({data}) => {
                    this.toastSuccess(data.message)
                    this.$emit('updatedToDos')
                    this.show_modal = false
                    this.update_to_do = {}
                })
                .catch(e => {
                    if (e.response) {
                        if (e.response.status == 422){
                            this.errors = e.response.data.errors
                        } else if (e.response.status == 402) {
                            this.toastDanger(e.response.data.message)
                        }
                    } else {
                        console.log(e)
                    }
                })
        },
        showModalUpdateToDo(to_do) {
                this.update_to_do.id = to_do.id
                this.update_to_do.to_do = to_do.to_do
                this.update_to_do.completed = to_do.completed
                this.show_modal = true
                this.modal_title = 'Editar dados da Tarefa'
                this.modal_size = 'lg'
                this.modal_action = 'update_to_do'
                this.modal_variant = 'success'
                this.button_action_text = 'Atualizar'
                this.modal_function = this.updateToDo
        },
        updateToDo() {
            axios.post(`/auth/to-dos/update/${this.update_to_do.id}`, this.update_to_do)
                .then(({data}) => {
                    this.toastSuccess(data.message)
                    this.$emit('updatedToDo')
                    this.show_modal = false
                    this.update_to_do = {}
                })
                .catch(e => {
                    if (e.response) {
                        if (e.response.status == 422){
                            this.errors = e.response.data.errors
                        } else if (e.response.status == 402) {
                            this.toastDanger(e.response.data.message)
                        }
                    } else {
                        console.log(e)
                    }
                })
        },
        showModalDeleteToDo(to_do) {
            this.delete_to_do.id = to_do.id
            this.delete_to_do.to_do = to_do.to_do
            this.show_modal = true
            this.modal_title = 'Excluir Tarefa?'
            this.modal_size = 'md'
            this.modal_action = 'delete_to_do'
            this.modal_variant = 'danger'
            this.button_action_text = 'Deletar'
            this.modal_function = this.deleteToDo
        },
        deleteToDo() {
            axios.post(`/auth/to-dos/destroy/${this.delete_to_do.id}`)
                .then(({data}) => {
                    this.show_modal = false
                    this.toastSuccess(data.message)
                    this.$emit('updatedToDos')
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
        completeToDo(id) {
            axios.post(`/auth/to-dos/completed/${id}`)
                .then(({data}) => {
                    this.toastSuccess(data.message)
                    this.$emit('updatedToDos')
                })
                .catch(e => {
                    if (e.response.status == 422){
                        this.errors = e.response.data.errors
                    } else if (e.response.status == 402) {
                        this.toastDanger(e.response.data.message)
                    }
                })
        }
    },
    computed: {
        rows() {
            return this.filtered.length
        },
        filtered () {
            const filtered = this.to_dos.filter(to_do => {
                return to_do.to_do.includes(this.filters.name)
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