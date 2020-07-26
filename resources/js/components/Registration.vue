<template>
    <div class="container">
        <div class="row justify-content-center"><span>Please register to book seats.</span></div>
        <div>
            <form @submit.prevent="saveRegistration" @keydown="form.onKeydown($event)">
                <div class="form-group row">
                    <label for="name">Name:</label>
                    <input v-model="form.name" id="name" type="text" name="name" value="" required="required"
                           autocomplete="name" autofocus="autofocus" class="form-control">
                </div>
                <div class="form-group row">
                    <label for="email">E-Mail Address:</label>
                    <input v-model="form.email" id="email" type="email" name="email" value="" required="required"
                           autocomplete="email" class="form-control ">
                </div>
                <div class="form-group row">
                    <label for="password">Password:</label>
                    <input v-model="form.password" id="password" type="password" name="password" required="required"
                           autocomplete="new-password" class="form-control ">
                </div>
                <div class="form-group row">
                    <label for="password-confirm">Confirm Password:</label>
                    <input v-model="form.password_confirmation" id="password-confirm" type="password"
                           name="password_confirmation" required="required" autocomplete="new-password"
                           class="form-control">
                </div>
                <div class="justify-content-center row mb-0">
                    <button type="submit" class="btn btn-primary mr-1">
                        Register
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
                    name: '',
                    email: '',
                    role: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                })
            }
        },
        methods: {
            saveRegistration() {
                this.form.post('api/register')
                    .then((response) => {
                        localStorage.setItem('movie-token', response.data.token);
                        this.$router.push('/');
                    })
                    .catch((error) => {
                        console.log(error);
                        this.messageText = 'Could not save registration.';
                    });
            }
        }
    }
</script>
