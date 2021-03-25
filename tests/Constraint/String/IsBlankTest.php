<?php

namespace Tests\Pitchart\Phlunit\Constraint\String;

use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\String\IsBlank;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class IsBlankTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var IsBlank
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new IsBlank();
    }

    /**
     * @param string $string
     * @dataProvider blankStringsProvider
     */
    public function test_succeeds_when_evaluates_blank_string(string $string)
    {
        $evaluation = $this->constraint->evaluate('', '', true);

        Check::that($evaluation)->isTrue();
    }

    public function blankStringsProvider()
    {
        yield from [
            'empty string' => [''],
            'blanks caracters string' => [" \n\r\t\v\0"]
        ];
    }

    public function test_fails_when_evaluate_non_digits_string()
    {
        $evaluation = $this->constraint->evaluate(" 12345\n67890a\0", '', true);

        Check::that($evaluation)->isFalse();
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $this->assertHasFailingMessage("Failed asserting that '123 456 7890a' is blank.", '123 456 7890a');
    }

}
