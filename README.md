## Introduction

The Movie Booking System has been developed using Laravel 7.22.  I decided to use Laravel Passport for the API authentication and routing. 

The authentication between the API and the Front-end is maintained by a token, 
which gets assigned a scope based on the user’s role(admin or customer).

VUE has been used for the front-end because of its small size -
it has little impact on Laravel’s architecture, it almost just plugs in. The system has also benefited from VUE’s efficient data binding and routing when 
rendering the components onto a Web browser.

Laravel's database migration and seeder have been setup to create all the necessary tables and movie data that is required to book a seat.

## Setup Guide
#### Step 1
 Clone or download this repository

#### Step 2
 Inside the project root directory, COPY .env.example to .env

#### Step 3
 Create a database name of your choice, in your database server.

#### Step 4
Add database configurations found in .env file. Fields to configure; DB_DATABASE, DB_USERNAME, DB_PASSWORD

#### Step 5
In the project’s root level, run the following commands to setup the required packages, modules and data:
  1. composer install
  2. php artisan key:generate
  3. npm install
  4. php artisan migrate
  5. php artisan db:seed
  6. php artisan passport:client --personal (Hit enter when asked 'What should we name the personal access client? ')
  7. php artisan passport:install
  8. npm run watch

#### Step 6
Open a new terminal in the project's root folder, run php artisan serve and click on the server link that gets displayed.
