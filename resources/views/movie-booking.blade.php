<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Movie Booking</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-1">
            <div class="card">
                <div class="card-header text-center">
                    <span>Movie Booking</span>
                </div>
                <div class="card-body">
                    <div id="app">
                        <router-view></router-view>
                    </div>
                    <hr class="border-light">
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('/js/app.js') }}"></script>
</html>
