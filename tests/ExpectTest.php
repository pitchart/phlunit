<?php

namespace Tests\Pitchart\Phlunit;

use Pitchart\Phlunit\Expect;
use PHPUnit\Framework\TestCase;

class ExpectTest extends TestCase
{
    public function test_expects_an_exception_will_be_thrown()
    {
        Expect::after($this)->anException();

        throw new \Exception();
    }

    public function test_expects_a_specific_exception_will_be_thrown()
    {
        Expect::after($this)->anException(\InvalidArgumentException::class);

        throw new \InvalidArgumentException();
    }

    public function test_expects_an_exception_will_be_thrown_with_a_message()
    {
        Expect::after($this)->anException()->describedBy('Exception message');

        throw new \Exception('Exception message');
    }

    public function test_expects_an_exception_will_be_thrown_with_a_message_matching_a_regex()
    {
        Expect::after($this)->anException()->describedByAMessageMatching('/^Exception/');

        throw new \Exception('Exception message');
    }

    public function test_expects_an_exception_will_be_thrown_with_a_message_containing_content()
    {
        Expect::after($this)->anException()->describedByAMessageContaining('message');

        throw new \Exception('An exception message with a part to match');
    }

    public function test_expects_an_exception_with_specific_code_will_be_thrown()
    {
        Expect::after($this)->anException()->havingCode(42);

        throw new \Exception("", 42);
    }

    public function test_expects_a_notice_will_be_triggered()
    {
        Expect::after($this)->aNotice();

        trigger_error("",E_USER_NOTICE);
    }

    public function test_expects_a_deprecation_will_be_triggered()
    {
        $this->markTestSkipped('Same kind of test that in PHPUnit unit tests suite, but failing here');
        Expect::after($this)->aDeprecation();

        trigger_error("", E_USER_DEPRECATED);
    }

    public function test_expecting_a_deprecation_will_trigger_deprecation_expectation_in_test_runner()
    {
        $this->markAsRisky();
        $testCase = $this->getMockBuilder(TestCase::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['expectDeprecation'])
            ->getMock();
        $testCase->expects($this->once())->method('expectDeprecation');

        Expect::after($testCase)->aDeprecation();
    }

    public function test_expects_a_warning_will_be_triggered()
    {
        Expect::after($this)->aWarning();

        trigger_error("", E_USER_WARNING);
    }

    public function test_expects_an_error_will_be_triggered()
    {
        Expect::after($this)->anError();

        trigger_error("", E_USER_ERROR);
    }
}
