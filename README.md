```php
Check::that($tdd)->with($phlunit)->isAnInstanceOf(Awesomeness::class);
```


#Phlunit: PHP Fluent Unit Testing

## Installation
```bash
composer require --dev pitchart/phlunit
```

## Write checks
```php
$integers = [1, 2, 3, 4, 5, 42];
Check::that($integers)->contains(2, 3, 42);


```