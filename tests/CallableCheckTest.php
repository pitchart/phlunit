<?php


namespace Tests\Pitchart\Phlunit;

use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\ExceptionCheck;

class CallableCheckTest extends TestCase
{
    /**
     * @param callable $callable
     * @dataProvider resultCallableProvider
     */
    public function test_checks_that_executing_a_callable_returns_a_result(callable $callable)
    {
        Check::that($callable)->hasAResult();
    }

    public function resultCallableProvider()
    {
        yield from [
            'a closure' => [function (...$x) { returns(); }],
            'a method of an instantiated object' => [[new ReturningFixture(), 'returns']],
            'a function' => [__NAMESPACE__.'\returns'],
            'an invokable object' => [new ReturningFixture()],
            'a class name with static method array' => [[ReturningFixture::class, 'staticReturns']],
            'a class name with static method string' => [ReturningFixture::class . '::staticReturns'],
        ];
    }

    public function test_checks_that_executing_a_callable_with_arguments_returns_a_result()
    {
        Check::thatCall(function (...$args) { return $args; })
            ->with('one', 'or', 'more', 'arguments')
            ->hasAResult();
    }

    /**
     * @param callable $callable
     * @dataProvider exceptionCallableProvider
     */
    public function test_checks_an_exception_is_thrown_on_execution(callable $callable)
    {
        $check = Check::thatCall($callable)
            ->with('one', 'or', 'more', 'arguments')
            ->throws(\LogicException::class)
        ;
        Check::that($check)->isAnInstanceOf(ExceptionCheck::class);
    }

    public function exceptionCallableProvider()
    {
        yield from [
            'a closure' => [function (...$x) { throws(); }],
            'a method of an instantiated object' => [[new ThrowingFixture(), 'throws']],
            'a function' => [__NAMESPACE__.'\throws'],
            'an invokable object' => [new ThrowingFixture()],
            'a class name with static method array' => [[ThrowingFixture::class, 'staticThrows']],
            'a class name with static method string' => [ThrowingFixture::class . '::staticThrows'],
        ];
    }

}

function throws() {
    throw new \LogicException("tests passed", 42);
}

class ThrowingFixture
{
    public static function staticThrows()
    {
        throws();
    }

    public function throws()
    {
        throws();
    }

    public function __invoke()
    {
        throws();
    }
}

function returns()
{
    return 'result';
}

class ReturningFixture
{
    public static function staticReturns()
    {
        returns();
    }

    public function returns()
    {
        returns();
    }

    public function __invoke()
    {
        returns();
    }
}