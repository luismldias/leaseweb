
## Start up

### Run the containers

docker compose up

## To be executed from inside (ssh) the app container in the leaseweb folder

### Save the file .env.example in the leaseweb folder as .env


### Install dependencies from inside the app container:
composer install

### Create the database structure from inside the app container:
php artisan migrate

### Populate the database from the file from inside the app container:
php artisan db:seed

### App Access
Http://localhost



