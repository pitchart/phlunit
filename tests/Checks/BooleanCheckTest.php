<?php declare(strict_types=1);

namespace Tests\Pitchart\Phlunit\Checks;

use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\FluentCheck;
use Tests\Pitchart\Phlunit\CheckTestCase;

class BooleanCheckTest extends CheckTestCase
{
    public function test_assert_true()
    {
        Check::that(true)->isTrue();
    }

    public function test_assert_false()
    {
        Check::that(false)->isFalse();
    }

    protected function checkClass(): FluentCheck
    {
        return Check::that(true);
    }

}