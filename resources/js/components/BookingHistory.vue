<template>
    <div class="container">
        <div class="text-info">
            {{ loggedInName }}'s booking history.
        </div>
        <hr class="border-light">
        <router-link to="/" class="small">Go back to previous screen.</router-link>
        <div>
            <b-table sticky-header :items="bookingHistory" head-variant="light"></b-table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loggedInName: '',
                bookingHistory: [{}]
            }
        },
        created() {
            if (localStorage.getItem('movie-token')) {
                this.loggedInName = localStorage.getItem('display-name');

                axios.get('/api/booking-history', {
                    headers: {
                        'Authorization' : 'Bearer ' + localStorage.getItem('movie-token')
                    }
                })
                .then(function (response) {
                    this.bookingHistory=response.data;
                }.bind(this));
            }
        }
    }
</script>
