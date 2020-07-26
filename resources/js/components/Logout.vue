<template>
    <div class="container">
        <div class="row mt-1 justify-content-center">
            <div class="row col-md-8">
                Are you sure you want to logout... ??
            </div>
            <div class="row col-md-8">
                <a href="#" v-on:click="logout()" class="d-block">Yeah, log me out.</a>
            </div>
            <div class="row col-md-8">
                <router-link to="/" class="d-block">I'm not sure.</router-link>
            </div>
        </div>
        <hr class="border-light">
    </div>
</template>

<script>
    export default {
        methods: {
            logout() {
                localStorage.removeItem('movie-token');
                this.$router.push('/');
            }
        }
    }
</script>
