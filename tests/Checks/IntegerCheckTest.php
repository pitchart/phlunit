<?php


namespace Tests\Pitchart\Phlunit\Checks;


use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;

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

    /**
     * @param $value
     */
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
}