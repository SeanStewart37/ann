# Artificial Neural Network Demo

This is a RESTful API using Laravel 5.2.x framework and FANN (Fast Artificial Neural Network) library.
The project uses JSON Web Tokens for stateless authorization and follows [JSend Specs](https://labs.omniti.com/labs/jsend) for all responses.

The neural network trains on picking a child's favorite toy by their gender and age. Trained data is already included, however you can also retrain the neural network with your own configuration parameters.

## Installation ##
This project uses Composer to install dependencies. You will also need to install the [Fast Artificial Neural Network](http://leenissen.dk/fann/wp/) library.
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

Excluding `/authorization` and `/ann/analyze`, all endpoints require an Authorization header with a Bearer token (JSON Web Token).
There's a default user created within the seeder file.  Email is `user@gmail.com`, password is `password`.
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
PUT /children/:id #params: toy_id
```

**Toys Endpoint**
```
GET /toys
GET /toys/:id
PUT /toys/:id #params: name
POST /toys #params: name
```

**ANN Endpoint**
```
POST /ann/train #params: max_iterations, layers, hidden_neurons, max_timeout
POST /ann/analyze #params: gender, age
GET /ann/accuracy
```

