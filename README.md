[![Build Status](https://travis-ci.com/pitchart/phlunit.svg?branch=master)](https://travis-ci.com/pitchart/phlunit)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pitchart/phlunit/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pitchart/phlunit/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pitchart/phlunit/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pitchart/phlunit/?branch=master)

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

// Collection checks
Check::that([0, 1, 2])
    ->isACollectionOf('integer')
    ->hasElementAt(1)
    ->and->hasNoElementAt(12)
    ->hasLength(3)
    ->hasNotLength(12)
    ->contains(1, 2)
    ->isSubsetOf(0, 1, 2, 3, 4)
    ->containsNoDuplicateItem()
;

// PSR-7 ResponseInterface checks
$response = (new Response(200))
    ->withHeader('xxx-header', 'xxx-header-value')
    ->withBody(Utils::streamFor('{"name": "Batman", "city": "Gotham City"}'))
;

Check::that($response)
    ->asJson()
        ->matchesSchema(['type' => 'object', 'required' => ['name'], 'properties' => ['name' => ['type' => 'string']]]);
```

`Phlunit` provides checks for the following types and classes :
 - string
 - boolean
 - integer
 - float
 - array
 - iterable
 - callable
 - Throwable
 - ResponseInterface (PSR-7)
 - DateTimeInterface

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