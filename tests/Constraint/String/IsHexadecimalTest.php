<?php

namespace Tests\Pitchart\Phlunit\Constraint\String;

use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\String\IsHexadecimal;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class IsHexadecimalTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var IsHexadecimal
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new IsHexadecimal();
    }

    public function test_successes_when_evaluate_hexadecimal_string()
    {
        $evaluation = $this->constraint->evaluate('BADA55', '', true);

        Check::that($evaluation)->isTrue();
    }

    public function test_fails_when_evaluate_non_hexadecimal_string()
    {
        $evaluation = $this->constraint->evaluate('MADA55', '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_when_evaluate_empty_string()
    {
        $evaluation = $this->constraint->evaluate('', '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $this->assertHasFailingMessage("Failed asserting that 'MADA55' is hexadecimal.", 'MADA55');
    }
}
