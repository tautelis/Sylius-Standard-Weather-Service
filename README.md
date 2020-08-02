<h1 align="center">Sylius Standard Edition</h1>

<p align="center">This is demo project for retrieving the products by location's relevant weather</p>

Installation
------------

```bash
$ docker-compose up
$ docker exec -it sylius-standard_php_1 sh
$ php bin/console sylius:install
```

Demo
---------------

Just add one of the constant value (sunny,rainy,snowy) to the `sylius_product.weather_type` column.
At the homepage you will see an input for the city. After the form is submitted related products will be shown.


Author
-------

Created by [Vytautas Koryzna](https://github.com/tautelis).
