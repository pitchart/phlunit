<?php

namespace Tests\Pitchart\Phlunit\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\SelfDescribing;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestFailure;
use Pitchart\Phlunit\Check;

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

        Check::that($reflection->implementsInterface(\Countable::class))
            ->withMessage(\sprintf(
                'Failed to assert that "%s" implements "%s".',
                $className,
                \Countable::class
            ))
            ->isTrue()
        ;
    }

    final public function test_is_self_describing(): void
    {
        $className = $this->className();

        $reflection = new \ReflectionClass($className);

        Check::that($reflection->implementsInterface(SelfDescribing::class))
            ->withMessage(\sprintf(
                'Failed to assert that "%s" implements "%s".',
                $className,
                SelfDescribing::class
            ))
            ->isTrue()
        ;
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

    protected function assertHasFailingMessage(string $message, $failingValue, $description = '')
    {
        try {
            $this->constraint->evaluate($failingValue, $description);
        } catch (ExpectationFailedException $e) {
            Check::that(TestFailure::exceptionToString($e))->isEqualTo(
                <<<EOF
$message

EOF
            );

            return;
        }

        $this->fail();
    }

    abstract public function test_fails_with_a_clear_and_complete_error_message();
}