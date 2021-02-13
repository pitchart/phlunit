<?php


namespace Tests\Pitchart\Phlunit\Checks;


use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\DateTimeCheck;

class IntegerCheckTest extends TestCase
{
    public function test_should_respect_equality()
    {
        Check::that(1)->isEqualTo(1);
    }

    public function test_should_respect_inequality()
    {
        Check::that(1)->isNotEqualTo(2);
    }

    public function test_should_respect_empty()
    {
        Check::that(0)->isEmpty();
    }

    public function test_should_respect_not_empty()
    {
        Check::that(12)->isNotEmpty();
    }

    public function test_should_respect_comparisons()
    {
        Check::that(1)
            ->isGreaterThan(0)
            ->isGreaterThanOrEqualTo(1)
            ->isLessThan(2)
            ->isLessThanOrEqualTo(1)
        ;
    }

    public function test_converts_as_datetime_using_timestamp_value()
    {
        $expectedDate = \DateTime::createFromFormat('Y-m-d H:i:s', '1983-04-28 00:30:00');

        $check = Check::that(420337800)->asDateTime()
            ->isAnInstanceOf(\DateTimeInterface::class)
            ->isSameDayAs($expectedDate)
            ->isSameTimeAs($expectedDate)
        ;

        Check::that($check)->isAnInstanceOf(DateTimeCheck::class);
    }
}