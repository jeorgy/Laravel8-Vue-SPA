<template>
    <div>
        <b-row>
            <b-col cols sm="12" md="10">
                <b-form-group label="Tarefa:" label-for="to_do">
                    <b-form-input v-model="to_do.to_do" id="to_do"
                        type="text" required placeholder="Descreva a tarefa"
                        ></b-form-input>
                </b-form-group>
            </b-col>
            <b-col cols sm="12" md="2">
                <b-form-group label="Completa?" label-for="completed">
                    <b-form-checkbox v-model="to_do.completed" name="completed" switch></b-form-checkbox>
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
        to_do: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            
        }
    },
    methods: {
        
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
