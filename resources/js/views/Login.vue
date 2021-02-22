<template>
    <div class="row vh-100 justify-content-center">
        <b-col class="align-self-center" cols xs="11" sm="11" md="6" lg="4">
            <b-card
                border-variant="primary"
                header="Login"
                header-bg-variant="primary"
                header-text-variant="white"
                align="left"
            >
                <div class="alert alert-danger" v-if="has_error">
                    <b-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</b-card-text>
                </div>
                <form autocomplete="off" @submit.prevent="login" method="post">
                    <b-form-group label="E-mail" label-for="email" class="mb-2">
                        <b-form-input id="email" v-model="body.email"
                            placeholder="user@example.com"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group label="Senha" label-for="password" class="mb-2">
                        <b-form-input id="password" type="password" v-model="body.password"></b-form-input>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Login</b-button>
                </form>
            </b-card>
        </b-col>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        body:{
          email: 'root@root.com',
          password: '123456',
        },
        remember_me: false,
        has_error: false,
      }
    },
    mounted() {
      //
    },
    methods: {
      login() {
        try {
          this.$store.dispatch('auth/login', {
              body: this.body,
              redirect: {name: 'Home'},
              fetchUser: true,
              staySignedIn: this.remember_me,
              vm: this
          })
        } catch (error) {
          console.log('error')
        }
      }
    }
  }
</script>
<style scoped>
    .my-auto {
        margin-top: auto;
        margin-bottom: auto;
    }
</style>