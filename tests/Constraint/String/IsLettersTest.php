<?php

namespace Tests\Pitchart\Phlunit\Constraint\String;

use Pitchart\Phlunit\Constraint\String\IsLetters;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class IsLettersTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var IsLetters
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new IsLetters();
    }

    public function test_successes_when_evaluate_letters_string()
    {
        $this->assertTrue($this->constraint->evaluate('Azérty', '', true));
    }

    public function test_fails_when_evaluate_non_letters_string()
    {
        $this->assertFalse($this->constraint->evaluate('Azerty1', '', true));
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $this->assertHasFailingMessage("Failed asserting that 'Azerty1' is letters.", 'Azerty1');
    }
}
