# Artificial Neural Network Demo

This is a RESTful API using Laravel 5.2.x framework and FANN (Fast Artificial Neural Network) library.

The neural network trains on picking a child's favorite toy by their gender and age. Trained data is already included, however you can also retrain the neural network.

## Installation ##
This project uses Composer to install dependencies. You will also need to install FANN ( http://leenissen.dk/fann/wp/ ).
Optionally, you may install Sqlite or reconfigure the environment variables for your database of choice. Migration and seeder files are include.

```
git clone https://github.com/SeanStewart37/ann.git
cd ann
composer install
touch database/database.sqlite (optional)
php artisan migrate
php artisan db:seed
```

## REST Endpoints ##
There's an included Postman collection file.

**Authorization Endpoint**

Excluding `/authorization` and `/ann/analyze`, all endpoints require an Authorization header with a Bearer token (JSON Web Token)
```
POST /authorization #params: email, password
```
**Users Endpoint**
```
GET /users/me
```

**Children Endpoint**
```
GET /children #params: gender, age
```

**Toys Endpoint**
```
GET /toys
GET /toys/:id
```

**ANN Endpoint**
```
POST /ann/train
POST /ann/analyze #params: gender, age
```

