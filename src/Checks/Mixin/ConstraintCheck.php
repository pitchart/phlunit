<?php


namespace Pitchart\Phlunit\Checks\Mixin;


use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalNot;

trait ConstraintCheck
{
    public function has(Constraint $constraint): self
    {
        Assert::assertThat($this->value, $constraint);
        $this->resetMessage();
        return $this;
    }

    public function is(Constraint $constraint): self
    {
        return $this->has($constraint);
    }

    public function hasNot(Constraint $constraint): self
    {
        Assert::assertThat($this->value, new LogicalNot($constraint));
        $this->resetMessage();
        return $this;
    }

    public function isNot(Constraint $constraint): self
    {
        return $this->hasNot($constraint);
    }

}