# Symfony training at Mall-Connect #0

Idea of “Recycle batteries” web application is to count amount of collected batteries. 
There is a box for used batteries and a computer near the box, with our web application. 
When someone brings old batteries – he throws them into the box and submit a form in application. 


### Task 1 // Create form to add new batteries

Form must contain fields: _Battery Type_, _Count_ and _Name_. 
_Name_ is not required field, even anonymous user can give us used batteries.
After form is submitted, the record about added batteries is stored in tha database.


### Task 2 // Create a page with statistics of collected batteries. 

There must be a table on this page with two columns: _Battery type_ and _Total count_


### Task3 // Write functional test

Test cases:

* Submit Battery form with **4 AA batteries** (1)
* Submit Battery form with **3 AAA batteries** (2)
* Submit Battery form with **1 AA battery** (3)
* Open statistics page and check that **there are 2 rows in the table, with counts: AA – 5, AAA – 3** (4-8)



## Installation
``` bash
# composer install

# php bin/console doctrine:database:create

# php bin/console doctrine:schema:update --force

# php bin/console server:run
```

## Tests

``` bash
 vendor/bin/simple-phpunit
```

### Resources

* [Symfony Documentation - Forms](http://symfony.com/doc/current/forms.html)
* [Symfony2 Jobeet: Testing your forms](http://www.ens.ro/2012/06/22/symfony2-jobeet-day-11-testing-your-forms/)
* [PHPUnit Documentation ](https://phpunit.de/manual/current/en/index.html)
* and my lovely husband to wrap it up