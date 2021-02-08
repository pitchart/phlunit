<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;

class IntegerCheck implements FluentCheck
{
    use TypeCheck, WithMessage;

    /**
     * @var mixed
     */
    private $value;

    /**
     * GenericCheck constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isEqualTo($expected): self
    {
        Assert::assertSame($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isNotEqualTo($expected): self
    {
        Assert::assertNotSame($expected, $this->value, $this->message);
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

    public function isGreaterThan($expected): self
    {
        Assert::assertGreaterThan($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isGreaterThanOrEqualTo($expected): self
    {
        Assert::assertGreaterThanOrEqual($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isLessThan($expected): self
    {
        Assert::assertLessThan($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isLessThanOrEqualTo($expected): self
    {
        Assert::assertLessThanOrEqual($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }
}
