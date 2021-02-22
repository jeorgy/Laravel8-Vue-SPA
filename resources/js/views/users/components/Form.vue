<template>
    <div>
        <b-row>
            <b-col cols sm="12" lg="4">
                <b-form-group label="Nome:" label-for="name">
                    <b-form-input v-model="user.name" id="name"
                        type="text" required placeholder="Informe o nome"
                        ></b-form-input>
                </b-form-group>
            </b-col>
            <b-col cols sm="12" lg="4">
                <b-form-group label="Email:" label-for="email">
                    <b-form-input v-model="user.email" id="email"
                        type="email" required placeholder="Informe o email"></b-form-input>
                </b-form-group>
            </b-col>
            <b-col cols sm="12" lg="4">
                <b-form-group label="Foto:" label-for="photo">
                    <b-form-file
                    v-model="user.new_photo"
                    placeholder="Selecione ou arraste uma imagem..."
                    drop-placeholder="Solte a imagem aqui..."
                    accept="image/jpeg, image/png, image/bmp"
                    browse-text="Foto"
                    @change="whereInputPhotoChange"
                ></b-form-file>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols sm="12" lg="4">
                <b-form-group label="Senha:" label-for="password">
                    <b-form-input v-model="user.password" id="password"
                        type="password" required placeholder="Informe uma senha"
                        ></b-form-input>
                </b-form-group>
            </b-col>
            <b-col cols sm="12" lg="4">
                <b-form-group label="Confirme a Senha:" label-for="password_confirmation">
                    <b-form-input v-model="user.password_confirmation" id="password_confirmation"
                        type="password" required placeholder="Confirme a Senha"></b-form-input>
                </b-form-group>
            </b-col>
            <b-col cols sm="12" lg="3" v-if="userPermissions.includes('add_users')">
                <b-form-group label="Perfil:" label-for="role_id">
                    <b-form-select
                        id="role_id"
                        v-model="user.role_id"
                        required>
                            <b-form-select-option :value="null">Selecione...</b-form-select-option>
                            <b-form-select-option v-for="(role, i) in roles" :key="i" :value="i">{{role}}</b-form-select-option>
                        </b-form-select>
                </b-form-group>
            </b-col>
            <b-col cols sm="12" lg="1" v-if="userPermissions.includes('add_users')">
                <b-form-group label="Ativo?" label-for="active">
                    <b-form-checkbox v-model="user.active" name="active" switch></b-form-checkbox>
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
import toastsMixin from '../../../mixins/toastsMixin'
export default {
    mixins: [toastsMixin],
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            roles: []
        }
    },
    methods: {
        loadRoles(){
            axios.get('/auth/roles')
                .then(({data}) => {
                    this.roles = data.roles
                })
                .catch(e => {
                    this.toastDanger(e.response.data.message)
                })
        },
        whereInputPhotoChange(event) {
            this.user.new_photo = event.target.files[0]
        },
    },
    mounted() {
        this.loadRoles()
    },
    computed: {
      ...mapGetters({
          userPermissions: 'auth/userPermissions',
      }),
    }
}
</script>

<style>

</style>
