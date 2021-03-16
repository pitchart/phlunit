[![Build Status](https://travis-ci.com/pitchart/phlunit.svg?branch=master)](https://travis-ci.com/pitchart/phlunit)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pitchart/phlunit/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pitchart/phlunit/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pitchart/phlunit/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pitchart/phlunit/?branch=master)

# Phlunit: PHP Fluent Unit Testing

`Check::that(tdd())->with($phlunit)->isAnInstanceOf(Awesomeness::class);`

__*Fluent assertions for phpunit.*__

## Why ?

`Phlunit` will make your tests:

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
use Pitchart\Phlunit\Check;

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
 - string, boolean, integer, float, array
 - xml and json formats
 - iterable
 - callable
 - Throwable
 - ResponseInterface (PSR-7)
 - DateTimeInterface

## Syntactic sugar

Improve readability using `that()` and `andThat()` methods :

```php
Check::thatCall([$spiderman, 'saveGotham'])->with('batman', 'superman')
    ->throws(\LogicException::class)
    ->that()->isDescribedBy("Sorry, we are not in the same univers!");

Check::that($batman->getFirstname())->isEqualTo('Bruce')
    ->andThat($batman->getLastname())->isEqualTo('Wayne');
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
class CustomClassCheck implements FluentCheck
{
    //...
}

// Register your custom checks for dedicated classes in phpunit's bootstrap file
Check::registerChecksFor(Custom::class, CustomClassChecks::class);

//
Check::that(Check::that(new Custom))->isAnInstanceOf(CustomClassChecks::class);
```

## Test data builder

`Phlunit` provides a simple and extensible way to implement the [test data builder pattern](http://www.natpryce.com/articles/000714.html).

Here is the recommended way to use it, to not break the fluent experience:

```php
use Pitchart\Phlunit\Builder;

class HeroBuilder extends Builder
{
    protected function __construct(array $arguments)
    {
        parent::__construct(Hero::class, $arguments);
    }
    
    public function build(): Hero
    {
        return $this->buildInstance();
    }
    
    public static function create(): self
    {
        return new self([
            'name' => 'Batman',
            'firstname' => 'Bruce',
            'lastname' => 'Wayne',
        ]);
    }
    
    public static function batman(): self
    {
        return self::create();
    }
}

// Use it in your test cases:
$batman = HeroBuilder::batman()->build();

$superman = HeroBuilder::create()
    ->withName('Superman')
    ->andFirstname('Clark')
    ->andLastname('Kent')
    ->build()
;
```

## Expect exceptions

`Phlunit` provides a fluent way to expect exception from your code, using the `Expect` class:

```php
use Pitchart\Phlunit\Expect;

public function test_an_exception_is_thrown()
{
    Expect::after($this)
        ->anException(\InvalidArgumentException)
        ->describedBy('An exception message')
        ->havingCode(42);
    
    // Act
}
```

## Credits

This package has been mainly inspired by [NFluent](http://www.n-fluent.net/) and [AssertJ](https://joel-costigliola.github.io/assertj/)

Thanks to [Bruno Boucard](https://github.com/boucardbruno) for the inspiration.

## Licence

The [MIT Licence](LICENCE.md)