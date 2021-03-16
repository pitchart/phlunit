<?php


namespace Tests\Pitchart\Phlunit\Checks;


use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Exception as ExceptionConstraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Expect;

class DateTimeCheckTest extends TestCase
{
    public function test_fails_with_identifier_message()
    {
        Expect::after($this)->anException(ExpectationFailedException::class)->describedByAMessageContaining('toto');

        Check::that(new \DateTime())
            ->withMessage('toto')
            ->isSameDayAs(\DateTime::createFromFormat('Y-m-d','1983-04-28'));
    }

    public function test_checks_datetime_formats()
    {
        Check::that(new \DateTime())
            ->isSameDayAs(new \DateTime())
            ->isSameIgnoringMillis(new \DateTime())
        ;
        Check::that(\DateTime::createFromFormat('Y-m-d H:i:s','1983-04-28 00:30:45'))
            ->isSameTimeAs(\DateTime::createFromFormat('Y-m-d H:i:s','2021-04-28 00:30:45'));
    }

    public function test_checks_datetime_parts()
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s','1983-04-28 00:30:45');

        Check::that($date)
            ->hasYear(1983)
            ->hasMonth(4)
            ->hasDay(28)
            ->hasHours(0)
            ->hasMinutes(30)
            ->hasSeconds(45)
        ;
    }

    public function test_checks_date_is_before_expected()
    {
        Check::that(\DateTime::createFromFormat('Y-m-d','1983-04-28'))->isBefore(new \DateTime());
    }

    public function test_checks_date_is_after_expected()
    {
        Check::that(new \DateTime())->isAfter(\DateTime::createFromFormat('Y-m-d','1983-04-28'));
    }

    public function test_checks_date_is_between_two_dates()
    {
        Check::that(new \DateTime())
            ->withMessage('May this message be seen one day ...')
            ->isBetween(
                \DateTime::createFromFormat('Y-m-d','1983-04-28'),
                \DateTime::createFromFormat('Y-m-d','2121-02-10')
            )
        ;
    }

    public function test_fails_for_bad_datetime_comparisons()
    {
        Expect::after($this)->anException(ExpectationFailedException::class);

        Check::that(new \DateTime())
            ->isSameDayAs(\DateTime::createFromFormat('Y-m-d','1983-04-28'))
        ;
    }
}