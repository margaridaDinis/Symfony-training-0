## Symfony training at Mall-Connect #0

Idea of “Recycle batteries” web application is to count amount of collected batteries. 
There is a box for used batteries and a computer near the box, with our web application. 
When someone brings old batteries – he throws them into the box and submit a form in application. 


## Task 1 // Create form to add new batteries

Form must contain fields: _Battery Type_, _Count_ and _Name_. 
_Name_ is not required field, even anonymous user can give us used batteries.
After form is submitted, the record about added batteries is stored in tha database.


## Task 2 // Create a page with statistics of collected batteries. 

There must be a table on this page with two columns: _Battery type_ and _Total count_


## Task3 // Write functional test

Test cases:

* Submit Battery form with **4 AA batteries**
* Submit Battery form with **3 AAA batteries**
* Submit Battery form with **1 AA battery**
* Open statistics page and check that **there are 2 rows in the table, with counts: AA – 5, AAA – 3**.



## Installation
``` bash
# composer install

# php bin/console doctrine:database:create

# php bin/console doctrine:migrations:migrate - -no-interaction

# php bin/console server:run
```

## Tests

``` bash
vendor/bin/phpunit
```
