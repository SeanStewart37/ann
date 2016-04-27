# Artificial Neural Network Demo

This is a RESTful API using Laravel 5.2.x framework and FANN (Fast Artificial Neural Network) library.


## REST Endpoints ##
There's an included Postman collection file.

**Children Endpoint**
```
GET /children #params: gender, age
GET /children/:id
```

**Toys Endpoint**
```
GET /toys
GET /toys/:id
```

**ANN Endpoint**
```
POST /ann/train
POST /ann/test #params: gender, age
```

