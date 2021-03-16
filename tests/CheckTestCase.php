<?php


namespace Tests\Pitchart\Phlunit;


use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Checks\FluentCheck;

abstract class CheckTestCase extends TestCase
{
    abstract public function checkClass(): FluentCheck;

    public function test_has_syntactic_sugar_that_that_returns_current_instance()
    {
        $check = $this->checkClass();
        Check::thatCall([$check, 'that'])->hasAResult()
            ->that()->isAnInstanceOf(get_class($this->checkClass()))
            ->isEqualTo($check)
        ;
    }

    public function test_has_syntactic_sugar_and_that_to_proceed_to_another_check()
    {
        Check::thatCall([$this->checkClass(), 'andThat'])->with('phlunit')
            ->hasAResult()->that()->isAnInstanceOf(FluentCheck::class);
    }

    public function test_has_syntactic_sugar_and_to_pipe_checks_close_to_plain_eglish()
    {
        $check = $this->checkClass();

        Check::that($check->which())->isAnInstanceOf(get_class($check))->isEqualTo($check);
    }

    public function test_has_syntactic_sugar_which_to_pipe_checks_close_to_plain_eglish()
    {
        $check = $this->checkClass();

        Check::that($check->and())->isAnInstanceOf(get_class($check))->isEqualTo($check);
    }


}