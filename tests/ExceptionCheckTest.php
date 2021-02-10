<?php

namespace Tests\Pitchart\Phlunit;

use Pitchart\Phlunit\Check;
use PHPUnit\Framework\TestCase;

class ExceptionCheckTest extends TestCase
{
    public function test_checks_is_an_instance_of_exception_class()
    {
        Check::that(new \LogicException('logic exception', 200))->isAnInstanceOf(\LogicException::class);
    }

    public function test_checks_has_code()
    {
        Check::that(new \LogicException('logic exception', 200))->hasCode(200);
    }

    public function test_checks_the_exception_message_content()
    {
        Check::that(new \LogicException('logic exception', 200))->isDescribedBy('logic exception');
    }
}
