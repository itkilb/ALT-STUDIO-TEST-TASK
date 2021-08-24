<template>
    <header class="site-header py-1">
    <nav class="navbar">
        <a class="navbar-brand" href="#">

                <img style="margin-left:10vh" src="https://blr.vue.community/logo.png?size=240" alt="" width="50" height="50">
                <a class="navbar-brand">Test App</a>

        </a>
        <form class="d-flex">
            <a v-if="login" style="margin-right:3vh" class="p-1 mr-2"><button type="button" @click="$router.push('Login')" class="btn btn-primary">Войти</button></a>
            <a v-if="token" style="margin-right:3vh" class="p-1 mr-2"><button type="button" v-on:click="logout" class="btn btn-primary">Выйти</button></a>
        </form>
    </nav>
    </header>
</template>

<script>
export default {
  name: 'Header',
  data() {
    return {
      login: true,
      token: false,
    };
  },
  methods: {
    logout() {
      axios.post('api/logout', {
        headers: {
          Authorization: 'Bearer ' + localStorage.token,
        },
      })
          .then(function(response) {
            localStorage.token = '';
            this.$router.push('/');
          })
          .catch(function(error) {
            console.log(error);
          });
    },
  },
  mounted() {
    if (localStorage.token) {
      this.token = true;
      this.login = false;
    }
  },

};
</script>

<style scoped>
.site-header {
    background-color: rgba(0, 0, 0, .85);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    backdrop-filter: saturate(180%) blur(20px);
}
.site-header a {
    color: #8e8e8e;
    transition: color .15s ease-in-out;
}
</style>
