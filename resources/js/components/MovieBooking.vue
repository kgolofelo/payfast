<template>
    <div class="container">
        <div>
            <div v-if="loggedIn">
                <span class="text-info">Hi, {{ loggedInName }}</span>
                <hr class="border-light">
                <router-link to="/logout" class="small">Booking History</router-link>
                |
                <router-link to="/cancel-booking" class="small">Cancel a Booking</router-link>
                |
                <router-link to="/logout" class="small">Logout</router-link>
                <hr class="border-light">
            </div>
            <div v-else>
                Please
                <router-link to="/login">Login</router-link>
                or
                <router-link to="/registration">Register</router-link>
                to book seats.
                <hr class="border-light">
            </div>
            <div class="form-group row">
                <label>Cinema:</label>
                <select class="form-control" @change="getFilms($event)">
                    <option value="0">Select a Cinema</option>
                    <option v-for="item in cinemaLocations" :value='item.id'>{{ item.location_name }}</option>
                </select>
            </div>

            <div class="form-group row">
                <label>Film:</label>
                <select class="form-control" @change="getFilmTimes($event)">
                    <option value="0">Select a Film</option>
                    <option v-for="item in films" :value='item.id'>{{ item.film_name }}</option>
                </select>
            </div>

            <div class="form-group row">
                <label>Show Time:</label>
                <select class="form-control">
                    <option value="0">Select a Show Time</option>
                    <option v-for="item in filmShowTimes" :value='item.id'>{{ item.film_time }}</option>
                </select>
            </div>

            <div class="form-group row">
                <label>Number of seats:</label>
                <input type="text" name="numberOfSeats" class="form-control">
            </div>

            <div class="form-group row justify-content-center mt-1">
                <button class="btn btn-success">Book Ticket(s)</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                messageText: '',
                loggedIn: false,
                loggedInName: '',
                cinemaLocations: [{}],
                films: [{}],
                filmShowTimes: [{}]
            }
        },
        methods: {
            logout() {
                localStorage.removeItem('movie-token');
                localStorage.removeItem('display-name');
                this.$router.push('/');
            },
            getCinemaLocations() {
                axios.get('/api/cinema-locations')
                .then(function (response) {
                    this.cinemaLocations=response.data;
                }.bind(this));
            },
            getFilms(itemName) {
                axios.get('/api/films', {
                    params: {
                     cinema_location_id:itemName.target.value
                    }
                })
                .then(function (response) {
                    this.films=response.data;
                }.bind(this));
            },
            getFilmTimes(itemName) {
                axios.get('/api/film-show-times', {
                    params: {
                        film_id:itemName.target.value
                    }
                })
                .then(function (response) {
                    this.filmShowTimes=response.data;
                }.bind(this));
            }
        },
        created() {
            this.getCinemaLocations();
            if (localStorage.getItem('movie-token')) {
                this.loggedInName = localStorage.getItem('display-name');
                this.loggedIn = true;
            }
        }
    }
</script>

<style lang="scss">
    @import '~bootstrap/scss/bootstrap.scss';
    @import '~bootstrap-vue/src/index.scss';
</style>
