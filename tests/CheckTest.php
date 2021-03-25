<?php

namespace Tests\Pitchart\Phlunit;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Count;
use PHPUnit\Framework\Constraint\Exception as ExceptionConstraint;
use PHPUnit\Framework\Constraint\GreaterThan;
use PHPUnit\Framework\Constraint\LessThan;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Checks\ArrayCheck;
use Pitchart\Phlunit\Checks\BooleanCheck;
use Pitchart\Phlunit\Checks\CallableCheck;
use Pitchart\Phlunit\Checks\CollectionCheck;
use Pitchart\Phlunit\Checks\FloatCheck;
use Pitchart\Phlunit\Checks\GenericCheck;
use Pitchart\Phlunit\Checks\DateTimeCheck;
use Pitchart\Phlunit\Checks\IntegerCheck;
use Pitchart\Phlunit\Checks\ResponseCheck;
use Pitchart\Phlunit\Checks\StringCheck;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Expect;
use Psr\Http\Message\ResponseInterface;
use Tests\Pitchart\Phlunit\Fixture\Custom;
use Tests\Pitchart\Phlunit\Fixture\CustomChecks;

class CheckTest extends TestCase
{
    public function test_can_register_assertions_for_a_given_class()
    {
        Check::registerChecksFor(Custom::class, CustomChecks::class);
        Check::that(Check::that(new Custom))->isAnInstanceOf(CustomChecks::class);
    }

    /**
     * @param $sut
     * @param $assertionClass
     * @dataProvider assertionMappingProvider
     */
    public function test_maps_checks_to_dedicated_assertions_on_call($sut, $assertionClass)
    {
        $check = Check::that($sut);

        Check::that($check)->isAnInstanceOf($assertionClass);
    }

    public function assertionMappingProvider()
    {
        yield from [
            'bool' => [true, BooleanCheck::class],
            'string' => ['sut', StringCheck::class],
            'numeric string' => ['42', StringCheck::class],
            'int' => [42, IntegerCheck::class],
            'float' => [4.5, FloatCheck::class],
            'array' => [[1, 2], ArrayCheck::class],
            'iterable' => [new \ArrayObject([1, 2]), CollectionCheck::class],
            'callable' => [function() { return 1; }, CallableCheck::class],
            ResponseInterface::class => [new Response(200), ResponseCheck::class],
            \DateTimeInterface::class => [new \DateTimeImmutable(), DateTimeCheck::class],
        ];
    }

    public function test_checks_for_types()
    {
        $resource = fopen('php://temp', 'r');
        Check::that(1)->isInt();
        Check::that('string')->isString();
        Check::that(1.)->isFloat();
        Check::that($resource)->isResource();
        Check::that('1')->isNumeric()->isScalar();
        Check::that([1])->isArray()->isIterable();
        Check::that(false)->isBool();
        Check::that(new \stdClass())->isObject()->isAnInstanceOf(\stdClass::class);
        Check::that(function ($x) { return $x; })->isCallable();

        fclose($resource);
    }

    public function test_has_syntactic_sugar_to_help_writing_close_to_plain_english_sentenses()
    {
        Check::that(1)->isGreaterThan(0)->and()->isLessThan(2);
        Check::that(function() {return 2;})->hasAResult()->which()->isLessThan(3);

        Expect::after($this)->anException(\Error::class)
            ->describedBy(sprintf('Call to undefined method %s::unavailableMethod()', IntegerCheck::class));

        Check::that(2)->isLessThan(3)->unavailableMethod()->isGreaterThan(1);
    }

    public function test_can_be_extended_using_constraints()
    {
        Check::that(2)->is(new GreaterThan(1))
            ->isNot(new LessThan(1));

        Check::that([1, 2, 3])->has(new Count(3))
            ->hasNot(new Count(4));
    }

}