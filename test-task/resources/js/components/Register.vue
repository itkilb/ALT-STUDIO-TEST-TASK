<template>
    <div class="register">
         <main class="form-signin">
            <form>
                <h1 class="h3 mb-3 fw-normal">Please create account</h1>

                <div class="form-floating">
                <input v-bind:class="{'is-invalid': NameError }" v-model="name" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingName">Name</label>
                <div class="invalid-feedback">
                    Please choose a name.
                </div>
                </div>

                <div class="form-floating mt-2">
                <input type="email" v-bind:class="{'is-invalid': EmailError }" v-model="email" class="form-control" id="floatingInput" placeholder="name@example.com">
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

                <div class="form-floating mt-2">
                <input v-bind:class="{'is-invalid': PasswordError_C }" v-model="c_password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Re-enter password</label>
                <div class="invalid-feedback">
                    Passwords don't match
                </div>
                </div>

                </div>

                <button class="w-100 btn btn-lg btn-primary mt-4" type="button" v-on:click="Register" >Create</button>
                <p class="mt-5 mb-3 text-muted">© 2017–2021</p>
            </form>
        </main>
    </div>
</template>

<script>
export default {
  data() {
    return {
      InvalidAuth: false,
      NameError: false,
      PasswordError: false,
      PasswordError_C: false,
      EmailError: false,
      email: null,
      password: null,
      c_password: null,
      name: null,
    };
  },
  methods: {
    CheckForm() {
      if (this.name) {
        this.NameError = false;
        if (this.email) {
          this.EmailError = false;
          if (this.password) {
            this.PasswordError = false;
            if (this.password === this.c_password) {
              return true;
            } else {
              this.PasswordError_C = true;
            }
          } else {
            this.PasswordError = true;
          }
        } else {
          this.EmailError = true;
        }
      } else {
        this.NameError = true;
      }
    },
    Register() {
      if (this.CheckForm()) {
        axios.post('api/register', {
          email: this.email,
          password: this.password,
          c_password: this.c_password,
          name: this.name,

        }).then((response) =>{
          localStorage.token = response.data.data.token;
          this.$router.push('Location');
        })
            .catch((error) => {
              if (error) {
                this.EmailError = true;
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
