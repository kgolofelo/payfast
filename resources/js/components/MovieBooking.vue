<template>
    <div class="container">
        <div>
            <div v-if="loggedIn">
                <router-link to="/logout" class="small">Logout me out</router-link> |
                <router-link to="/cancel-booking" class="small">Cancel a Booking</router-link>
            </div>
            <div v-else>
                Please
                <router-link to="/login" class="small">Login</router-link>
                or
                <router-link to="/registration" class="small">Register</router-link>
                to book seats.
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                messageText: '',
                loggedIn: false
            }
        },
        methods: {
            logout() {
                localStorage.removeItem('movie-token');
                this.$router.push('/');
            }
        },
        created() {
            if (localStorage.getItem('movie-token')) {
                this.loggedIn = true;
            }
        }
    }
</script>

<style lang="scss">
    @import '~bootstrap/scss/bootstrap.scss';
    @import '~bootstrap-vue/src/index.scss';
</style>
