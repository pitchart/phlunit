<?php


namespace Tests\Pitchart\Phlunit;


use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;

class CallableCheckTest extends TestCase
{
    /**
     * @test
     */
    public function should_verify_callable_exceptions_for_functions()
    {
        Check::thatCall(function (...$x) { throw new \LogicException("tests passed", 42); })
            ->with('one', 'or', 'more', 'arguments')
            ->throws(\LogicException::class)
            ->withMessage('tests passed')
            ->withCode(42)
            ->onExecute()
        ;
    }

    /**
     * @test
     */
    public function should_verify_callable_exceptions_for_array_callbacks()
    {
        $callable = new class {
            public function throws(...$x) { throw new \LogicException("tests passed", 42); }
        };

        Check::thatCall([$callable, 'throws'])
            ->with('one', 'or', 'more', 'arguments')
            ->throws(\LogicException::class)
            ->withMessage('tests passed')
            ->withCode(42)
            ->onExecute();
    }
}