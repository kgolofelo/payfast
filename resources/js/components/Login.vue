<template>
    <div class="container">
        <div class="row mt-1">
            <form @submit.prevent="login" @keydown="form.onKeydown($event)">
                <div class="form-group row">
                    <label>E-Mail Address:</label>
                    <input v-model="form.email" id="email" type="email" name="email" value="" required="required"
                           autocomplete="email" autofocus="autofocus" class="form-control ">
                </div>
                <div class="form-group row">
                    <label>Password:</label>
                    <input v-model="form.password" id="password" type="password" name="password" required="required"
                           autocomplete="current-password" class="form-control ">
                </div>
                <div class="row justify-content-center mb-0">
                    <button type="submit" class="btn btn-primary mr-1">
                        Login
                    </button>
                    <span class="alert-info">{{ messageText }}</span>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                messageText: '',
                form: new Form({
                    email: '',
                    password: ''
                })
            }
        },
        methods: {
            login() {
                this.form.post('api/login')
                    .then((response) => {
                        localStorage.setItem('movie-token', response.data.token);
                        this.$router.push('/');
                    })
                    .catch((error) => {
                        console.log(error);
                        this.messageText = 'Incorrect username/password.';
                    });
            }
        }
    }
</script>
