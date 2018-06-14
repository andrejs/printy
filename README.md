# Printy API

This tiny Printy API exposes several endpoints to create, list products and fetch price quotes. API supports client geocoding and request rate limiting for quote creation.

[![Build Status](https://travis-ci.org/andrejs/printy.svg?branch=develop)](https://travis-ci.org/andrejs/printy)

# Product endpoints

| Endpoint | Description |
| -------- | ----------- |
| ``GET /api/product`` | List all products |
| ``POST /api/product`` | Create a new product |

# Quote endpoints

| Endpoint | Description |
| -------- | ----------- |
| ``GET /api/quote`` | List all stored quotes |
| ``GET /api/quote/{productType}`` | List quotes matching product type |
| ``POST /api/quote`` | Calculate and store a new product quote |

All requests with payload examples are provided in POSTMAN collection ``postman.zip`` of project root folder.

# Deployment

It is recommended to run the API via Laravel Homestead environment.

* clone repository into desired workspace location
  - ``git clone https://github.com/andrejs/printy.git``
* edit ``Homestead.yaml`` in your homestead repo and add:
```
folders:
    - map: <local folder>/printy
      to: /home/vagrant/printy

sites:
    - map: printy.vm
      to: /home/vagrant/printy/public

databases:
    - printy
    - testing
```
* ``cd <local folder>``
* ``homestead up && homestead ssh``
* ``cd ./printy/``
* ``composer install``
* ``php artisan migrate:refresh``
* ``php artisan db:seed``

Replace ``<local folder>`` with printy local git repo location.

# Config

There is custom Laravel configuration file exposed, where rate limiter, geocoder and other limits can be defined. See ``config/custom.php``.

# Usage

Use POSTMAN with provided ``postman.zip`` collection and environment to access all endpoints.
Alternatively point browser to http://printy.vm to see welcome page and browse ``GET`` product and quote endpoints.

# Tests

* go to project folder
* ``homestead ssh``
* ``cd ./printy/``
* ``./vendor/bin/phpunit``
