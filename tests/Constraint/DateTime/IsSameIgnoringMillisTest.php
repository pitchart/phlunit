<?php

namespace Tests\Pitchart\Phlunit\Constraint\DateTime;

use Pitchart\Phlunit\Constraint\DateTime\IsSameIgnoringMillis;
use PHPUnit\Framework\TestCase;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class IsSameIgnoringMillisTest extends ConstraintTestCase
{
    use UniqueConstraint;
    /**
     * @var IsSameIgnoringMillis
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new IsSameIgnoringMillis(
            \DateTime::createFromFormat('Y-m-d H:i:s', '1983-04-28 00:30:01')
        );
    }

    public function test_successes_when_evaluate_prefixed_string()
    {
        $this->assertTrue($this->constraint->evaluate(
            \DateTime::createFromFormat('Y-m-d H:i:s', '1983-04-28 00:30:01'),
            '', true)
        );
    }

    public function test_fails_when_evaluate_non_prefixed_string()
    {
        $this->assertFalse($this->constraint->evaluate(
            \DateTime::createFromFormat('Y-m-d H:i:s', '1983-04-28 00:30:02'),
            '', true)
        );
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $this->assertHasFailingMessage(
            "Failed asserting that 1983-04-28 00:30:02 is the same date and time than 1983-04-28 00:30:01.",
            \DateTime::createFromFormat('Y-m-d H:i:s', '1983-04-28 00:30:02')
        );
    }
}
