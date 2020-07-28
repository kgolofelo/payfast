<template>
    <div class="container">
        <div class="text-info">
            {{ loggedInName }}'s booking cancellation.
        </div>
        <hr class="border-light">
        <router-link to="/" class="small">Book a seat</router-link>
        <hr class="border-light">
        <form @submit.prevent="cancelBooking">
            <div class="form-group row">
                <label>Booking Reference:</label>
                <input v-model="form.booking_reference" type="text" name="bookingReference" class="form-control">
            </div>
            <div class="justify-content-center row mb-0">
                <button type="submit" class="btn btn-primary mr-1">
                    Cancel Seat(s)
                </button>
                <span class="alert-info">{{ messageText }}</span>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loggedInName: '',
                messageText: '',
                form: new Form({
                    booking_reference: ''
                })
            }
        },
        methods: {
            cancelBooking() {
                this.form.put('api/booking-cancel',
                    {
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('movie-token')
                        }
                    })
                    .then((response) => {
                        this.messageText = response.data.message;
                    })
                    .catch((error) => {
                        this.messageText = 'Could not cancel booking.';
                    });
            }
        },
        created() {
            if (localStorage.getItem('movie-token')) {
                this.loggedInName = localStorage.getItem('display-name');
            }
        }
    }
</script>
