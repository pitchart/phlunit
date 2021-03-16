<?php

namespace Tests\Pitchart\Phlunit\Constraint\DateTime;

use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\DateTime\IsSameDayAs;
use PHPUnit\Framework\TestCase;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class IsSameDayAsTest extends ConstraintTestCase
{
    use UniqueConstraint;
    /**
     * @var IsSameDayAs
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new IsSameDayAs(\DateTime::createFromFormat('Y-m-d H:i:s', '1983-04-28 00:30:01'));
    }

    public function test_successes_when_evaluate_prefixed_string()
    {
        $evaluation = $this->constraint->evaluate(\DateTime::createFromFormat('Y-m-d H:i:s', '1983-04-28 02:30:01'), '', true);

        Check::that($evaluation)->isTrue();
    }

    public function test_fails_when_evaluate_non_prefixed_string()
    {
        $evaluation = $this->constraint->evaluate(\DateTime::createFromFormat('Y-m-d H:i:s', '1983-04-29 00:30:02'), '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $this->assertHasFailingMessage("Failed asserting that 1983-04-29 is the same day as 1983-04-28.", \DateTime::createFromFormat('Y-m-d H:i:s', '1983-04-29 00:30:02'));
    }
}
