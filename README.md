# Phlunit: PHP Fluent Unit Testing

`Check::that(tdd())->with($phlunit)->isAnInstanceOf(Awesomeness::class);`

Fluent assertions for phpunit.

## Why ?

Phlunit will make your tests:

- **fluent to write:** juste type `Check::that($sut)` and let auto-completion guide you.
- **fluent to read:** very close to plain English, making it easier for non-technical people to read test code.
- **fluent to troubleshoot:** every failing check throws an Exception with a clear message status to ease your TDD experience.
- **less error-prone:** no more confusion about the order of the "expected" and "actual" values.

## Installation
```bash
composer require --dev pitchart/phlunit
```

## Write checks

Write test cases and test methods as usual, just switch to `Check::that()` to write your assertions :

```php
$integers = [1, 2, 3, 4, 5, 42];
Check::that($integers)->contains(2, 3, 42);


$heroes = "Batman and Robin";
Check::that($heroes)
    ->startsWith("Batman")
    ->contains("Robin")
;
```

## Need more checks ?

### Use custom constraints

Write custom phpunit constraints and use them thanks to methods `is()`, `has()`, `isNot()` or `hasNot()` :

```php
class CustomConstraint extends Constraint
{
    //...
}

Check::that($sut)->is(new CustomConstraint());
```

### Create custom Check class

```php
class CustomClassCheck
{
    //...
}

// Register your custom checks for dedicated classes in phpunit's bootstrap file
Check::registerChecksFor(Custom::class, CustomClassChecks::class);

//
Check::that(Check::that(new Custom))->isAnInstanceOf(CustomClassChecks::class);
```


## Credits

This package has been mainly inspired by [NFluent](http://www.n-fluent.net/) and [AssertJ](https://joel-costigliola.github.io/assertj/)

Thanks to [Bruno Boucard](https://github.com/boucardbruno) for the inspiration.