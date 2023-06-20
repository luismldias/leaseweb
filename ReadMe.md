
## **Start up**

### Run the containers from the repo directory

docker compose up

*Both methods described below must be executed inside the container in the app folder*


## **Method 1 - Makefile**

make build

## **Method 2 - Manual steps**
### Save the file .env.example in the leaseweb folder as .env

cp .env.example .env

### Install dependencies from inside the app container:
composer install

### Create the database structure from inside the app container:
php artisan migrate

### Populate the database from the file from inside the app container:
php artisan db:seed

### App Access
Http://localhost


### Tests Execution

php artisan test



