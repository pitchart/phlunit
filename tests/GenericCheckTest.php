<?php


namespace Tests\Pitchart\Phlunit;


use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;

class GenericCheckTest extends TestCase
{
    public function test_should_respect_equality()
    {
        $sut = new \stdClass();
        $sut->foo = 'bar';

        Check::that($sut)->isEqualTo($sut);
    }

    public function test_should_respect_inequality()
    {
        $sut = new \stdClass();
        $sut->foo = 'bar';

        $expected = new \stdClass();
        $expected->foo = 'baz';

        Check::that($sut)->isNotEqualTo($expected);
    }

    public function test_should_respect_empty()
    {
        Check::that(null)->isEmpty();
    }

    /**
     * @param $value
     */
    public function test_should_respect_not_empty()
    {
        Check::that(new \stdClass())->isNotEmpty();
    }

}