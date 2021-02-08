<?php

namespace Tests\Pitchart\Phlunit\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\SelfDescribing;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestFailure;

abstract class ConstraintTestCase extends TestCase
{
    /**
     * @var Constraint
     */
    protected $constraint;

    final public function test_is_countable(): void
    {
        $className = $this->className();

        $reflection = new \ReflectionClass($className);

        $this->assertTrue($reflection->implementsInterface(\Countable::class), \sprintf(
            'Failed to assert that "%s" implements "%s".',
            $className,
            \Countable::class
        ));
    }

    final public function test_is_self_describing(): void
    {
        $className = $this->className();

        $reflection = new \ReflectionClass($className);

        $this->assertTrue($reflection->implementsInterface(SelfDescribing::class), \sprintf(
            'Failed to assert that "%s" implements "%s".',
            $className,
            SelfDescribing::class
        ));
    }

    /**
     * Returns the class name of the constraint.
     */
    final protected function className(): string
    {
        return \preg_replace('/'.preg_quote("Tests", '/').'/', '',
            \preg_replace(
            '/Test$/',
            '',
            static::class
        ));
    }

    protected function assertHasFailingMessage(string $message, $failingValue)
    {
        try {
            $this->constraint->evaluate($failingValue);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
$message

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    abstract public function test_fails_with_a_clear_and_complete_error_message();
}