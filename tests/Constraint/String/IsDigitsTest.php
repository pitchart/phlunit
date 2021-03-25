<?php

namespace Tests\Pitchart\Phlunit\Constraint\String;

use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\String\IsDigits;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class IsDigitsTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var IsDigits
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new IsDigits();
    }

    public function test_successes_when_evaluate_digits_string()
    {
        $evaluation = $this->constraint->evaluate('1234567890', '', true);

        Check::that($evaluation)->isTrue();
    }

    public function test_fails_when_evaluate_non_digits_string()
    {
        $evaluation = $this->constraint->evaluate('1234567890a', '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $this->assertHasFailingMessage("Failed asserting that '1234567890a' is digits.", '1234567890a');
    }

}
