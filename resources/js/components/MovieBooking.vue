<template>
    <div class="container">
        <div>
            <div v-if="loggedIn">
                <span class="text-info">Hi, {{ loggedInName }}</span>
                <hr class="border-light">
                <router-link to="/booking-history" class="small">Booking History</router-link>
                |
                <router-link to="/booking-cancel" class="small">Cancel a Booking</router-link>
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
            <form @submit.prevent="saveBooking" @keydown="form.onKeydown($event)">
                <div class="form-group row">
                    <label>Cinema:</label>
                    <select v-model="form.cinema_location_id" class="form-control" @change="getFilms($event)">
                        <option value="0">Select a Cinema</option>
                        <option v-for="item in cinemaLocations" :value='item.id'>{{ item.location_name }}</option>
                    </select>
                </div>

                <div class="form-group row">
                    <label>Film:</label>
                    <select v-model="form.film_id" class="form-control" @change="getFilmTimes($event)">
                        <option value="0">Select a Film</option>
                        <option v-for="item in films" :value='item.id'>{{ item.film_name }}</option>
                    </select>
                </div>

                <div class="form-group row">
                    <label>Show Time:</label>
                    <select v-model="form.film_show_time_id" class="form-control">
                        <option value="0">Select a Show Time</option>
                        <option v-for="item in filmShowTimes" :value='item.id'>{{ item.film_time }}</option>
                    </select>
                </div>

                <div class="form-group row">
                    <label>Number of seats:</label>
                    <input v-model="form.number_of_seats" type="text" name="numberOfSeats" class="form-control">
                </div>

                <div class="form-group row justify-content-center mt-1">
                    <button class="btn btn-success">Book Ticket(s)</button>
                </div>
                <div class="form-group row justify-content-center mt-1">
                    {{ messageText }}
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
                loggedIn: false,
                loggedInName: '',
                cinemaLocations: [{}],
                films: [{}],
                filmShowTimes: [{}],
                form: new Form({
                    cinema_location_id: 0,
                    film_id: 0,
                    film_show_time_id: 0,
                    number_of_seats: 0,
                }),
                bookingResponse: ''
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
            },
            saveBooking() {
                this.form.post('api/save-booking',
                    {
                        headers: {
                            'Authorization' : 'Bearer ' + localStorage.getItem('movie-token')
                        }
                    })
                .then((response) => {
                    this.bookingResponse = response.data
                    this.messageText = this.bookingResponse.message;
                })
                .catch((error) => {
                    this.messageText = 'Could not save booking.';
                });
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
