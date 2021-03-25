<?php

namespace Tests\Pitchart\Phlunit\Constraint\String;

use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\String\StartsWith;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class StartsWithTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var StartsWith
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new StartsWith('prefix');
    }

    public function test_successes_when_evaluate_prefixed_string()
    {
        $evaluation = $this->constraint->evaluate('prefixAzérty', '', true);

        Check::that($evaluation)->isTrue();
    }

    public function test_fails_when_evaluates_non_prefixed_string()
    {
        $evaluation = $this->constraint->evaluate('Azerty1', '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $this->assertHasFailingMessage("Failed asserting that 'Azerty1' starts with \"prefix\", ignoring case.", 'Azerty1');
    }

}
