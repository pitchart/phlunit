<?php


namespace Tests\Pitchart\Phlunit;


use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Exception as ExceptionConstraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;

class DateTimeCheckTest extends TestCase
{
    public function test_fails_with_identifier_message()
    {
        try {
            Check::that(new \DateTime())
                ->withMessage('toto')
                ->isSameDayAs(\DateTime::createFromFormat('Y-m-d','1983-28-04'))
            ;
        } catch (ExpectationFailedException $exception) {
            Assert::assertRegExp('/toto/', $exception->getMessage());
        }
    }

    public function test_checks_datetime_formats()
    {
        Check::that(new \DateTime())
            ->isSameDayAs(new \DateTime())
            ->isSameIgnoringMillis(new \DateTime())
        ;
    }

    public function test_fails_for_bad_datetime_comparisons()
    {
        try {
            Check::that(new \DateTime())
                ->isSameDayAs(\DateTime::createFromFormat('Y-m-d','1983-28-04'))
            ;
        } catch (ExpectationFailedException $exception) {
            Assert::assertThat($exception, new ExceptionConstraint(ExpectationFailedException::class));
        }
    }
}