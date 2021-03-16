<?php declare(strict_types=1);

namespace Tests\Pitchart\Phlunit\Checks;

use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\FloatCheck;
use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Checks\FluentCheck;
use Tests\Pitchart\Phlunit\CheckTestCase;

class FloatCheckTest extends CheckTestCase
{

    public function test_should_respect_equality()
    {
        Check::that(1.5)->isEqualTo(1.5);
    }

    public function test_should_respect_inequality()
    {
        Check::that(1.5)->isNotEqualTo(2);
    }

    public function test_should_respect_empty()
    {
        Check::that(0.)->isEmpty();
    }

    /**
     * @param $value
     */
    public function test_should_respect_not_empty()
    {
        Check::that(1.52)->isNotEmpty();
    }

    public function test_should_respect_comparisons()
    {
        Check::that(1.5)
            ->isGreaterThan(0)
            ->isGreaterThanOrEqualTo(1.5)
            ->isLessThan(2)
            ->isLessThanOrEqualTo(1.5)
        ;
    }

    public function test_equality_with_delta()
    {
        Check::that(1.5)->withDelta(0.5)->isEqualTo(2);
        Check::that(1.5)
            ->withDelta(0.2)->isNotEqualTo(2)
            ->and->strictly()->isNotEqualTo(1.6)
        ;
    }

    public function checkClass(): FluentCheck
    {
        return Check::that(4.2);
    }


}
