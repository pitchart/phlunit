<?php declare(strict_types=1);

namespace Tests\Pitchart\Phlunit\Checks;

use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;

class BooleanCheckTest extends TestCase
{
    public function test_assert_true()
    {
        Check::that(true)->isTrue();
    }

    public function test_assert_false()
    {
        Check::that(false)->isFalse();
    }

}