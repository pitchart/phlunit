<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

class GenericCheck implements FluentCheck
{
    use TypeCheck, ConstraintCheck, WithMessage;

    /**
     * @var mixed
     */
    private $value;

    /**
     * GenericCheck constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param mixed $expected
     *
     * @return GenericCheck
     */
    public function isEqualTo($expected): self
    {
        Assert::assertSame($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    /**
     * @param mixed $expected
     *
     * @return GenericCheck
     */
    public function isNotEqualTo($expected): self
    {
        Assert::assertNotEquals($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isEmpty(): self
    {
        Assert::assertEmpty($this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isNotEmpty(): self
    {
        Assert::assertNotEmpty($this->value, $this->message);
        $this->resetMessage();
        return $this;
    }
}
