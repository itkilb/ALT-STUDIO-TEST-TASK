<template>
    <div class="auth">
         <main class="form-signin">
            <b-form>
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                <div v-if="InvalidAuth" class="alert alert-danger" role="alert">
                Invalid username or password
                </div>
                <div class="form-floating">
                <input v-bind:class="{'is-invalid': EmailError }" v-model="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
                <div class="invalid-feedback">
                    Please choose a email.
                </div>

                </div>
                <div class="form-floating mt-2">
                <input v-bind:class="{'is-invalid': PasswordError }" v-model="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <div class="invalid-feedback">
                    Please choose a password.
                </div>
                </div>
                <router-link :to="'register'">Register</router-link>
                <button class="w-100 btn btn-lg btn-primary mt-4" type="button" v-on:click="Login" >Sign in</button>
                <p class="mt-5 mb-3 text-muted">© 2017–2021</p>
            </b-form>
        </main>
    </div>
</template>

<script>
export default {
  data() {
    return {
      InvalidAuth: false,
      PasswordError: false,
      EmailError: false,
      email: null,
      password: null,
    };
  },
  methods: {
    CheckForm: function() {
      this.InvalidAuth = false;
      if (this.email) {
        this.EmailError = false;
        if (this.password) {
          return true;
        } else {
          this.PasswordError = true;
        }
      } else {
        this.EmailError = true;
      }
    },
    Login: function() {
      if (this.CheckForm()) {
        axios.post('api/login', {
          email: this.email,
          password: this.password,
        }).then((response) =>{
          localStorage.token = response.data.data.token;
          // console.log(response.data.data.token);
          this.$router.push('Location');
        })
            .catch((error) => {
              if (error) {
                this.InvalidAuth = true;
              }
              console.log(error);
            });
      }
    },
  },
};
</script>

<style scoped>
.form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: auto;
}
.auth {
    height: 100vh;
    display: flex;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
}
</style>
